<?php

namespace App\Services;

use App\Interfaces\AuthenticationRepositoryInterface;
use App\Services\ContactsService;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthenticationService
{
    private
    $authenticationRepository,
    $contactsService,
    $addressessService,
    $loginService;

    public function __construct(
        AuthenticationRepositoryInterface $authenticationRepository,
        ContactsService $contactsService,
        AddressesService $addressessService,
        LoginService $loginService,

    ) {
        $this->authenticationRepository = $authenticationRepository;
        $this->contactsService = $contactsService;
        $this->addressessService = $addressessService;
        $this->loginService = $loginService;

    }

    public function register($request)
    {

        $userData = $request->only('user_name', 'password', 'first_name', 'last_name', 'type', 'theme', 'company_name', 'position', 'title', 'website_url', 'primary_email', 'email');
        $contactsData = $request->only("home_number", "home_code", "office_number", "office_code", "office1_number", "office1_code", "cell_number", "cell_code");
        $addressData = $request->only("street", "street1", "city", "state", "country", "postcode", "note");
        try {
            DB::beginTransaction();
            $user = $this->authenticationRepository->register($userData);
            $user  ?   $user->token = $user->createToken('token-name', ['server:update'])->plainTextToken :null;
            $this->contactsService->handleContactsData($contactsData, $user->id);
            $this->addressessService->createAddressesData($addressData, $user->id);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            return 'faild';
        }

    }
    public function login($request)
    {
        return $this->loginService->login($request);
    }
}

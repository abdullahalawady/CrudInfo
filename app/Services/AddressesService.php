<?php

namespace App\Services;

use App\Interfaces\AddressesRepositoryInterface;

class AddressesService
{
    private $addressesRepository;
    public function __construct(AddressesRepositoryInterface $addressesRepository)
    {
        $this->addressesRepository = $addressesRepository;
    }

    public function createAddressesData($data, $id)
    {
        $data = array_merge(['user_id' => $id], $data);
        $this->addressesRepository->store($data);
    }
}

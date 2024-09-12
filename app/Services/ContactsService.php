<?php

namespace App\Services;

use App\Interfaces\ContactsRepositoryInterface;

class ContactsService
{
    private $contactsRepository;
    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }
    public function handleContactsData(array $data, int $id): void
    {
        $availablePhones = $this->getAvailablePhones($data, $id);
         $this->contactsRepository->store($availablePhones);
    }

    public function getAvailablePhones(array $data, int $id): array
    {
        $phoneTypes = ['home', 'office', 'office1', 'cell'];
        $availablePhones = [];

        foreach ($phoneTypes as $type) {
            $numberKey = "{$type}_number";
            $codeKey = "{$type}_code";

            if (!empty($data[$numberKey]) && !empty($data[$codeKey])) {
                $availablePhones[] = [
                    'user_id' => $id,
                    'number' => $data[$numberKey],
                    'code' => $data[$codeKey],
                    'contact_type' => $type,
                ];
            }
        }

       return $availablePhones;
    }
}

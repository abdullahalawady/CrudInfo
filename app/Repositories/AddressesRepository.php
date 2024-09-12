<?php

namespace App\Repositories;
use App\Interfaces\AddressesRepositoryInterface;
use App\Models\Address;
use App\Models\Contact;

class AddressesRepository implements AddressesRepositoryInterface
{
    public function store($data)
    {
      return  Address::create($data);
    }
}

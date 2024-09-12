<?php

namespace App\Repositories;
use App\Interfaces\ContactsRepositoryInterface;
use App\Models\Contact;

class ContactsRepository implements ContactsRepositoryInterface
{
    public function store($data)
    {
        Contact::insert($data);
    }
}

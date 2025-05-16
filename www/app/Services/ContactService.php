<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    public function getFilteredContacts(array $filters, int $perPage = 10)
    {
        $query = Contact::query()->select([
            'id',
            'organization_id',
            'name',
            'position',
            'phone',
            'email',
            'is_rector']);

        if (!empty($filters['search_name'])) {
            $query->where('name', 'like', '%'.$filters['search_name'].'%');
        }

        if (!empty($filters['search_email'])) {
            $query->where('email', 'like', '%'.$filters['search_email'].'%');
        }

        return $query->paginate(min($perPage, 100))->withQueryString();
    }

    public function createContact(array $data)
    {
        return Contact::create($data);
    }

    public function updateContact(Contact $contact, array $data)
    {
        return $contact->update($data);
    }

    public function deleteContact(Contact $contact)
    {
        return $contact->delete();
    }
}

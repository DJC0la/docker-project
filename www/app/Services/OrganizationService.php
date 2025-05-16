<?php

namespace App\Services;

use App\Models\Organization;

class OrganizationService
{
    public function getFilteredOrganizations(array $filters, int $perPage = 10)
    {
        $query = Organization::query()->select([
            'id',
            'name',
            'website',
            'rector_id',
            'address',
            'email',
            'telephone',
            'department']);

        if (!empty($filters['search_name'])) {
            $query->where('name', 'like', '%'.$filters['search_name'].'%');
        }

        if (!empty($filters['search_email'])) {
            $query->where('email', 'like', '%'.$filters['search_email'].'%');
        }

        return $query->paginate(min($perPage, 100))->withQueryString();
    }

    public function createOrganization(array $data)
    {
        return Organization::create($data);
    }

    public function updateOrganization(Organization $organization, array $data)
    {
        return $organization->update($data);
    }

    public function deleteOrganization(Organization $organization)
    {
        return $organization->delete();
    }
}

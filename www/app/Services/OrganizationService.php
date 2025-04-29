<?php

namespace App\Services;

use App\Models\Organization;
use App\Enums\TypesRole;

class OrganizationService
{
    public function getFilteredOrganization(int $perPage = 10)
    {
        $query = Organization::query()->select(['name',
        'website',
        'rector_id',
        'address',
        'email_verified_at',
        'telephone',
        'department']);

        return $query->paginate(min($perPage, 100))->withQueryString();
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use App\Enums\TypesRole;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organizationService
    ) {
        $this->middleware('auth');
        $this->middleware('role:'.TypesRole::ADMIN->value)->except(['index']);
    }

    public function index(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        $organizations = $showUserTable
            ? $this->organizationService->getFilteredOrganization(
                $request->input('perPage', 10)
            )
            : collect();

        return view('organization', [
            'organizations' => $organizations,
            'showUserTable' => $showUserTable
        ]);
    }
}

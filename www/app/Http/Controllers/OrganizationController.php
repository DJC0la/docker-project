<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use App\Enums\TypesRole;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organizationService
    ) {}

    public function index(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        $organizations = $showUserTable
            ? $this->organizationService->getFilteredOrganizations(
                $request->only(['search_name', 'search_email']),
                $request->input('perPage', 10)
            )
            : Organization::query()->paginate($request->input('perPage', 10));

        return view('organization', [
            'organizations' => $organizations,
            'showUserTable' => $showUserTable
        ]);
    }

    public function store(OrganizationStoreRequest $request)
    {
        $this->organizationService->createOrganization($request->validated());

        return redirect()->route('organization')
            ->with('success', 'Organization created successfully.');
    }

    public function update(OrganizationUpdateRequest $request, Organization $organization)
    {
        $this->organizationService->updateOrganization($organization, $request->validated());

        return redirect()->route('organization')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $this->organizationService->deleteOrganization($organization);

        return redirect()->route('organization')
            ->with('success', 'Organization deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Requests\FiltrationRequest;
use App\Models\Contact;
use App\Models\Organization;
use App\Services\ContactService;
use App\Services\OrganizationService;
use App\Enums\TypesRole;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService,
        private OrganizationService $organizationService
    ) {}

    public function index(FiltrationRequest $request)
    {
        $showUserTable = auth()->user()->is_hasRole(TypesRole::ADMIN);
        $validated = $request->validated();
        $contact = $showUserTable
            ? $this->contactService->getFilteredContacts(
                [
                    $validated['search_name'] ?? null,
                    $validated['search_email'] ?? null,
                ],
                $validated['perPage'] ?? 10
            )
            : Contact::query()->paginate($request->input('perPage', 10));


        return view('contact', [
            'contacts' => $contact,
            'showUserTable' => $showUserTable,
            'organizations' => $this->organizationService->getAllIds()
        ]);
    }

    public function store(ContactStoreRequest $request)
    {
        $this->contactService->createContact($request->validated());

        return redirect()->route('contact')
            ->with('success', 'Contact created successfully.');
    }

    public function update(ContactUpdateRequest $request, Contact $contact)
    {
        $this->contactService->updateContact($contact, $request->validated());

        return redirect()->route('contact')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);

        return redirect()->route('contact')
            ->with('success', 'Contact deleted successfully.');
    }
}

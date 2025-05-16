<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use \App\Models\Contact;
use App\Models\Organization;
use App\Services\ContactService;
use App\Enums\TypesRole;

class ContactController extends Controller
{
    public function __construct(
        protected ContactService $contactService
    ) {}

    public function index(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        $contact = $showUserTable
            ? $this->contactService->getFilteredContacts(
                $request->only(['search_name', 'search_email']),
                $request->input('perPage', 10)
            )
            : Contact::query()->paginate($request->input('perPage', 10));

        $organizations = Organization::all();

        return view('contact', [
            'contacts' => $contact,
            'showUserTable' => $showUserTable,
            'organizations' => $organizations
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

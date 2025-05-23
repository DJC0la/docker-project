<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Сontacts') }}
        </h2>
    </x-slot>

    @if($showUserTable)
        <div class="admin-contacts">
            <div class="py-6">
                <div class="container mx-auto px-4">
                    <!-- Форма поиска -->
                    <div class="mb-6 w-full">
                        <form action="{{ route('contact') }}" method="GET" class="flex gap-4">
                            <x-text-input
                                type="text"
                                name="search_name"
                                placeholder="Search by name"
                                value="{{ request('search_name') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-400 bg-gray-800"
                            />
                            <x-text-input
                                type="text"
                                name="search_email"
                                placeholder="Search by email"
                                value="{{ request('search_email') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-400 bg-gray-800"
                            />
                            <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                            <x-secondary-button
                                type="submit"
                                class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800"
                            >
                                Search
                            </x-secondary-button>
                        </form>
                    </div>

                    <div class="mb-6 w-full">
                        <!-- Кнопка добавления контакта -->
                        <div x-data="{ showCreateForm: false }">
                            <x-secondary-button
                                @click="showCreateForm = true"
                                class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800 mb-4"
                            >
                                Create
                            </x-secondary-button>

                            <!-- Форма добавления контакта -->
                            <div x-show="showCreateForm" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-200">Create New Contact</h3>
                                        <button @click="showCreateForm = false" class="text-gray-400 hover:text-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <form action="{{ route('contact.store') }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="organization_id_create" value="Organization" />
                                                <select
                                                    id="organization_id_create"
                                                    name="organization_id"
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    required
                                                >
                                                    @foreach($organizations as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <x-input-label for="name_create" value="Name" />
                                                <x-text-input
                                                    id="name_create"
                                                    name="name"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="position_create" value="Position" />
                                                <x-text-input
                                                    id="position_create"
                                                    name="position"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="phone_create" value="Phone" />
                                                <x-text-input
                                                    id="phone_create"
                                                    name="phone"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="email_create" value="Email" />
                                                <x-text-input
                                                    id="email_create"
                                                    name="email"
                                                    type="email"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="is_rector_create" value="Is Rector?" />
                                                <select
                                                    id="is_rector_create"
                                                    name="is_rector"
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                >
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex justify-end mt-4 space-x-2">
                                            <x-secondary-button @click="showCreateForm = false" type="button">
                                                Cancel
                                            </x-secondary-button>
                                            <x-primary-button type="submit">
                                                Create
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="w-full bg-gray-800 text-sm text-gray-400">
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">ID</th>
                            <th class="py-2 px-4 border-b text-left">Organization</th>
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            <th class="py-2 px-4 border-b text-left">Position</th>
                            <th class="py-2 px-4 border-b text-left">Phone</th>
                            <th class="py-2 px-4 border-b text-left">Email</th>
                            <th class="py-2 px-4 border-b text-left">Is Rector</th>
                            <th class="py-2 px-4 border-b text-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $contact->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $contact->organization_id ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $contact->name ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $contact->position ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $contact->phone ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $contact->email ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $contact->is_rector ? 'Yes' : 'No' }}</td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div class="flex items-center gap-2">
                                        <!-- Кнопка редактирования -->
                                        <div x-data="{ showEditForm{{ $contact->id }}: false }">
                                            <x-secondary-button
                                                @click="showEditForm{{ $contact->id }} = !showEditForm{{ $contact->id }}"
                                                class="px-3 py-1 text-xs w-20 justify-center"
                                            >
                                                Edit
                                            </x-secondary-button>

                                            <!-- Форма редактирования -->
                                            <div x-show="showEditForm{{ $contact->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Edit Contact</h3>
                                                        <button @click="showEditForm{{ $contact->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('contact.update', $contact) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label for="organization_id_{{ $contact->id }}" value="Organization" />
                                                                <select
                                                                    id="organization_id_{{ $contact->id }}"
                                                                    name="organization_id"
                                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                    required
                                                                >
                                                                    @foreach($organizations as $id => $name)
                                                                        <option value="{{ $id }}" {{ $contact->organization_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div>
                                                                <x-input-label for="name_{{ $contact->id }}" value="Name" />
                                                                <x-text-input
                                                                    id="name_{{ $contact->id }}"
                                                                    name="name"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $contact->name }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="position_{{ $contact->id }}" value="Position" />
                                                                <x-text-input
                                                                    id="position_{{ $contact->id }}"
                                                                    name="position"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $contact->position }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="phone_{{ $contact->id }}" value="Phone" />
                                                                <x-text-input
                                                                    id="phone_{{ $contact->id }}"
                                                                    name="phone"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $contact->phone }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="email_{{ $contact->id }}" value="Email" />
                                                                <x-text-input
                                                                    id="email_{{ $contact->id }}"
                                                                    name="email"
                                                                    type="email"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $contact->email }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="is_rector_{{ $contact->id }}" value="Is Rector?" />
                                                                <select
                                                                    id="is_rector_{{ $contact->id }}"
                                                                    name="is_rector"
                                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                >
                                                                    <option value="0" {{ !$contact->is_rector ? 'selected' : '' }}>No</option>
                                                                    <option value="1" {{ $contact->is_rector ? 'selected' : '' }}>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end mt-4 space-x-2">
                                                            <x-secondary-button @click="showEditForm{{ $contact->id }} = false" type="button">
                                                                Cancel
                                                            </x-secondary-button>
                                                            <x-primary-button type="submit">
                                                                Update
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Кнопка удаления -->
                                        <div x-data="{ showDeleteConfirmation{{ $contact->id }}: false }">
                                            <x-secondary-button
                                                @click="showDeleteConfirmation{{ $contact->id }} = true"
                                                class="px-3 py-1 text-xs w-20 justify-center bg-red-600 hover:bg-red-700 text-white"
                                            >
                                                Delete
                                            </x-secondary-button>

                                            <!-- Форма подтверждения удаления -->
                                            <div x-show="showDeleteConfirmation{{ $contact->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Confirm Deletion</h3>
                                                        <button @click="showDeleteConfirmation{{ $contact->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <p class="text-gray-300 mb-4">Are you sure you want to delete contact "{{ $contact->name }}"?</p>

                                                    <form action="{{ route('contact.destroy', $contact) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex justify-end space-x-2">
                                                            <x-secondary-button @click="showDeleteConfirmation{{ $contact->id }} = false" type="button">
                                                                Cancel
                                                            </x-secondary-button>
                                                            <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700">
                                                                Delete
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-between items-center">
                        <!-- Выбор количества записей -->
                        <form action="{{ route('contact') }}" method="GET" class="flex items-center gap-2">
                            @if(request('search_name'))
                                <input type="hidden" name="search_name" value="{{ request('search_name') }}">
                            @endif
                            @if(request('search_email'))
                                <input type="hidden" name="search_email" value="{{ request('search_email') }}">
                            @endif
                            <label for="perPage" class="text-sm text-gray-400">Show:</label>
                            <select
                                name="perPage"
                                id="perPage"
                                onchange="this.form.submit()"
                                class="px-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-800 text-sm text-gray-400"
                                style="text-align: left; padding-right: 2rem;"
                            >
                                <option value="5" {{ request('perPage', 10) == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('perPage', 10) == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('perPage', 10) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="text-sm text-gray-400">entries</span>
                        </form>

                        <!-- Пагинация -->
                        <div>
                            {{ $contacts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user-contacts">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>

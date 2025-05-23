<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Organizations') }}
        </h2>
    </x-slot>

    @if($showUserTable)
        <div class="admin-organizations">
            <div class="py-6">
                <div class="container mx-auto px-4">
                    <!-- Форма поиска -->
                    <div class="mb-6 w-full">
                        <form action="{{ route('organization') }}" method="GET" class="flex gap-4">
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
                        <!-- Кнопка добавления организации -->
                        <div x-data="{ showCreateForm: false }">
                            <x-secondary-button
                                @click="showCreateForm = true"
                                class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800 mb-4"
                            >
                                Create
                            </x-secondary-button>

                            <!-- Форма добавления организации -->
                            <div x-show="showCreateForm" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-200">Create New Organization</h3>
                                        <button @click="showCreateForm = false" class="text-gray-400 hover:text-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <form action="{{ route('organization.store') }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="name_create" value="Name" />
                                                <x-text-input
                                                    id="name_create"
                                                    name="name"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    required
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="website_create" value="Website" />
                                                <x-text-input
                                                    id="website_create"
                                                    name="website"
                                                    type="url"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="rector_create" value="Rector ID" />
                                                <x-text-input
                                                    id="rector_create"
                                                    name="rector_id"
                                                    type="number"
                                                    min="0"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="address_create" value="Address" />
                                                <x-text-input
                                                    id="address_create"
                                                    name="address"
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
                                                <x-input-label for="phone_create" value="Phone" />
                                                <x-text-input
                                                    id="phone_create"
                                                    name="phone"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="department_create" value="Department" />
                                                <x-text-input
                                                    id="department_create"
                                                    name="department"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                />
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
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            <th class="py-2 px-4 border-b text-left">Website</th>
                            <th class="py-2 px-4 border-b text-left">Rector ID</th>
                            <th class="py-2 px-4 border-b text-left">Address</th>
                            <th class="py-2 px-4 border-b text-left">Email</th>
                            <th class="py-2 px-4 border-b text-left">Phone</th>
                            <th class="py-2 px-4 border-b text-left">Department</th>
                            <th class="py-2 px-4 border-b text-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizations as $org)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $org->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $org->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if($org->website)
                                        <a href="{{ $org->website }}" target="_blank" class="text-blue-400 hover:underline">
                                            {{ Str::limit($org->website, 20) }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b">{{ $org->rector_id ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $org->address ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $org->email ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $org->telephone ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $org->department ?? '-' }}</td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div class="flex items-center gap-2">
                                        <!-- Кнопка редактирования -->
                                        <div x-data="{ showEditForm{{ $org->id }}: false }">
                                            <x-secondary-button
                                                @click="showEditForm{{ $org->id }} = !showEditForm{{ $org->id }}"
                                                class="px-3 py-1 text-xs w-20 justify-center"
                                            >
                                                Edit
                                            </x-secondary-button>

                                            <!-- Форма редактирования -->
                                            <div x-show="showEditForm{{ $org->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Edit Organization</h3>
                                                        <button @click="showEditForm{{ $org->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('organization.update', $org) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label for="name_{{ $org->id }}" value="Name" />
                                                                <x-text-input
                                                                    id="name_{{ $org->id }}"
                                                                    name="name"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->name }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="website_{{ $org->id }}" value="Website" />
                                                                <x-text-input
                                                                    id="website_{{ $org->id }}"
                                                                    name="website"
                                                                    type="url"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->website }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="rector_{{ $org->id }}" value="Rector ID" />
                                                                <x-text-input
                                                                    id="rector_{{ $org->id }}"
                                                                    name="rector_id"
                                                                    type="number"
                                                                    min="0"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->rector_id }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="address_{{ $org->id }}" value="Address" />
                                                                <x-text-input
                                                                    id="address_{{ $org->id }}"
                                                                    name="address"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->address }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="email_{{ $org->id }}" value="Email" />
                                                                <x-text-input
                                                                    id="email_{{ $org->id }}"
                                                                    name="email"
                                                                    type="email"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->email }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="phone_{{ $org->id }}" value="Phone" />
                                                                <x-text-input
                                                                    id="phone_{{ $org->id }}"
                                                                    name="telephone"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->telephone }}"
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="department_{{ $org->id }}" value="Department" />
                                                                <x-text-input
                                                                    id="department_{{ $org->id }}"
                                                                    name="department"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $org->department }}"
                                                                />
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end mt-4 space-x-2">
                                                            <x-secondary-button @click="showEditForm{{ $org->id }} = false" type="button">
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
                                        <div x-data="{ showDeleteConfirmation{{ $org->id }}: false }">
                                            <x-secondary-button
                                                @click="showDeleteConfirmation{{ $org->id }} = true"
                                                class="px-3 py-1 text-xs w-20 justify-center bg-red-600 hover:bg-red-700 text-white"
                                            >
                                                Delete
                                            </x-secondary-button>

                                            <!-- Форма подтверждения удаления -->
                                            <div x-show="showDeleteConfirmation{{ $org->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Confirm Deletion</h3>
                                                        <button @click="showDeleteConfirmation{{ $org->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <p class="text-gray-300 mb-4">Are you sure you want to delete organization "{{ $org->name }}"?</p>

                                                    <form action="{{ route('organization.destroy', $org) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex justify-end space-x-2">
                                                            <x-secondary-button @click="showDeleteConfirmation{{ $org->id }} = false" type="button">
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
                        <form action="{{ route('organization') }}" method="GET" class="flex items-center gap-2">
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
                            {{ $organizations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user-organizations">
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

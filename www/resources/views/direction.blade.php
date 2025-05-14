<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Directions') }}
        </h2>
    </x-slot>

    @if($showUserTable)
        <div class="admin-directions">
            <div class="py-6">
                <div class="container mx-auto px-4">
                    <!-- Search Form -->
                    <div class="mb-6 w-full">
                        <form action="{{ route('direction') }}" method="GET" class="flex gap-4">
                            <x-text-input
                                type="text"
                                name="search_code"
                                placeholder="Search by code"
                                value="{{ request('search_code') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-400 bg-gray-800"
                            />
                            <x-text-input
                                type="text"
                                name="search_name"
                                placeholder="Search by name"
                                value="{{ request('search_name') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-400 bg-gray-800"
                            />
                            <select
                                name="search_degree"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-400 bg-gray-800"
                            >
                                <option value="">All Degrees</option>
                                <option value="secondary_special" {{ request('search_degree') == 'secondary_special' ? 'selected' : '' }}>Secondary Special</option>
                                <option value="bachelor" {{ request('search_degree') == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                                <option value="specialist" {{ request('search_degree') == 'specialist' ? 'selected' : '' }}>Specialist</option>
                                <option value="master" {{ request('search_degree') == 'master' ? 'selected' : '' }}>Master</option>
                                <option value="postgraduate" {{ request('search_degree') == 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                            </select>
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
                        <!-- Create Button -->
                        <div x-data="{ showCreateForm: false }">
                            <x-secondary-button
                                @click="showCreateForm = true"
                                class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800 mb-4"
                            >
                                Create
                            </x-secondary-button>

                            <!-- Create Form -->
                            <div x-show="showCreateForm" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-200">Create New Direction</h3>
                                        <button @click="showCreateForm = false" class="text-gray-400 hover:text-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <form action="{{ route('direction.store') }}" method="POST">
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
                                                    @foreach(App\Models\Organization::all() as $org)
                                                        <option value="{{ $org->id }}">{{ $org->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <x-input-label for="code_create" value="Code" />
                                                <x-text-input
                                                    id="code_create"
                                                    name="code"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    required
                                                />
                                            </div>

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
                                                <x-input-label for="degree_create" value="Degree" />
                                                <select
                                                    id="degree_create"
                                                    name="degree"
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    required
                                                >
                                                    <option value="secondary_special">Secondary Special</option>
                                                    <option value="bachelor">Bachelor</option>
                                                    <option value="specialist">Specialist</option>
                                                    <option value="master">Master</option>
                                                    <option value="postgraduate">Postgraduate</option>
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
                            <th class="py-2 px-4 border-b text-left">Code</th>
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            <th class="py-2 px-4 border-b text-left">Degree</th>
                            <th class="py-2 px-4 border-b text-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($directions as $direction)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $direction->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $direction->organization->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $direction->code }}</td>
                                <td class="py-2 px-4 border-b">{{ $direction->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    @switch($direction->degree)
                                        @case('secondary_special') Secondary Special @break
                                        @case('bachelor') Bachelor @break
                                        @case('specialist') Specialist @break
                                        @case('master') Master @break
                                        @case('postgraduate') Postgraduate @break
                                    @endswitch
                                </td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div class="flex items-center gap-2">
                                        <!-- Edit Button -->
                                        <div x-data="{ showEditForm{{ $direction->id }}: false }">
                                            <x-secondary-button
                                                @click="showEditForm{{ $direction->id }} = !showEditForm{{ $direction->id }}"
                                                class="px-3 py-1 text-xs w-20 justify-center"
                                            >
                                                Edit
                                            </x-secondary-button>

                                            <!-- Edit Form -->
                                            <div x-show="showEditForm{{ $direction->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Edit Direction</h3>
                                                        <button @click="showEditForm{{ $direction->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('direction.update', $direction) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label for="organization_id_{{ $direction->id }}" value="Organization" />
                                                                <select
                                                                    id="organization_id_{{ $direction->id }}"
                                                                    name="organization_id"
                                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                    required
                                                                >
                                                                    @foreach(App\Models\Organization::all() as $org)
                                                                        <option value="{{ $org->id }}" {{ $org->id == $direction->organization_id ? 'selected' : '' }}>{{ $org->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div>
                                                                <x-input-label for="code_{{ $direction->id }}" value="Code" />
                                                                <x-text-input
                                                                    id="code_{{ $direction->id }}"
                                                                    name="code"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $direction->code }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="name_{{ $direction->id }}" value="Name" />
                                                                <x-text-input
                                                                    id="name_{{ $direction->id }}"
                                                                    name="name"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $direction->name }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="degree_{{ $direction->id }}" value="Degree" />
                                                                <select
                                                                    id="degree_{{ $direction->id }}"
                                                                    name="degree"
                                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                    required
                                                                >
                                                                    <option value="secondary_special" {{ $direction->degree == 'secondary_special' ? 'selected' : '' }}>Secondary Special</option>
                                                                    <option value="bachelor" {{ $direction->degree == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                                                                    <option value="specialist" {{ $direction->degree == 'specialist' ? 'selected' : '' }}>Specialist</option>
                                                                    <option value="master" {{ $direction->degree == 'master' ? 'selected' : '' }}>Master</option>
                                                                    <option value="postgraduate" {{ $direction->degree == 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end mt-4 space-x-2">
                                                            <x-secondary-button @click="showEditForm{{ $direction->id }} = false" type="button">
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

                                        <!-- Delete Button -->
                                        <div x-data="{ showDeleteConfirmation{{ $direction->id }}: false }">
                                            <x-secondary-button
                                                @click="showDeleteConfirmation{{ $direction->id }} = true"
                                                class="px-3 py-1 text-xs w-20 justify-center bg-red-600 hover:bg-red-700 text-white"
                                            >
                                                Delete
                                            </x-secondary-button>

                                            <!-- Delete Confirmation -->
                                            <div x-show="showDeleteConfirmation{{ $direction->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Confirm Deletion</h3>
                                                        <button @click="showDeleteConfirmation{{ $direction->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <p class="text-gray-300 mb-4">Are you sure you want to delete direction "{{ $direction->name }}"?</p>

                                                    <form action="{{ route('direction.destroy', $direction) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex justify-end space-x-2">
                                                            <x-secondary-button @click="showDeleteConfirmation{{ $direction->id }} = false" type="button">
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
                        <!-- Per Page Selector -->
                        <form action="{{ route('direction') }}" method="GET" class="flex items-center gap-2">
                            @if(request('search_code'))
                                <input type="hidden" name="search_code" value="{{ request('search_code') }}">
                            @endif
                            @if(request('search_name'))
                                <input type="hidden" name="search_name" value="{{ request('search_name') }}">
                            @endif
                            @if(request('search_degree'))
                                <input type="hidden" name="search_degree" value="{{ request('search_degree') }}">
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

                        <!-- Pagination -->
                        <div>
                            {{ $directions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user-directions">
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

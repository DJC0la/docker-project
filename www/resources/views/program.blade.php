<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Programs') }}
        </h2>
    </x-slot>

    @if($showUserTable)
        <div class="admin-programs">
            <div class="py-6">
                <div class="container mx-auto px-4">
                    <!-- Форма поиска -->
                    <div class="mb-6 w-full">
                        <form action="{{ route('program') }}" method="GET" class="flex gap-4">
                            <x-text-input
                                type="text"
                                name="search_name"
                                placeholder="Search by name"
                                value="{{ request('search_name') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-400 bg-gray-800"
                            />
                            <x-text-input
                                type="text"
                                name="search_direction"
                                placeholder="Search by direction"
                                value="{{ request('search_direction') }}"
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
                        <!-- Кнопка добавления программы -->
                        <div x-data="{ showCreateForm: false }">
                            <x-secondary-button
                                @click="showCreateForm = true"
                                class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800 mb-4"
                            >
                                Create
                            </x-secondary-button>

                            <!-- Форма добавления программы -->
                            <div x-show="showCreateForm" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-200">Create New Program</h3>
                                        <button @click="showCreateForm = false" class="text-gray-400 hover:text-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <form action="{{ route('program.store') }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="direction_id_create" value="Direction" />
                                                <select
                                                    id="direction_id_create"
                                                    name="direction_id"
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    required
                                                >
                                                    @foreach($directions as $direction)
                                                        <option value="{{ $direction->id }}">{{ $direction->name }}</option>
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
                                                    required
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="form_create" value="Form" />
                                                <x-text-input
                                                    id="form_create"
                                                    name="form"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    required
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="duration_create" value="Duration (years)" />
                                                <x-text-input
                                                    id="duration_create"
                                                    name="duration"
                                                    type="number"
                                                    min="1"
                                                    max="10"
                                                    class="mt-1 block w-full"
                                                    required
                                                />
                                            </div>

                                            <div>
                                                <x-input-label for="qualification_create" value="Qualification" />
                                                <x-text-input
                                                    id="qualification_create"
                                                    name="qualification"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    required
                                                />
                                            </div>

                                            <div class="flex items-center">
                                                <input type="hidden" name="is_active" value="0">
                                                <input id="is_active_create" name="is_active" type="checkbox" value="1"
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                    {{ old('is_active', false) ? 'checked' : '' }}>
                                                <x-input-label for="is_active_create" class="ml-2" value="Accreditation Status" />
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
                            <th class="py-2 px-4 border-b text-left">Direction</th>
                            <th class="py-2 px-4 border-b text-left">Form</th>
                            <th class="py-2 px-4 border-b text-left">Duration (years)</th>
                            <th class="py-2 px-4 border-b text-left">Qualification</th>
                            <th class="py-2 px-4 border-b text-left">Accreditation Status</th>
                            <th class="py-2 px-4 border-b text-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($programs as $program)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $program->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $program->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $program->direction->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $program->form }}</td>
                                <td class="py-2 px-4 border-b">{{ $program->duration }} лет</td>
                                <td class="py-2 px-4 border-b">{{ $program->qualification }}</td>
                                <td class="py-2 px-4 border-b">
                                    <span @class([
                                        'px-2 py-1 text-xs font-medium rounded-full',
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' => $program->is_active,
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' => !$program->is_active,
                                    ])>
                                        {{ $program->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div class="flex items-center gap-2">
                                        <!-- Кнопка редактирования -->
                                        <div x-data="{ showEditForm{{ $program->id }}: false }">
                                            <x-secondary-button
                                                @click="showEditForm{{ $program->id }} = !showEditForm{{ $program->id }}"
                                                class="px-3 py-1 text-xs w-20 justify-center"
                                            >
                                                Edit
                                            </x-secondary-button>

                                            <!-- Форма редактирования -->
                                            <div x-show="showEditForm{{ $program->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Edit Program</h3>
                                                        <button @click="showEditForm{{ $program->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('program.update', $program) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label for="direction_id_{{ $program->id }}" value="Direction" />
                                                                <select
                                                                    id="direction_id_{{ $program->id }}"
                                                                    name="direction_id"
                                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                    required
                                                                >
                                                                    @foreach($directions as $direction)
                                                                        <option value="{{ $direction->id }}" {{ $program->direction_id == $direction->id ? 'selected' : '' }}>{{ $direction->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div>
                                                                <x-input-label for="name_{{ $program->id }}" value="Name" />
                                                                <x-text-input
                                                                    id="name_{{ $program->id }}"
                                                                    name="name"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $program->name }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="form_{{ $program->id }}" value="Form" />
                                                                <x-text-input
                                                                    id="form_{{ $program->id }}"
                                                                    name="form"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $program->form }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="duration_{{ $program->id }}" value="Duration (years)" />
                                                                <x-text-input
                                                                    id="duration_{{ $program->id }}"
                                                                    name="duration"
                                                                    type="number"
                                                                    min="1"
                                                                    max="10"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $program->duration }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div>
                                                                <x-input-label for="qualification_{{ $program->id }}" value="Qualification" />
                                                                <x-text-input
                                                                    id="qualification_{{ $program->id }}"
                                                                    name="qualification"
                                                                    type="text"
                                                                    class="mt-1 block w-full"
                                                                    value="{{ $program->qualification }}"
                                                                    required
                                                                />
                                                            </div>

                                                            <div class="flex items-center">
                                                                <input type="hidden" name="is_active" value="0">
                                                                <input id="is_active_{{ $program->id }}" name="is_active" type="checkbox" value="1"
                                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                                    {{ old('is_active', $program->is_active ?? false) ? 'checked' : '' }}>
                                                                <x-input-label for="is_active_{{ $program->id }}" class="ml-2" value="Accreditation Status" />
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end mt-4 space-x-2">
                                                            <x-secondary-button @click="showEditForm{{ $program->id }} = false" type="button">
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
                                        <div x-data="{ showDeleteConfirmation{{ $program->id }}: false }">
                                            <x-secondary-button
                                                @click="showDeleteConfirmation{{ $program->id }} = true"
                                                class="px-3 py-1 text-xs w-20 justify-center bg-red-600 hover:bg-red-700 text-white"
                                            >
                                                Delete
                                            </x-secondary-button>

                                            <!-- Форма подтверждения удаления -->
                                            <div x-show="showDeleteConfirmation{{ $program->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Confirm Deletion</h3>
                                                        <button @click="showDeleteConfirmation{{ $program->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <p class="text-gray-300 mb-4">Are you sure you want to delete contact "{{ $program->name }}"?</p>

                                                    <form action="{{ route('program.destroy', $program) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex justify-end space-x-2">
                                                            <x-secondary-button @click="showDeleteConfirmation{{ $program->id }} = false" type="button">
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
                        <form action="{{ route('program') }}" method="GET" class="flex items-center gap-2">
                            @if(request('search_name'))
                                <input type="hidden" name="search_name" value="{{ request('search_name') }}">
                            @endif
                            @if(request('search_direction'))
                                <input type="hidden" name="search_direction" value="{{ request('search_direction') }}">
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
                            {{ $programs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user-programs">
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

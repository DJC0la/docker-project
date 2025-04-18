<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(auth()->user()->role === 'admin')
        <div class="admin-dashboard">
            <div class="py-6">
                <div class="container mx-auto px-4">
                    <!-- Форма поиска -->
                    <div class="mb-6 w-full">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-4">
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
                        <!-- Кнопка добавления пользователя -->
                        <div x-data="{ showCreateForm: false }">
                            <x-secondary-button 
                                @click="showCreateForm = true"
                                class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800 mb-4"
                            >
                                Create
                            </x-secondary-button>

                            <!-- Форма добавления пользователя -->
                            <div x-show="showCreateForm" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-200">Create New User</h3>
                                        <button @click="showCreateForm = false" class="text-gray-400 hover:text-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <form action="{{ route('users.store') }}" method="POST">
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
                                                    autocomplete="name" 
                                                />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="email_create" value="Email" />
                                                <x-text-input 
                                                    id="email_create" 
                                                    name="email" 
                                                    type="email" 
                                                    class="mt-1 block w-full" 
                                                    required 
                                                    autocomplete="email" 
                                                />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="password_create" value="Password" />
                                                <x-text-input 
                                                    id="password_create" 
                                                    name="password" 
                                                    type="password" 
                                                    class="mt-1 block w-full" 
                                                    required 
                                                    autocomplete="new-password" 
                                                />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="role_create" value="Role" />
                                                <select 
                                                    id="role_create" 
                                                    name="role" 
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                    required
                                                >
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
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

                    <div class="container mx-auto px-4">
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
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">ID</th>
                                        <th class="py-2 px-4 border-b text-left">Name</th>
                                        <th class="py-2 px-4 border-b text-left">Email</th>
                                        <th class="py-2 px-4 border-b text-left">Email verified</th>
                                        <th class="py-2 px-4 border-b text-left">Created At</th>
                                        <th class="py-2 px-4 border-b text-left">Role</th>
                                        <th class="py-2 px-4 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b">
                                    {{ $user->email_verified_at ? 'Yes' : 'No' }}
                                </td>
                                <td class="py-2 px-4 border-b">{{ $user->created_at->format('d-m-Y H:i:s') }}</td>
                                <td class="py-2 px-4 border-b">{{ $user->role }}</td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div class="flex items-center gap-2">
                                        <!-- Кнопка редактирования -->
                                        <div x-data="{ showEditForm{{ $user->id }}: false }">
                                            <x-secondary-button 
                                                @click="showEditForm{{ $user->id }} = !showEditForm{{ $user->id }}"
                                                class="px-3 py-1 text-xs w-20 justify-center"
                                            >
                                                Edit
                                            </x-secondary-button>

                                            <!-- Форма редактирования -->
                                            <div x-show="showEditForm{{ $user->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-2xl">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Edit User</h3>
                                                        <button @click="showEditForm{{ $user->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <form action="{{ route('users.update', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label for="name_{{ $user->id }}" value="Name" />
                                                                <x-text-input 
                                                                    id="name_{{ $user->id }}" 
                                                                    name="name" 
                                                                    type="text" 
                                                                    class="mt-1 block w-full" 
                                                                    value="{{ $user->name }}" 
                                                                    required 
                                                                />
                                                            </div>
                                                            
                                                            <div>
                                                                <x-input-label for="email_{{ $user->id }}" value="Email" />
                                                                <x-text-input 
                                                                    id="email_{{ $user->id }}" 
                                                                    name="email" 
                                                                    type="email" 
                                                                    class="mt-1 block w-full" 
                                                                    value="{{ $user->email }}" 
                                                                    required 
                                                                />
                                                            </div>
                                                            
                                                            <div>
                                                                <x-input-label for="password_{{ $user->id }}" value="Password" />
                                                                <x-text-input 
                                                                    id="password_{{ $user->id }}" 
                                                                    name="password" 
                                                                    type="password" 
                                                                    class="mt-1 block w-full" 
                                                                    autocomplete="new-password" 
                                                                    placeholder="Leave blank to not change"
                                                                />
                                                            </div>
                                                            
                                                            <div>
                                                                <x-input-label for="role_{{ $user->id }}" value="Role" />
                                                                <select 
                                                                    id="role_{{ $user->id }}" 
                                                                    name="role" 
                                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                >
                                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="flex justify-end mt-4 space-x-2">
                                                            <x-secondary-button @click="showEditForm{{ $user->id }} = false" type="button">
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
                                        <div x-data="{ showDeleteConfirmation{{ $user->id }}: false }">
                                            <x-secondary-button 
                                                @click="showDeleteConfirmation{{ $user->id }} = true"
                                                class="px-3 py-1 text-xs w-20 justify-center bg-red-600 hover:bg-red-700 text-white"
                                            >
                                                Delete
                                            </x-secondary-button>

                                            <!-- Форма подтверждения удаления -->
                                            <div x-show="showDeleteConfirmation{{ $user->id }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-200">Confirm Deletion</h3>
                                                        <button @click="showDeleteConfirmation{{ $user->id }} = false" class="text-gray-400 hover:text-gray-200">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <p class="text-gray-300 mb-4">Are you sure you want to delete user "{{ $user->name }}"?</p>
                                                    
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="flex justify-end space-x-2">
                                                            <x-secondary-button @click="showDeleteConfirmation{{ $user->id }} = false" type="button">
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
                            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
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
                                {{ $users->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user-dashboard">
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
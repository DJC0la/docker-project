<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if($showUserTable ?? false)
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

                <!-- добавление пользователя-->
                <div class="mb-6 w-full" x-data="{ showCreateForm: false }">
                    <x-secondary-button 
                        @click="showCreateForm = !showCreateForm"
                        class="px-4 py-2 border rounded-lg text-sm text-gray-400 bg-gray-800 mb-4"
                    >
                        <span x-text="showCreateForm ? 'cancel' : 'create'"></span>
                    </x-secondary-button>

                    <div x-show="showCreateForm" x-transition class="bg-gray-800 p-4 rounded-lg mb-6">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="name" value="Name" />
                                    <x-text-input 
                                        id="name" 
                                        name="name" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        required 
                                        autocomplete="name" 
                                    />
                                </div>
                                
                                <div>
                                    <x-input-label for="email" value="Email" />
                                    <x-text-input 
                                        id="email" 
                                        name="email" 
                                        type="email" 
                                        class="mt-1 block w-full" 
                                        required 
                                        autocomplete="email" 
                                    />
                                </div>
                                
                                <div>
                                    <x-input-label for="password" value="Password" />
                                    <x-text-input 
                                        id="password" 
                                        name="password" 
                                        type="password" 
                                        class="mt-1 block w-full" 
                                        required 
                                        autocomplete="new-password" 
                                    />
                                </div>
                                
                                <div>
                                    <x-input-label for="role" value="Role" />
                                    <select 
                                        id="role" 
                                        name="role" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    >
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-4">
                                <x-primary-button type="submit">
                                    Create
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="container mx-auto px-4">
                    <table class="w-full bg-gray-800 text-sm text-gray-400">
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Email verified</th>
                                <th class="py-2 px-4 border-b">Created At</th>
                                <th class="py-2 px-4 border-b">Role</th>
                            </tr>
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
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
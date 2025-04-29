<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Organizations') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="container mx-auto px-4">
            <table class="w-full bg-gray-800 text-sm text-gray-400">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Name</th>
                        <th class="py-2 px-4 border-b text-left">Website</th>
                        <th class="py-2 px-4 border-b text-left">Rector</th>
                        <th class="py-2 px-4 border-b text-left">Email</th>
                        <th class="py-2 px-4 border-b text-left">Phone</th>
                        <th class="py-2 px-4 border-b text-left">Department</th>
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
                        <td class="py-2 px-4 border-b">{{ $org->email ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $org->telephone ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $org->department ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $organizations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
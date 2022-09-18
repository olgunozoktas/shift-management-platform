@extends('layouts.app')

@section('content')

    @if($success = getDataFromSession('success'))
        <section>
            <div class="py-2 px-4 bg-green-600 text-white font-bold rounded-lg mb-4">{{ $success }}</div>
        </section>
    @elseif($error = getDataFromSession('error'))
        <section>
            <div class="py-2 px-4 bg-red-600 text-white font-bold rounded-lg mb-4">{{ $error }}</div>
        </section>
    @endif

    <section class="flex flex-col gap-2">
        <header class="flex flex-row items-center justify-between border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">All Folders</h1>
            <a href="{{ route('folders.create') }}"
               class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                Create New Folder
            </a>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-center bg-gray-100">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Assigned Locations</th>
                    <th scope="col" class="px-6 py-3">Files</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($folders) > 0)
                    @foreach($folders as $folder)
                        <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $folder->name }}
                            </th>
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $folder->folder_locations_count }}
                            </th>
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $folder->files_count }}
                            </th>
                            <td class="flex flex-row items-center justify-center gap-2 py-2">
                                <a href="{{ route('folders.show', $folder->id) }}"
                                   class="py-2 px-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg">Files</a>
                                <a href="{{ route('folders.edit', $folder->id) }}"
                                   class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Edit</a>
                                <button onclick="deleteFolder({{ $folder->id }})"
                                        class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="4" class="py-4">No Folders Found In System</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </section>
    </section>

    <form action="" method="POST" id="delete_folder">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function deleteFolder(id) {
            if (confirm('Would you like to delete this folder?')) {
                let route = '{{ route('folders.delete', ':id') }}';
                route = route.replace(':id', id);

                $("#delete_folder").attr('action', route).submit();
            }
        }
    </script>
@endpush

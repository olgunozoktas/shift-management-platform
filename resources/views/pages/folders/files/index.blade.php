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
            <h1 class="text-black font-black text-lg">{{ $folder->name }} > All Files</h1>
            <a href="{{ route('folders.index') }}"
               class="flex items-center gap-2 text-black font-black py-2 px-4 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back To All Folders
            </a>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 px-4">
            <div class="flex flex-col gap-4">
                <form action="{{ route('files.store', $folder->id) }}" class="flex flex-col gap-4 mt-2 mb-4"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-row items-center gap-2">
                        <input type="text" name="name"
                               class="mt-1 block w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               placeholder="Enter File Name" required>

                        <input type="file" name="file"
                               class="mt-1 block w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               placeholder="Select File" required>

                        <button type="submit"
                                class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                            Upload File
                        </button>
                    </div>

                    @error('file')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </form>


                <div class="grid grid-cols-4 gap-2 py-4">
                    <!-- Uploaded Files -->
                    @foreach($files as $file)
                        <div class="bg-white py-2 px-4 flex flex-col gap-2 shadow rounded-2xl">
                            <h1 class="text-center text-lg text-black font-medium">{{ $file->name }}</h1>
                            <a href="{{ route('files.show', $file->uuid) }}" target="_blank"
                               class="h-full aspect-w-2 aspect-h-1">
                                @if($file->type == 'image')
                                    <img src="{{ route('files.show', $file->uuid) }}" alt="" class="object-contain">
                                @elseif($file->type == 'pdf')
                                    <img src="{{ asset('logos/pdf.png') }}" alt="" class="object-contain">
                                @else
                                    <img src="{{ asset('logos/document.png.png') }}" alt="" class="object-contain">
                                @endif
                            </a>
                            <div class="flex justify-center">
                                <button onclick="deleteFile({{$file->id}})"
                                        class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-2xl">Delete File
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </section>

    <form action="" method="POST" id="delete_file">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function deleteFile(id) {
            if (confirm('Would you like to delete this file?')) {
                let route = '{{ route('files.delete', ':id') }}';
                route = route.replace(':id', id);

                $("#delete_file").attr('action', route).submit();
            }
        }
    </script>
@endpush

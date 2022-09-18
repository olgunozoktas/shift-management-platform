@extends('layouts.app')

@section('content')

    <section class="flex flex-col gap-2">
        <header class="flex flex-row items-center justify-between border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">{{ $location->name }} > All Files</h1>
            <a href="{{ route('assigned-locations.index') }}"
               class="flex items-center gap-2 text-black font-black py-2 px-4 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back To All Assigned Locations
            </a>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 px-4">
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
                    </div>
                @endforeach
            </div>
        </section>
    </section>
@endsection

@push('js')
@endpush

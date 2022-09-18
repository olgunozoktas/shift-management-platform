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
            <h1 class="text-black font-black text-lg">{{ $location->name }} Forms</h1>
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

        <section id="location-forms" data-location-id="{{ $location->id }}"></section>
    </section>
@endsection

@push('js')
    <script src="{{ asset('js/manifest.js?id=' . uniqid()) }}" defer></script>
    <script src="{{ asset('js/vendor.js?id=' . uniqid()) }}" defer></script>
    <script src="{{ asset('js/locationForms.js?id='. uniqid()) }}" defer></script>
@endpush

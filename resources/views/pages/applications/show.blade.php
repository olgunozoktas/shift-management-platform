@extends('layouts.app')

@section('content')

    <section class="flex flex-col gap-2">
        <header class="flex flex-row border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">Application > {{ $application->user->name }}
                ({{ $application->user->email }})</h1>
        </header>
        <div id="application" data-id="{{ $application->id }}"></div>
    </section>
@endsection

@push('js')
    @production
        @php
            $manifest = json_decode(file_get_contents(asset('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ asset("build/{$manifest['resources/js/application.jsx']['file']}") }}"></script>
    @else
        @vitereactrefresh
        @vite('resources/js/application')
    @endproduction
@endpush

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
        <header class="flex flex-row items-center justify-start border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">All Shift Applications</h1>
        </header>

        <div id="shift-applications"></div>
    </section>
@endsection

@push('js')
    @if(config('app.env') == 'production')
        @php
            $manifest = json_decode(file_get_contents(asset('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ asset("build/{$manifest['resources/js/shifts-requests.jsx']['file']}") }}"></script>
    @else
        @vitereactrefresh
        @vite('resources/js/shifts-requests')
    @endif
@endpush

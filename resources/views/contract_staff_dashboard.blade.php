@extends('layouts.app')

@push('css')
    <link href='{{ asset('js/fullcalendar/main.css') }}' rel='stylesheet'/>
@endpush

@section('content')
    <div class="grid grid-cols-4">
        <div class="py-2 px-4 bg-white shadow-2xl">
            <p class="text-lg font-black">Application
                Status: {{ ucfirst($application->status) }}</p>

            @if($application->isPending())
                <p class="text-red-700 font-bold">{{ $application->notes }}</p>
            @endif
        </div>
    </div>
@endsection

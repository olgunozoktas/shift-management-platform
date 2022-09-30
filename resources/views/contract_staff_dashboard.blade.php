@extends('layouts.app')

@push('css')
    <link href='{{ asset('js/fullcalendar/main.css') }}' rel='stylesheet'/>
@endpush

@section('content')
    <div class="flex flex-col justify-center gap-2 py-2 px-4 bg-white shadow-2xl rounded-lg border border-gray-200">
        <div class="flex flex-row justify-between items-center">
            <p class="text-lg font-black">Application
                Status: {{ ucfirst($application->status) }}</p>
            @if($application->isRejected())
                <a href="{{ route('applications.create') }}" class="py-2 px-4 bg-blue-500 text-white rounded-2xl">Create
                    New Application</a>
            @endif
        </div>

        @if($application->isRejected())
            <p class="text-red-700 font-bold">{{ $application->notes }}</p>
        @endif

        @if($application->isApproved())
            <p class="text-lg">Assigned Company: {{ $company->name }}</p>
            <p class="text-lg">Assigned Job Role: {{ $jobRole->definition }} (You can only see open shifts with this job role)</p>
        @endif
    </div>
@endsection

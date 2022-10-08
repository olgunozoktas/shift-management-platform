@extends('layouts.app')

@push('css')
    <link href='{{ asset('js/fullcalendar/main.css') }}' rel='stylesheet'/>
@endpush

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
            <h1 class="text-black font-black text-lg">Company Dashboard</h1>
            <a href="{{ route('shifts.create') }}"
               class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                Create New Shift
            </a>
        </header>

        <div class="flex flex-col gap-2 w-max">
            <label for="company">Select Company To List Shifts</label>
            <select name="company" id="company" onChange=""
                    class="rounded-lg">
                @foreach(getMyCompanies() as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div id='calendar' class="mt-12"></div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src='{{ asset('js/fullcalendar/main.js') }}'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: '{{ route('shifts.calendar') }}',
                    method: 'POST',
                    extraParams: {
                        _token: '{{ csrf_token() }}',
                        'company_id': $("#company").val()
                    },
                    failure: function () {
                        alert('there was an error while fetching events!');
                    },
                    color: 'yellow',   // a non-ajax option
                    textColor: 'black' // a non-ajax option
                }
            });
            calendar.render();
        });

    </script>
@endpush

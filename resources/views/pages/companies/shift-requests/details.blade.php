@extends('layouts.app')

@section('content')
    <section class="flex flex-col gap-2">
        <header class="flex flex-row items-center justify-between border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">Shift Application > {{ $shiftRequest->id }} > Details</h1>
            <a href="{{ route('shift-requests.index') }}"
               class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                Back To All Shift Applications
            </a>
        </header>

        <div class="flex flex-col gap-2">
            <div class="flex flex-col shadow">
                <h1 class="py-2 px-4 even:bg-gray-200 odd:bg-white">Applied User: {{ $shiftRequest->user->name }}</h1>
                <h1 class="py-2 px-4 even:bg-gray-200 odd:bg-white">Job
                    Role: {{ $shiftRequest->shift->jobRole->definition }}</h1>
                <h1 class="py-2 px-4 even:bg-gray-200 odd:bg-white">Shift Type: {{ $shiftRequest->shift->type }}</h1>
                <h1 class="py-2 px-4 even:bg-gray-200 odd:bg-white">Date and
                    Time: {{ $shiftRequest->shift->date_time }}</h1>
                <h1 class="py-2 px-4 even:bg-gray-200 odd:bg-white">
                    Description: {{ $shiftRequest->shift->text ?? '-'}}</h1>
            </div>

            <h1 class="text-black font-black mt-4">User Documents</h1>
            <div class="grid grid-cols-2 gap-2">
                @foreach($shiftRequest->user->userDocuments as $document)
                    <div class="flex flex-col items-center gap-4 border border-gray-200 py-4">
                        <p class="border-b border-black">{{ $document->documentType->definition }}</p>
                        @if($document->is_image)
                            <a href="{{ route('user-documents.show', $document->id) }}" target="_blank"
                               class="w-full h-48">
                                <img src="{{ route('user-documents.show', $document->id) }}" alt=""
                                     class="w-full h-full"/>
                            </a>
                        @elseif($document->is_document)
                            <a href="{{ route('user-documents.show', $document->id) }}">Download Document</a>
                        @else
                            <iframe src="{{ route('user-documents.show', $document->id) }}" frameBorder="0" class="w-full"></iframe>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="flex flex-row justify-end mt-4 gap-2">
                <button class="py-2 px-4 bg-blue-500 text-white rounded-full" onclick="approveApplication({{ $shiftRequest->id }})">Approve</button>
                <button class="py-2 px-4 bg-red-500 text-white rounded-full" onclick="rejectApplication({{ $shiftRequest->id }})">Reject</button>
            </div>
        </div>
    </section>

    <form action="{{ route('shift-requests.process') }}" class="hidden" id="processApplicationForm" method="POST">
        @method('PUT')
        @csrf
        <input type="hidden" name="application_id">
        <input type="hidden" name="status">
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function approveApplication(id) {
            if(confirm('Would you like to approve this application?')) {
                $("input[name=application_id]").val(id);
                $("input[name=status]").val('approved');
                $("#processApplicationForm").submit();
            }
        }

        function rejectApplication(id) {
            if(confirm('Would you like to reject this application?')) {
                $("input[name=application_id]").val(id);
                $("input[name=status]").val('reject');
                $("#processApplicationForm").submit();
            }
        }
    </script>
@endpush

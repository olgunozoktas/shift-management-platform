@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/selectize.default.min.css') }}">
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
            <h1 class="text-black font-black text-lg">Application</h1>
        </header>

        <form action="{{ $route }}" class="flex flex-col gap-4 mt-4" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach($documentTypes as $documentType)
                <label class="block">
                    <span class="text-gray-700">{{ $documentType->definition }}</span>
                    <input type="file" name="documents[{{ $documentType->id }}]" value=""
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           placeholder="" required>
                </label>

                @error('documents[' . $documentType->id . ']')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            @endforeach


            <div class="flex flex-row justify-end">
                <button type="submit"
                        class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                    Send Application
                </button>
            </div>
        </form>
    </section>
@endsection

@push('js')
@endpush

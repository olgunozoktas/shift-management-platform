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
            <h1 class="text-black font-black text-lg">{{ !$isEdit ? 'Create Facility Page' : 'Edit Facility Page' }}</h1>
            <a href="{{ route('facilities.index', $isEdit ? $facility->location_id : $locationId) }}"
               class="flex items-center gap-2 text-black font-black py-2 px-4 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back To Facilities
            </a>
        </header>

        <form action="{{ $route }}" class="flex flex-col gap-4 mt-4" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <label class="block">
                <span class="text-gray-700">Facility name</span>
                <input type="text" name="name" value="{{ old('name', isset($facility) ? $facility->name : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="" required>
            </label>

            @error('name')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <div class="flex flex-row justify-start">
                <button type="submit"
                        class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                    @if(!$isEdit)
                        Create Facility
                    @else
                        Update Facility
                    @endif
                </button>
            </div>
        </form>
    </section>
@endsection

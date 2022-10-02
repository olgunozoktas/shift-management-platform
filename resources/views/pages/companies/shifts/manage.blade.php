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
            <h1 class="text-black font-black text-lg">{{ !$isEdit ? 'Create New Shift' : 'Edit Shift' }}</h1>
            <a href="{{ route('shifts.index') }}"
               class="flex items-center gap-2 text-black font-black py-2 px-4 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back To All Shifts
            </a>
        </header>

        <form action="{{ $route }}" class="flex flex-col gap-4 mt-4" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <label class="block">
                <span class="text-gray-700">Company Selector</span>
                <select required name="company_id"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                                @if(old('company_id', isset($shift) ? $shift->company_id : '') == $company->id) selected @endif>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            @error('job_role_id')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Date & Time of Shift</span>
                <input type="datetime-local" name="date_time"
                       value="{{ old('date_time', isset($shift) ? $shift->date_time : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="" required>
            </label>

            @error('date_time')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Type Selector</span>
                <select required name="type"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="day"
                            @if(old('type', isset($shift) ? $shift->type : '') == 'day') selected @endif>
                        Day
                    </option>
                    <option value="evening"
                            @if(old('type', isset($shift) ? $shift->type : '') == 'evening') selected @endif>
                        Evening
                    </option>
                    <option value="night"
                            @if(old('type', isset($shift) ? $shift->type : '') == 'night') selected @endif>
                        Night
                    </option>
                </select>
            </label>

            @error('type')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Job Role Selector</span>
                <select required name="job_role_id"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($jobRoles as $jobRole)
                        <option value="{{ $jobRole->id }}"
                                @if(old('job_role_id', isset($shift) ? $shift->job_role_id : '') == $jobRole->id) selected @endif>
                            {{ $jobRole->definition }}
                        </option>
                    @endforeach
                </select>
            </label>

            @error('job_role_id')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Details</span>
                <textarea name="text"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="" required>{{ old('text', isset($shift) ? $shift->text : '') }}</textarea>
            </label>

            @error('text')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <div class="flex flex-row justify-end">
                <button type="submit"
                        class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                    @if(!$isEdit)
                        Create Shift
                    @else
                        Update Shift
                    @endif
                </button>
            </div>
        </form>
    </section>
@endsection

@push('js')
@endpush

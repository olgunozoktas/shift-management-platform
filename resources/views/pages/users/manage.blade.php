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
            <h1 class="text-black font-black text-lg">{{ !$isEdit ? 'Create New User' : 'Edit User' }}</h1>
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-2 text-black font-black py-2 px-4 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back To All Users
            </a>
        </header>

        <form action="{{ $route }}" class="flex flex-col gap-4 mt-4" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <label class="block">
                <span class="text-gray-700">Full name</span>
                <input type="text" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="" required>
            </label>

            @error('name')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Email address</span>
                <input type="email" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="john@example.com" required>
            </label>

            @error('email')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Password</span>
                <input type="password" name="password"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="************" @if(!$isEdit) required @endif>
            </label>

            @error('password')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <p class="text-lg my-4 border-b pb-2 border-gray-200">Role</p>

            <label class="block">
                <span class="text-gray-700">Role Selector</span>
                <select required name="role"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="admin"
                            @if(old('role', isset($user) ? $user->role : '') == 'user') selected @endif>
                        Admin
                    </option>
                    <option value="user"
                            @if(old('role', isset($user) ? $user->role : '') == 'user') selected @endif>
                        Normal User
                    </option>
                </select>
            </label>

            @error('role')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

{{--            <label class="block">--}}
{{--                <span class="text-gray-700">Status Selector</span>--}}
{{--                <select required name="status"--}}
{{--                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">--}}
{{--                    <option value="pending"--}}
{{--                            @if(old('status', isset($user) ? $user->status : '') == 'pending') selected @endif>--}}
{{--                        Pending--}}
{{--                    </option>--}}
{{--                    <option value="approved"--}}
{{--                            @if(old('status', isset($user) ? $user->status : '') == 'approved') selected @endif>--}}
{{--                        Approved--}}
{{--                    </option>--}}
{{--                    <option value="rejected"--}}
{{--                            @if(old('status', isset($user) ? $user->status : '') == 'rejected') selected @endif>--}}
{{--                        Rejected--}}
{{--                    </option>--}}
{{--                </select>--}}
{{--            </label>--}}

{{--            @error('status')--}}
{{--            <span class="text-red-500">{{ $message }}</span>--}}
{{--            @enderror--}}

            <label class="block">
                <span class="text-gray-700">Phone Number (Country code must be entered)</span>
                <input type="tel" name="phone_no" value="{{ old('phone_no', isset($user) ? $user->phone_no : '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="+90 533 555 444 44 44" @if(!$isEdit) required @endif>
            </label>

            @error('phone_no')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <p class="text-lg my-4 border-b pb-2 border-gray-200">Job Role and Company</p>

            <label class="block">
                <span class="text-gray-700">Company Selector</span>
                <select required name="company"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                                @if(old('company', isset($userCompany) ? $userCompany->id : '') == $company->id) selected @endif>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            @error('company')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Company Role Selector</span>
                <select required name="company_role"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="admin"
                            @if(old('company_role', isset($userCompany) ? $userCompany->company_role : '') == 'admin') selected @endif>
                        Admin (Can manage users and shifts of the company)
                    </option>
                    <option value="contract_staff"
                            @if(old('company_role', isset($userCompany) ? $userCompany->company_role : '') == 'contract_staff') selected @endif>
                        Contract Staff (Can see shifts in the company)
                    </option>
                </select>
            </label>

            @error('company_role')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <label class="block">
                <span class="text-gray-700">Job Role Selector</span>
                <select required name="job_role"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($roles as $jobRole)
                        <option value="{{ $jobRole->id }}"
                                @if(old('job_role', isset($user) ? $user->job_role_id : '') == $jobRole->id) selected @endif>
                            {{ $jobRole->definition }}
                        </option>
                    @endforeach
                </select>
            </label>

            @error('job_role')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <div class="flex flex-row justify-end">
                <button type="submit"
                        class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                    @if(!$isEdit)
                        Create User Account
                    @else
                        Update User Account
                    @endif
                </button>
            </div>
        </form>
    </section>
@endsection

@push('js')
@endpush

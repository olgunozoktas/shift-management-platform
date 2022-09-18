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
            <h1 class="text-black font-black text-lg">All Company Users</h1>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-center bg-gray-100">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email Address</th>
                    <th scope="col" class="px-6 py-3">Phone No</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($users) > 0)
                    @foreach($users as $user)
                        <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </th>
                            <td class="py-2">{{ $user->email }}</td>
                            <td class="py-2">{{ $user->company_phone_no ?? '-' }}</td>
                            <td class="py-2">{{ $user->role }}</td>
                            <td class="flex flex-row items-center justify-center gap-2 py-2">
                                <a href="{{ route('company-users.edit', $user->id) }}"
                                   class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="4" class="py-4">No Users Found For Your Company</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </section>
    </section>
@endsection

@push('js')
@endpush

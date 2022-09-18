@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endpush

@section('content')
    <table class="stripe hover" id="table" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">CodeWith</td>
            <td class="text-center">Olgun</td>
            <td class="text-center">codewitholgun@gmail.com</td>
            <td class="flex justify-center">
                <a href="" class="flex flex-row gap-2 px-4 py-2 text-white rounded-lg bg-blue-400 hover:bg-blue-500 button w-max">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            let table = $("#table").DataTable({
                info: false,
                filter: true,
                paginate: true,
                responsive: true
            })
        });
    </script>
@endpush

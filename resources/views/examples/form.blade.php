@extends('layouts.app')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="p-2 w-full">
            <div class="relative">
                <label for="" class="leading-7 text-sm text-gray-600">Name</label>
                <input type="text" id="" name="" required max="45" maxlength="45"
                       class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
        </div>
        <div class="p-2 w-full">
            <div class="relative">
                <label for="" class="leading-7 text-sm text-gray-600">Surname</label>
                <textarea id="" name="" required
                          class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
            </div>
        </div>
        <div class="p-2 w-full">
            <div class="relative">
                <label for="" class="leading-7 text-sm text-gray-600">Role</label>
                <select type="text" id="" name="" required
                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    <option value="">Test</option>
                </select>
            </div>
        </div>

        <div class="p-2 w-full">
            <button class="flex flex-row px-4 py-2 text-white rounded-lg bg-blue-400 hover:bg-blue-500 button">Save</button>
        </div>
    </form>
@endsection

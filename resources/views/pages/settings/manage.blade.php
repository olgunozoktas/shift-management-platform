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
        <form action="{{ route('settings.store') }}" class="flex flex-col gap-4 mt-4" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-start">
                <div class="mb-3 w-96">
                    <label for="logo" class="form-label inline-block mb-2 text-gray-700">Select Logo</label>
                    <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="logo" accept="image/*" name="logo" required>
                </div>
            </div>

            @error('name')
            <span class="text-red-500">{{ $message }}</span>
            @enderror

            <div class="flex justify-end">
                <button type="submit"
                        class="w-max border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                    Save Settings
                </button>
            </div>
        </form>
    </section>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        var uploadField = document.getElementById("logo");

        uploadField.onchange = function() {
            if(this.files[0].size > 2097152){
                alert("File is too big, maximum 2MB file is allowed!");
                this.value = "";
            };
        };
    </script>
@endpush

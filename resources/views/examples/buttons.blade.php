@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex flex-col divide-y divide-gray-200 gap-2 bg-white shadow-lg p-4 border border-gray-50">
            <h1 class="text-lg">Buttons</h1>
            <div class="flex flex-wrap gap-2 py-2">
                <button class="px-4 py-2 text-white rounded-lg bg-blue-400 hover:bg-blue-500 button">Info</button>
                <button class="px-4 py-2 text-white rounded-lg bg-yellow-400 hover:bg-yellow-500 button">Warning</button>
                <button class="px-4 py-2 text-white rounded-lg bg-red-400 hover:bg-red-500 button">Alert</button>
                <button class="px-4 py-2 text-white rounded-lg bg-green-400 hover:bg-green-500 button">Success</button>
            </div>
        </div>
        <div class="flex flex-col divide-y divide-gray-200 gap-2 bg-white shadow-lg p-4 border border-gray-50 mt-2">
            <h1 class="text-lg">Button with Icons</h1>
            <div class="flex flex-wrap gap-2 py-2">
                <button class="flex flex-row gap-2 px-4 py-2 text-white rounded-lg bg-blue-400 hover:bg-blue-500 button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </button>
                <button class="flex flex-row gap-2 px-4 py-2 text-white rounded-lg bg-gray-400 hover:bg-gray-500 button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Details
                </button>
                <button class="flex flex-row gap-2 px-4 py-2 text-white rounded-lg bg-red-400 hover:bg-red-500 button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
@endsection

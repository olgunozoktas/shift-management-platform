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
            <h1 class="text-black font-black text-lg">All Pending Approvals</h1>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-center bg-gray-100">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email Address</th>
                    <th scope="col" class="px-6 py-3">Documents</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($pendingApplications) > 0)
                    @foreach($pendingApplications as $pendingApplication)
                        <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $pendingApplication->user->name }}
                            </th>
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $pendingApplication->user->email }}
                            </th>
                            <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $pendingApplication->user->userDocuments?->count() ?? 0 }}
                            </th>
                            <td class="flex flex-row items-center justify-center gap-2 py-2">
                                <button onclick="approveApplication({{ $pendingApplication->id }})"
                                   class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Approve</button>
                                <button onclick="rejectApplication({{ $pendingApplication->id }})"
                                        class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg">
                                    Reject
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="4" class="py-4">No Pending Applications Found</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </section>
    </section>

    <form action="" method="POST" id="approve_application_form">
        @csrf
    </form>

    <form action="" method="POST" id="reject_application_form">
        @csrf
        <input type="hidden" name="reason" id="reason">
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function approveApplication(id) {
            if (confirm('Would you like to approve this application?')) {
                let route = '{{ route('applications.approve', ':id') }}';
                route = route.replace(':id', id);

                $("#approve_application_form").attr('action', route).submit();
            }
        }

        function rejectApplication(id) {
            if (confirm('Would you like to reject this application?')) {
                let route = '{{ route('applications.reject', ':id') }}';
                route = route.replace(':id', id);

                let reason = prompt('Please enter the reason');

                if (reason == null || reason === "") {
                    alert("You have to enter reason to reject this application");
                    return;
                }

                $("#reason").val(reason);
                $("#reject_application_form").attr('action', route).submit();
            }
        }
    </script>
@endpush

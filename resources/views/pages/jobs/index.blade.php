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
            <h1 class="text-black font-black text-lg">All Jobs</h1>
            <a href="{{ route('jobs.create') }}"
               class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                Create New Jobs
            </a>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-center bg-gray-100">
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Job Number</th>
                    <th scope="col" class="px-6 py-3">Employee Time Cards</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($jobs) > 0)
                    @foreach($jobs as $job)
                        <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="w-1/3 px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $job->job_title }}
                            </th>
                            <td class="py-2">{{ $job->formatted_job_number }}</td>
                            <td class="py-2">
                                @if($job->employee_time_cards_count > 0)
                                    <a href="{{ route('jobs.employee-time-cards.show', $job->id) }}"
                                       class="py-2 px-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg">Show</a>
                                @else
                                    Not found
                                @endif
                            </td>
                            <td class="flex flex-row items-center justify-center gap-2 py-2">
                                <a href="{{ route('jobs.edit', $job->id) }}"
                                   class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Edit</a>
                                <button onclick="deleteJob({{ $job->id }})"
                                        class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="4" class="py-4">No Jobs Found In System</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </section>
    </section>

    <form action="" method="POST" id="delete_jobs_form">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function deleteJob(id) {
            if(confirm('Would you like to delete this job?')) {
                let route = '{{ route('jobs.delete', ':id') }}';
                route = route.replace(':id', id);

                $("#delete_jobs_form").attr('action', route).submit();
            }
        }
    </script>
@endpush

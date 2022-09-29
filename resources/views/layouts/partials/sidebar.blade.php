<!-- mobile menu bar -->
<div class="bg-gray-800 text-gray-100 flex justify-between md:hidden">
    <!-- logo -->
    <a href="{{ route('home') }}" class="block p-4 text-white font-bold">{{ config('app.name') }}</a>

    <!-- mobile menu button -->
    <button class="mobile-menu-button p-4 focus:outline-none focus:bg-gray-700">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>

<!-- sidebar -->
<aside
    class="z-50 sidebar-menu bg-gray-900 text-blue-100 w-72 space-y-6 py-7 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">

    <div class="flex flex-row justify-between gap-2 space-x-2 px-6 items-center">
        <a href="{{ route('home') }}" id="sidebar-logo" class="text-white flex flex-row gap-2 items-center">
            <span class="text-lg font-bold text-center">{{ config('app.name') }}</span>
        </a>
    </div>

    <nav>
        <a class="text-gray-100 {{ getCurrentRouteName() == 'dashboard' ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center mt-2 py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
           href="{{ route('dashboard') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
            </svg>
            Dashboard
        </a>

        @if(isAdmin())
            <a class="text-gray-100 {{ in_array(getCurrentRouteName(), ['users.index','users.create','users.edit']) ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="{{ route('users.index') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Users
            </a>

            <a class="text-gray-100 {{ in_array(getCurrentRouteName(), ['job-roles.index','job-roles.create','job-roles.edit']) ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="{{ route('job-roles.index') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg>
                Job Roles
            </a>

            <a class="text-gray-100 {{ in_array(getCurrentRouteName(), ['companies.index', 'companies.create', 'companies.edit']) ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="{{ route('companies.index') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Companies
            </a>

            <a class="text-gray-100 {{ getCurrentRouteName() == 'example.table' ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pending Approvals ({{ \App\Models\User::where('status','pending')->count() }})
            </a>
        @elseif(isCompanyAdmin())
            <a class="text-gray-100 {{ in_array(getCurrentRouteName(), ['company-users.index','company-users.create','company-users.edit']) ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="{{ route('company-users.index') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Users
            </a>

            <a class="text-gray-100 {{ in_array(getCurrentRouteName(), ['shifts.index','shifts.create','shifts.edit']) ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="{{ route('shifts.index') }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Shifts
            </a>


            <a class="text-gray-100 {{ getCurrentRouteName() == 'example.table' ? 'bg-black border-l-4 border-blue-900' : 'border-l-4 border-transparent' }} flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
               href="">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pending Approvals ({{ \App\Models\User::where('status','pending')->count() }})
            </a>
        @else

        @endif

        <a class="block md:hidden text-gray-100 border-l-4 border-transparent flex items-center py-2.5 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 gap-2"
           href="{{ route('logout') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Logout
        </a>
    </nav>
</aside>



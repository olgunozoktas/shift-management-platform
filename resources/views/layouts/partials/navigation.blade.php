<nav class="hidden md:flex md:flex-row justify-between items-center bg-white w-full gap-4 shadow">
    <div class="flex flex-1 justify-end">
        <!-- Authenticated User -->
        <div class="flex flex-row items-center">
            <a href="{{ route('logout') }}"
               class="flex flex-row gap-2 items-center px-4 py-4 hover:bg-gray-200 border-l border-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </a>
        </div>
    </div>
</nav>

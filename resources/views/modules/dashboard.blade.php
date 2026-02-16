{{-- resources/views/dashboard.blade.php --}}

<x-app1>
    <div class="max-w-7xl mx-auto">
        <div class="shadow rounded-lg p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <x-page-header />

                <span class="text-sm">Welcome {{ Auth::user()->UserName }}</span>
            </div>

            <div class="flex items-center justify-center min-h-[60vh]">
                <p class="text-center text-lg font-semibold text-gray-600 bg-gray-100 px-8 py-6 rounded-lg">
                    Content will be finalized after sponsor review and approval.
                </p>
            </div>
        </div>
    </div>
</x-app1>

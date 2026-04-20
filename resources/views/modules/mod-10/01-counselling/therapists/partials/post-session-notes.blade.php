<x-app1>
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <x-page-header />
            <a href="{{ route('therap.waiting.room') }}"
                class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                Back to Waiting Room
            </a>
        </div>

        @include('modules.mod-10.01-counselling.therapists.partials.post-session-notes-form')
    </div>

</x-app1>



@php
    $embedded = $embedded ?? false;
    $oldSelected = old('selected_resources', $selectedResources);
    $returnTo = route('therapist.session.notes.edit', array_filter([
        'calendar_id' => $calendar_id,
        'embedded' => $embedded ? 1 : null,
    ]));
@endphp

<div id="session-notes-success-box"
    class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 {{ session('session_notes_success') ? '' : 'hidden' }}">
    {{ session('session_notes_success') }}
</div>

<div id="session-notes-error-box"
    class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 {{ session('session_notes_error') || $errors->any() ? '' : 'hidden' }}">
    {{ session('session_notes_error') ?: ($errors->any() ? $errors->first() : '') }}
</div>

<div class="bg-white rounded-lg p-6 shadow-sm space-y-6">
    {{-- <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Post Session Notes</h2>
            <p class="text-sm text-gray-500 mt-1">
                Session History ID: {{ $history->ID }} | Calendar ID: {{ $calendar_id }}
            </p>
        </div>

        @if ($embedded)
            <a href="{{ route('therapist.session.notes.edit', ['calendar_id' => $calendar_id]) }}" target="_top"
                class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                Open full page
            </a>
        @endif
    </div> --}}

    <form id="session-notes-form" method="POST" action="{{ route('therapist.session.notes') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="calendar_id" value="{{ $calendar_id }}">
        <input type="hidden" name="return_to" value="{{ $returnTo }}">

        <div>
            <label for="therapist_notes" class="block text-sm font-medium text-gray-700 mb-2">Session Notes</label>
            <textarea id="therapist_notes" name="therapist_notes" rows="{{ $embedded ? 6 : 8 }}" maxlength="2048"
                class="w-full rounded-md border-gray-300 px-3 py-2"
                placeholder="Write your notes here...">{{ old('therapist_notes', $history->TherapistNotes) }}</textarea>
            <p class="mt-1 text-xs text-gray-500">Maximum 2048 characters.</p>
        </div>

        <div>
            <div class="flex items-center justify-between gap-3 mb-2">
                <div>
                    <h3 class="text-sm font-medium text-gray-700">Supporting Collateral Links</h3>
                    <p class="text-xs text-gray-500">Select up to 4 files from common and private documents.</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($sessionNoteResources as $resource)
                    <label class="flex items-center justify-between gap-3 rounded-md border border-gray-200 px-3 py-3 hover:bg-gray-50">
                        <div class="flex items-center gap-3 min-w-0">
                            <input type="checkbox"
                                name="selected_resources[]"
                                value="{{ $resource['url'] }}"
                                class="session-resource-checkbox rounded border-gray-300 text-indigo-600"
                                {{ in_array($resource['url'], $oldSelected, true) ? 'checked' : '' }}>
                            <div class="min-w-0">
                                <p class="text-sm text-gray-800 truncate">{{ $resource['name'] }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $resource['type'] === 'common' ? 'Common' : 'Private' }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ $resource['url'] }}" target="_blank" class="text-xs text-blue-700 underline">Preview</a>
                    </label>
                @empty
                    <p class="text-sm text-gray-500">No collateral files found.</p>
                @endforelse
            </div>
        </div>

        <div class="flex justify-end gap-2">
            @if ($embedded)
                <button type="button" onclick="closeSessionNotesModal()"
                    class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                    Close
                </button>
            @else
                <a href="{{ route('therap.waiting.room') }}"
                    class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                    Cancel
                </a>
            @endif

            <button type="submit" id="session-notes-submit-btn"
                class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                Save Notes
            </button>
        </div>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const embeddedMode = @json($embedded);
        const form = document.getElementById('session-notes-form');
        const submitBtn = document.getElementById('session-notes-submit-btn');
        const successBox = document.getElementById('session-notes-success-box');
        const errorBox = document.getElementById('session-notes-error-box');
        const checkboxes = Array.from(document.querySelectorAll('.session-resource-checkbox'));

        function syncSelectionLimit() {
            const checked = checkboxes.filter((checkbox) => checkbox.checked);
            const limitReached = checked.length >= 4;

            checkboxes.forEach((checkbox) => {
                checkbox.disabled = !checkbox.checked && limitReached;
            });
        }

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', syncSelectionLimit);
        });

        syncSelectionLimit();

        if (!embeddedMode || !form) {
            return;
        }

        function setMessage(type, message) {
            if (type === 'success') {
                if (errorBox) {
                    errorBox.classList.add('hidden');
                }
                if (successBox) {
                    successBox.textContent = message;
                    successBox.classList.remove('hidden');
                }
                return;
            }

            if (successBox) {
                successBox.classList.add('hidden');
            }
            if (errorBox) {
                errorBox.textContent = message;
                errorBox.classList.remove('hidden');
            }
        }

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: formData,
                });

                const payload = await response.json().catch(() => ({}));

                if (!response.ok || !payload.success) {
                    const message = payload.message || 'Unable to save notes right now.';
                    setMessage('error', message);
                    return;
                }

                setMessage('success', 'Session notes saved successfully.');

                if (window.parent !== window) {
                    window.parent.postMessage({
                        type: 'session-notes-saved',
                        source: 'justmy-session-notes-embed',
                        message: 'Session notes saved successfully.',
                    }, window.location.origin);
                }
            } catch (error) {
                setMessage('error', 'Network error while saving notes.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Save Notes';
                }
            }
        });
    });
</script>
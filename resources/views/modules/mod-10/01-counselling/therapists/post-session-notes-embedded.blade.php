<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Post Session Notes</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/css/tailwind.output.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 antialiased">
    <div class="min-h-screen p-4 sm:p-6">
        @include('modules.mod-10.01-counselling.therapists.partials.post-session-notes-form', [
            'embedded' => true,
        ])
    </div>

    <script>
        function closeSessionNotesModal() {
            if (window.parent !== window) {
                window.parent.postMessage({
                    type: 'session-notes-close',
                    manual: true // ✅ ADD FLAG
                }, window.location.origin);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.get('saved') === '1') {
                window.parent.postMessage({
                    type: 'session-notes-saved',
                    message: 'Session notes saved successfully',
                }, window.location.origin);
            }
        });
        
    </script>
</body>

</html>

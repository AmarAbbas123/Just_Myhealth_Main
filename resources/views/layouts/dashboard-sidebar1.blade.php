@php
    /**
     * Unified Sidebar Renderer
     * - Uses the same professional icon system as the previous menu.
     * - Supports multi-level nested menus.
     */

    if (!function_exists('generateMenuIcon')) {
        function generateMenuIcon($displayName, $index = 0)
        {
            $key = strtolower(trim($displayName));
            // Stable hash so colors/icons don't change when menu order changes.
            $hash = abs(crc32($key));
            if ($hash === 0 && $key === '') {
                // Empty labels still get a stable hash.
                $hash = abs(crc32((string) $index));
            }
            // Tokenize words to improve keyword matching quality.
            $tokens = array_filter(preg_split('/[^a-z0-9]+/', $key));
            $tokenSet = array_flip($tokens);
            $colors = [
                ['class' => 'text-indigo-600', 'hex' => '#4f46e5'],
                ['class' => 'text-blue-600', 'hex' => '#2563eb'],
                ['class' => 'text-green-600', 'hex' => '#16a34a'],
                ['class' => 'text-pink-600', 'hex' => '#db2777'],
                ['class' => 'text-yellow-600', 'hex' => '#ca8a04'],
                ['class' => 'text-red-600', 'hex' => '#dc2626'],
                ['class' => 'text-purple-600', 'hex' => '#9333ea'],
                ['class' => 'text-teal-600', 'hex' => '#0d9488'],
                ['class' => 'text-orange-600', 'hex' => '#ea580c'],
                ['class' => 'text-lime-600', 'hex' => '#65a30d'],
            ];
            $colorInfo = $colors[$hash % count($colors)];
            $colorClass = $colorInfo['class'];
            $colorHex = $colorInfo['hex'];

            $icons = [
                'system' =>
                    '<path d="M11.983 1.644a1 1 0 00-1.966 0l-.276 1.66a6.993 6.993 0 00-2.09.867l-1.516-.879a1 1 0 00-1.366.366l-1 1.732a1 1 0 00.366 1.366l1.38.8A7.02 7.02 0 005 10c0 .87.156 1.705.435 2.472l-1.38.8a1 1 0 00-.366 1.366l1 1.732a1 1 0 001.366.366l1.516-.879c.637.37 1.33.65 2.09.867l.276 1.66a1 1 0 001.966 0l.276-1.66a6.993 6.993 0 002.09-.867l1.516.879a1 1 0 001.366-.366l1-1.732a1 1 0 00-.366-1.366l-1.38-.8A7.02 7.02 0 0015 10c0-.87-.156-1.705-.435-2.472l1.38-.8a1 1 0 00.366-1.366l-1-1.732a1 1 0 00-1.366-.366l-1.516.879a6.993 6.993 0 00-2.09-.867l-.276-1.66z"/>',
                'report' => '<path d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V7l-6-4H3z"/>',
                'space' => '<circle cx="10" cy="10" r="8"/><path d="M10 2v16M2 10h16"/>',
                'group' =>
                    '<path fill-rule="evenodd" d="M13 7a3 3 0 11-6 0 3 3 0 016 0zm-8 8a5 5 0 1110 0H5z" clip-rule="evenodd"/>',
                'message' =>
                    '<path d="M18 10c0 3.866-3.582 7-8 7a8.96 8.96 0 01-4.906-1.465L2 17l1.465-3.094A8.96 8.96 0 012 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>',
                'locator' =>
                    '<path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 4 6 10 6 10s6-6 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" clip-rule="evenodd"/>',
                'service' =>
                    '<path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V8l-5-5H4z" clip-rule="evenodd"/>',
                'business' =>
                    '<path fill-rule="evenodd" d="M4 3h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1zm3 10h6v2H7v-2z" clip-rule="evenodd"/>',
                'health' =>
                    '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>',

                'counselling' =>
                    '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>', // counseling main icon

                'bio' =>
                    '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM4 20v-1c0-2.67 5.33-4 8-4s8 1.33 8 4v1H4z"/>', // person/bio

                'qualifications' => '<path d="M4 4h16v12H4z"/><path d="M8 8h8v2H8zM8 12h5v2H8z"/>', // certificate icon

                'calendar' =>
                    '<path fill-rule="evenodd" d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm0 5v10h12V7H6z" clip-rule="evenodd"/>',

                'room' => '<path d="M4 6h16v2H4zM4 10h10v2H4zM4 14h7v2H4z"/>', // queue/list

                'history' => '<path d="M13 3a9 9 0 109 9h-2a7 7 0 11-7-7V3z"/><path d="M12 8v5l4 2"/>', // clock/history icon

                'financials' =>
                    '<path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v1h1a1 1 0 011 1v8a1 1 0 01-1 1h-1v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm2 2v10h10V7H5zm8 2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"/>',

                'registration' =>
                    '<path d="M4 4h16v12H4z"/><circle cx="8" cy="9" r="2"/><path d="M12 8h6v2h-6zM12 12h6v2h-6z"/>', // ID card

                'tasks' =>
                    '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>', // checklist/task icon

                'trainer' =>
                    '<path d="M5 3h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zm5 4a2 2 0 100 4 2 2 0 000-4z"/>',
                'dietician' =>
                    '<path d="M10 2a8 8 0 108 8A8 8 0 0010 2zm0 4a1 1 0 011 1v2h2a1 1 0 010 2h-2v2a1 1 0 01-2 0v-2H7a1 1 0 010-2h2V7a1 1 0 011-1z"/>',
                'therapy' => '<path d="M10 2a8 8 0 108 8 8 8 0 00-8-8zm0 3a5 5 0 100 10A5 5 0 0010 5z"/>',

                /* KEYWORD-BASED ICONS BELOW */
                'languages' =>
                    '<path fill-rule="evenodd" d="M10 2a8 8 0 100 16A8 8 0 0010 2zm0 2a6 6 0 015.917 5H10V4zM4.083 9A6 6 0 0110 4v5H4.083zM10 11v5a6 6 0 01-5.917-5H10zm2 0h3.917A6 6 0 0110 16v-5z" clip-rule="evenodd"/>',

                'book' =>
                    '<path fill-rule="evenodd" d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm4 10l2 2 4-4-1.4-1.4L12 11.2 11.4 10 10 11z" clip-rule="evenodd"/>',

                'questionnaire' =>
                    '<path d="M7 2h6v2h3a1 1 0 011 1v13a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1h3V2zm2 7h2v2H9V9zm0 4h2v2H9v-2zm4-4h3v2h-3V9zm0 4h3v2h-3v-2z"/>',

                'therapist search' =>
                    '<path fill-rule="evenodd" d="M8 2a4 4 0 110 8 4 4 0 010-8zm7.707 12.293L13 11.586A6 6 0 102 10a6 6 0 0011.586 1l2.707 2.707 1.414-1.414z" clip-rule="evenodd"/>',

                'sessions' =>
                    '<path fill-rule="evenodd" d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm4 10l2 2 4-4-1.4-1.4L12 11.2 11.4 10 10 11z" clip-rule="evenodd"/>',

                /* COMMON ADMIN / SYSTEM TERMS */
                'administrator dashboard' =>
                    '<path d="M4 4h5v5H4zM11 4h5v5h-5zM4 11h5v5H4zM11 11h5v5h-5z"/>', // admin dashboard grid
                'system reporting' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>', // system report doc
                'admin' =>
                    '<path d="M10 2l7 3v5c0 4.2-2.7 7.7-7 9-4.3-1.3-7-4.8-7-9V5l7-3z"/>', // shield
                'administrator' =>
                    '<path d="M10 2l7 3v5c0 4.2-2.7 7.7-7 9-4.3-1.3-7-4.8-7-9V5l7-3z"/>',
                'dashboard' =>
                    '<path d="M4 4h5v5H4zM11 4h5v5h-5zM4 11h5v5H4zM11 11h5v5h-5z"/>', // grid
                'table' =>
                    '<path d="M3 5h14v10H3z"/><path d="M3 9h14M7 5v10M12 5v10"/>', // table grid
                'table management' =>
                    '<path d="M3 5h14v10H3z"/><path d="M3 9h14M7 5v10M12 5v10"/>',
                'email' =>
                    '<path d="M3 5h14v10H3z"/><path d="M3 6l7 5 7-5"/>', // envelope
                'mail' =>
                    '<path d="M3 5h14v10H3z"/><path d="M3 6l7 5 7-5"/>',
                'auto emails' =>
                    '<path d="M3 5h14v10H3z"/><path d="M3 6l7 5 7-5"/>',
                'menu' =>
                    '<path d="M4 6h12M4 10h12M4 14h12"/>', // hamburger
                'option' =>
                    '<path d="M10 4a1 1 0 011 1v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0V8H8a1 1 0 010-2h1V5a1 1 0 011-1z"/><path d="M4 4h12v12H4z"/>',
                'menu display options' =>
                    '<path d="M4 6h12M4 10h12M4 14h12"/><path d="M10 4a1 1 0 011 1v1h1a1 1 0 010 2h-1v1a1 1 0 01-2 0V8H8a1 1 0 010-2h1V5a1 1 0 011-1z"/>',
                'setting' =>
                    '<path d="M11.983 1.644a1 1 0 00-1.966 0l-.276 1.66a6.993 6.993 0 00-2.09.867l-1.516-.879a1 1 0 00-1.366.366l-1 1.732a1 1 0 00.366 1.366l1.38.8A7.02 7.02 0 005 10c0 .87.156 1.705.435 2.472l-1.38.8a1 1 0 00-.366 1.366l1 1.732a1 1 0 001.366.366l1.516-.879c.637.37 1.33.65 2.09.867l.276 1.66a1 1 0 001.966 0l.276-1.66a6.993 6.993 0 002.09-.867l1.516.879a1 1 0 001.366-.366l1-1.732a1 1 0 00-.366-1.366l-1.38-.8A7.02 7.02 0 0015 10c0-.87-.156-1.705-.435-2.472l1.38-.8a1 1 0 00.366-1.366l-1-1.732a1 1 0 00-1.366-.366l-1.516.879a6.993 6.993 0 00-2.09-.867l-.276-1.66z"/>',
                'status' =>
                    '<path d="M4 12l3 3 9-9"/>', // checkmark
                'therapists status' =>
                    '<path d="M4 12l3 3 9-9"/>',
                'onboard' =>
                    '<path d="M4 6h12v8H4z"/><path d="M8 10h4"/>', // card
                'onboarding' =>
                    '<path d="M4 6h12v8H4z"/><path d="M8 10h4"/>',
                'therapists onboarding' =>
                    '<path d="M4 6h12v8H4z"/><path d="M8 10h4"/>',
                'user' =>
                    '<path d="M10 10a3 3 0 100-6 3 3 0 000 6z"/><path d="M4 18a6 6 0 0112 0"/>', // user
                'number' =>
                    '<path d="M6 4h8M5 8h10M4 12h12M3 16h14"/>', // list/count
                'user numbers' =>
                    '<path d="M6 4h8M5 8h10M4 12h12M3 16h14"/>',
                'report' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>', // report doc
                'manage' =>
                    '<path d="M6 4h8M6 8h8M6 12h8M6 16h8"/>', // management list
                'therapists management' =>
                    '<path d="M6 4h8M6 8h8M6 12h8M6 16h8"/>',
                'finance reports' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>',

                /* REPORTING / ANALYTICS */
                'reporting' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>', // report doc
                'report' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>',
                'analytics' =>
                    '<path d="M4 14h3V8H4v6zm5 0h3V5H9v9zm5 0h3V10h-3v4z"/>', // bar chart
                'statistics' =>
                    '<path d="M4 14h3V8H4v6zm5 0h3V5H9v9zm5 0h3V10h-3v4z"/>',
                'stats' =>
                    '<path d="M4 14h3V8H4v6zm5 0h3V5H9v9zm5 0h3V10h-3v4z"/>',
                'summary' =>
                    '<path d="M4 5h12v10H4z"/><path d="M6 8h8M6 11h5"/>', // summary card
                'insight' =>
                    '<path d="M10 3a7 7 0 100 14 7 7 0 000-14z"/><path d="M10 6v4l3 2"/>', // clock/insight

                /* REGISTRATION / BOOKINGS / NOTES */
                'register' =>
                    '<path d="M4 4h16v12H4z"/><circle cx="8" cy="9" r="2"/><path d="M12 8h6v2h-6zM12 12h6v2h-6z"/>', // ID card
                'enroll' =>
                    '<path d="M4 4h16v12H4z"/><circle cx="8" cy="9" r="2"/><path d="M12 8h6v2h-6zM12 12h6v2h-6z"/>',
                'appointment' =>
                    '<path d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm0 5v10h12V7H6z" clip-rule="evenodd"/>',
                'booking' =>
                    '<path d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm0 5v10h12V7H6z" clip-rule="evenodd"/>',
                'notebook' =>
                    '<path d="M5 3h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/><path d="M7 6h6M7 9h6M7 12h4"/>', // notebook
                'note' =>
                    '<path d="M5 3h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/><path d="M7 6h6M7 9h6M7 12h4"/>',
                'notes' =>
                    '<path d="M5 3h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/><path d="M7 6h6M7 9h6M7 12h4"/>',
                'log' =>
                    '<path d="M5 3h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/><path d="M7 6h6M7 9h6M7 12h4"/>',
                'logs' =>
                    '<path d="M5 3h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/><path d="M7 6h6M7 9h6M7 12h4"/>',

                /* SERVICES / SUPPORT */
                'services' =>
                    '<path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V8l-5-5H4z" clip-rule="evenodd"/>',
                'service' =>
                    '<path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V8l-5-5H4z" clip-rule="evenodd"/>',
                    '<path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V8l-5-5H4z" clip-rule="evenodd"/>',
                'user services' =>
                    '<path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V8l-5-5H4z" clip-rule="evenodd"/>',
                'wellness services' =>
                    '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>',
                'support' =>
                    '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>', // person/support
                'help' =>
                    '<path d="M10 3a7 7 0 100 14 7 7 0 000-14z"/><path d="M8.5 8a2 2 0 114 0c0 1.5-2 1.5-2 3"/><circle cx="10" cy="13.5" r="1"/>', // help
                'ticket' =>
                    '<path d="M4 7h12v6H4z"/><path d="M7 4h6M7 16h6"/>',

                /* FINANCE / BILLING */
                'billing' =>
                    '<path d="M4 4h12l2 4v8H4z"/><path d="M7 10h6M7 13h4"/>', // invoice
                'invoice' =>
                    '<path d="M4 4h12l2 4v8H4z"/><path d="M7 10h6M7 13h4"/>',
                'payment' =>
                    '<path d="M3 6h14v8H3z"/><path d="M5 10h6"/>', // card
                'payments' =>
                    '<path d="M3 6h14v8H3z"/><path d="M5 10h6"/>',
                'revenue' =>
                    '<path d="M4 14h3V8H4v6zm5 0h3V5H9v9zm5 0h3V10h-3v4z"/>', // bar chart
                'expense' =>
                    '<path d="M5 4h10v12H5z"/><path d="M7 7h6M7 10h6M7 13h4"/>', // receipt
                'expenses' =>
                    '<path d="M5 4h10v12H5z"/><path d="M7 7h6M7 10h6M7 13h4"/>',
                'insurance' =>
                    '<path d="M10 2l7 3v5c0 4.2-2.7 7.7-7 9-4.3-1.3-7-4.8-7-9V5l7-3z"/>', // shield
                'claim' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>',
                'claims' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>',

                /* HEALTHCARE TERMS */
                'therapist' =>
                    '<path d="M10 10a3 3 0 100-6 3 3 0 000 6z"/><path d="M4 18a6 6 0 0112 0"/>',
                'therapists' =>
                    '<path d="M10 10a3 3 0 100-6 3 3 0 000 6z"/><path d="M4 18a6 6 0 0112 0"/>',
                'patient' =>
                    '<path d="M10 10a3 3 0 100-6 3 3 0 000 6z"/><path d="M4 18a6 6 0 0112 0"/>',
                'patients' =>
                    '<path d="M10 10a3 3 0 100-6 3 3 0 000 6z"/><path d="M4 18a6 6 0 0112 0"/>',
                'doctor' =>
                    '<path d="M8 3h4v4h4v4h-4v4H8v-4H4V7h4V3z"/>', // medical cross
                'clinic' =>
                    '<path d="M4 4h12v12H4z"/><path d="M8 7h4v2H8zM8 11h4v2H8z"/>', // building
                'medicine' =>
                    '<path d="M6 4h8v12H6z"/><path d="M6 10h8"/>', // pill/bottle
                'pharmacy' =>
                    '<path d="M8 3h4v4h4v4h-4v4H8v-4H4V7h4V3z"/>', // medical cross
                'lab' =>
                    '<path d="M7 3h6v2h-1v4l3 6H5l3-6V5H7V3z"/>', // flask
                'test' =>
                    '<path d="M7 3h6v2h-1v4l3 6H5l3-6V5H7V3z"/>',
                'result' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>',
                'results' =>
                    '<path d="M4 4h10l4 4v8H4z"/><path d="M6 12h8M6 9h5"/>',
                'prescription' =>
                    '<path d="M5 4h8a3 3 0 010 6H9v6H5z"/><path d="M11 12l4 4M15 12l-4 4"/>',
                'vital' =>
                    '<path d="M2 10h4l2-4 3 8 2-4h4"/>', // ECG
                'vitals' =>
                    '<path d="M2 10h4l2-4 3 8 2-4h4"/>',
            ];

            foreach ($icons as $keyword => $svg) {
                // Use the first matching keyword icon.
                if ((str_contains($keyword, ' ') && str_contains($key, $keyword)) || isset($tokenSet[$keyword]) || str_contains($key, $keyword)) {
                    return "<svg class='w-5 h-5 {$colorClass} flex-shrink-0' style='color: {$colorHex}; width:18px; height:18px;' xmlns='http://www.w3.org/2000/svg' fill='currentColor' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 20 20'>{$svg}</svg>";
                }
            }

            // Fallback icons (stable but varied by name hash).
            $fallbacks = [
                '<path d="M4 6h16M4 10h16M4 14h16"/>',
                '<circle cx="10" cy="10" r="8"/>',
                '<rect x="4" y="4" width="12" height="12" rx="2"/>',
                '<path d="M10 2v16M2 10h16"/>',
                '<path d="M6 4h8l4 6-4 6H6L2 10l4-6z"/>', // hexagon-ish
                '<path d="M3 10h14M10 3v14"/><path d="M6 6l8 8M14 6l-8 8"/>', // plus + x
                '<path d="M4 5h12l2 5-2 5H4L2 10l2-5z"/>', // badge
                '<path d="M5 4h10l-1 12H6L5 4z"/>', // shield-ish
                '<path d="M5 6h10M5 10h10M7 14h6"/>', // list with short line
                '<path d="M6 3h8l3 3v8l-3 3H6l-3-3V6l3-3z"/>', // octagon
                '<path d="M4 7h12v6H4z"/><path d="M7 4h6M7 16h6"/>', // ticket
                '<path d="M4 12l6-8 6 8H4z"/><path d="M6 12v4h8v-4"/>', // home-ish
            ];
            $fallbackSvg = $fallbacks[$hash % count($fallbacks)];
            return "<svg class='w-5 h-5 {$colorClass} flex-shrink-0' style='color: {$colorHex}; width:18px; height:18px;' xmlns='http://www.w3.org/2000/svg' fill='currentColor' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 20 20'>{$fallbackSvg}</svg>";
        }
    }

    // Group items by Grouping column if it exists
    $groupKey = $menuItems->first() && isset($menuItems->first()->Grouping) ? 'Grouping' : null;
    $sections = $groupKey ? $menuItems->groupBy($groupKey) : collect(['' => $menuItems]);
    $index = 0;
@endphp

<ul class="mt-6 text-gray-800 dark:text-gray-200 sidebar-menu">

    @php

        /* ---------- 1) Always hidden deep-restricted therapy types ---------- */
        $restrictedNames = [
            'Cognitive Behavioral Therapy (CBT)',
            'Psychodynamic Therapy',
            'Humanistic Therapy',
            'Couples Therapy',
        ];

        /* ---------- 2) Conditionally hidden menu items (hide in case 1 & 2) ---------- */
        $hideUntilOnboardComplete = ['History', 'Dietitian', 'Messages'];

        $isCounsellingMenu = function ($item) {
            $name = strtolower(trim($item->DisplayName));

            // Match counselling-related menus for special rules below.
            return str_contains($name, 'counselling') ||
                str_contains($name, 'therapy') ||
                str_contains($name, 'session') ||
                str_contains($name, 'therapist') ||
                str_contains($name, 'questionnaire');
        };

        $lockRecursive = function ($items) use (
            &$lockRecursive,
            $restrictedNames,
            $hideUntilOnboardComplete,
            $isCounsellingMenu,
            $qcStatus,
            $hasOnboardRow,
            $userType,
        ) {
            return $items
                ->map(function ($item) use (
                    $lockRecursive,
                    $restrictedNames,
                    $hideUntilOnboardComplete,
                    $isCounsellingMenu,
                    $qcStatus,
                    $hasOnboardRow,
                    $userType,
                ) {
                    $name = trim($item->DisplayName);
                    $item->isLocked = false;

                    // Hide menu items with empty display names
                    if (empty($name)) {
                        return null;
                    }

                    /** 1️⃣ Always remove deeply restricted therapy types */
                    if (in_array($name, $restrictedNames)) {
                        return null;
                    }

                    /** 2️⃣ Lock items until onboarding complete (case 1 & 2) */
                    if (($userType == 1 && !$hasOnboardRow) || ($hasOnboardRow && $qcStatus == 0)) {
                        if (in_array($name, $hideUntilOnboardComplete)) {
                            $item->isLocked = true;
                            $item->children = collect();
                            return $item;
                        }
                    }

                    /** 3️⃣ Recurse into children */
                    if ($item->children && $item->children->isNotEmpty()) {
                        $item->children = $lockRecursive($item->children)->filter()->values();
                    }

                    /** 4️⃣ Apply counselling-specific leaf rules */
                    if ($userType == 1 && $item->children->isEmpty() && $isCounsellingMenu($item)) {
                        if (!$hasOnboardRow && !in_array($name, ['Therapy Types', 'Purchase Sessions'])) {
                            $item->isLocked = true;
                        }

                        if ($hasOnboardRow && $qcStatus == 0 && $name !== 'Support Questionnaire') {
                            $item->isLocked = true;
                        }
                    }

                    /** 5️⃣ Keep parent if children exist */
                    if ($item->children && $item->children->isNotEmpty()) {
                        return $item;
                    }

                    /** 6️⃣ Keep leaf */
                    return $item;
                })
                ->filter()
                ->values();
        };

        $menuItems = $lockRecursive($menuItems);

        /* ---------- 2) Convert any "Therapy Types" node into a normal clickable item ---------- */
        $convertTherapy = function ($items) use (&$convertTherapy) {
            foreach ($items as $item) {
                if (trim($item->DisplayName) === 'Therapy Types') {
                    // set requested URL and clear children
                    $item->MenuURL = route('home') . '/mod-10/01/usr-therapy-types';
                    $item->children = collect(); // remove children so it's rendered as a link
        } elseif ($item->children && $item->children->isNotEmpty()) {
            $convertTherapy($item->children);
        }
    }
};

$convertTherapy($menuItems);
/* ---------- 3) Recursive renderer (uses <details>/<summary> for parents so items are collapsed by default) ---------- */
$renderMenu = function ($items, $level = 0) use (&$renderMenu) {
    static $i = 0;
    foreach ($items as $item) {
        $isLocked = (bool) ($item->isLocked ?? false);
        echo '<li class="mb-1">';
        if (!$isLocked && $item->children->isNotEmpty()) {
            // Parent node: collapsible group.
            echo '<details class="group">';
            echo '<summary class="sidebar-link flex items-center justify-between cursor-pointer" data-tooltip="' . e($item->DisplayName) . '">';
            echo "<div class='flex items-center gap-2 min-w-0'>";
            echo generateMenuIcon($item->DisplayName, $i++);
            echo '<span class="sidebar-label">' . e($item->DisplayName) . '</span>';
            echo '</div>';
            echo "<span class='arrow text-gray-400 transition-transform duration-200 group-open:rotate-90 ml-1' aria-hidden='true'>▶</span>";
            echo '</summary>';
            echo "<ul class='sidebar-submenu-panel ml-" .
                (4 + $level * 2) .
                " pl-2 border-l border-gray-200 dark:border-gray-700 mt-1 space-y-1'>";
            $renderMenu($item->children, $level + 1);
            echo '</ul>';
            echo '</details>';
        } else {
            if ($isLocked) {
                // Locked patient menu item: visible, greyed out, and non-functional.
                echo '<span class="sidebar-link sidebar-link--locked" aria-disabled="true" data-tooltip="' . e($item->DisplayName) . ' — Locked">';
                echo generateMenuIcon($item->DisplayName, $i++);
                echo '<span class="sidebar-label">' . e($item->DisplayName) . '</span></span>';
            } else {
                // Leaf node: normal clickable link.
                echo '<a href="' . url(trim($item->MenuURL ?? '#', '/')) . '" class="sidebar-link" data-tooltip="' . e($item->DisplayName) . '">';
                echo generateMenuIcon($item->DisplayName, $i++);
                echo '<span class="sidebar-label">' . e($item->DisplayName) . '</span></a>';
            }
        }
        echo '</li>';
            }
        };

        $renderMenu($menuItems);
    @endphp
</ul>

<style>
    /* Prevent any horizontal scroll inside sidebar */
    aside.z-20 {
        overflow-x: clip !important;
    }

    aside.z-20::-webkit-scrollbar:horizontal {
        display: none;
        height: 0;
    }

    .sidebar-menu-wrap,
    .sidebar-menu {
        max-width: 100%;
        overflow-x: clip;
    }

    /* Sidebar link styling */
    .sidebar-link {
        @apply flex items-center gap-2 px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 w-full max-w-full whitespace-nowrap overflow-hidden hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-gray-700 dark:hover:text-indigo-400;
        display: flex;
        align-items: center;
        margin-bottom: 6px;
        box-sizing: border-box;
    }

    /* Sidebar icons */
    .sidebar-link svg {
        @apply w-[18px] h-[18px] flex-shrink-0 inline-block align-middle;
        margin-right: 6px;
    }

    /* Sidebar text */
    .sidebar-link .sidebar-label {
        @apply text-gray-700 dark:text-gray-200;
        display: block;
        vertical-align: middle;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        min-width: 0;
        flex: 1 1 auto;
    }

    /* Active link */
    .sidebar-link.active {
        @apply bg-indigo-100 text-indigo-700 dark:bg-gray-700 dark:text-indigo-400;
    }

    .sidebar-link--locked {
        cursor: not-allowed;
        pointer-events: none;
        opacity: 0.45;
        filter: grayscale(1) blur(0.35px);
        color: #9ca3af !important;
        background: transparent !important;
    }

    .sidebar-link--locked svg,
    .sidebar-link--locked .sidebar-label {
        color: #9ca3af !important;
    }

    /* Collapsed sidebar: icon-only mode */
    aside.sidebar-collapsed {
        overflow-x: clip !important;
        overflow-y: auto;
    }

    aside.sidebar-collapsed::-webkit-scrollbar:horizontal {
        display: none;
        height: 0;
    }

    aside.sidebar-collapsed > div {
        margin-left: 0 !important;
        overflow-x: clip;
    }

    aside.sidebar-collapsed .sidebar-menu {
        overflow-x: clip;
    }

    aside.sidebar-collapsed .sidebar-menu > li {
        overflow: visible;
    }

    aside.sidebar-collapsed .sidebar-menu > li > .sidebar-link,
    aside.sidebar-collapsed .sidebar-menu > li > details.group > summary.sidebar-link {
        justify-content: center;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        position: relative;
        overflow: visible;
        min-height: 2.5rem;
        width: 100%;
        max-width: 100%;
        gap: 0;
    }

    /* Icon centered full-width — same as items without submenu */
    aside.sidebar-collapsed .sidebar-menu > li > details.group > summary.sidebar-link > div {
        flex: none;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        min-width: 0;
    }

    aside.sidebar-collapsed .sidebar-menu > li > .sidebar-link > svg,
    aside.sidebar-collapsed .sidebar-menu > li > details.group > summary.sidebar-link > div > svg {
        width: 18px !important;
        height: 18px !important;
        margin: 0 !important;
        flex-shrink: 0;
    }

    aside.sidebar-collapsed .sidebar-menu > li > .sidebar-link .sidebar-label,
    aside.sidebar-collapsed .sidebar-menu > li > details.group > summary.sidebar-link .sidebar-label {
        display: none !important;
    }

    /* Submenu arrow — corner badge, does not squeeze the main icon */
    aside.sidebar-collapsed .sidebar-menu > li > details.group > summary.sidebar-link .arrow {
        display: block !important;
        position: absolute;
        bottom: 2px;
        right: 1px;
        margin: 0;
        font-size: 0.45rem;
        line-height: 1;
        opacity: 0.8;
        flex-shrink: 0;
        pointer-events: none;
    }

    aside.sidebar-collapsed .sidebar-menu > li > details.group {
        position: static;
    }

    /* Flyout submenu panel (moved to body via JS when open) */
    ul.sidebar-submenu-panel.sidebar-flyout-active {
        position: fixed;
        top: 0;
        left: 0;
        min-width: 240px;
        max-width: 300px;
        max-height: min(80vh, 520px);
        overflow-y: auto;
        overflow-x: hidden;
        width: max-content;
        margin: 0 !important;
        padding: 0.5rem 0;
        border-radius: 0.75rem;
        background: white;
        border: 1px solid #e5e7eb;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.18);
        z-index: 9998;
        white-space: normal;
        list-style: none;
    }

    .dark ul.sidebar-submenu-panel.sidebar-flyout-active {
        background: #1f2937;
        border-color: #374151;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active .sidebar-link {
        justify-content: flex-start;
        padding-left: 1rem;
        padding-right: 1rem;
        overflow: visible;
        white-space: nowrap;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active .sidebar-link .sidebar-label {
        display: inline-block !important;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active .sidebar-link svg {
        margin-right: 0.75rem;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active .sidebar-submenu-panel {
        margin-left: 0.75rem !important;
        padding-left: 0.5rem !important;
        border-left: 1px solid #e5e7eb !important;
    }

    .dark ul.sidebar-submenu-panel.sidebar-flyout-active .sidebar-submenu-panel {
        border-left-color: #374151 !important;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active details.group > summary.sidebar-link {
        justify-content: space-between;
        padding-right: 0.75rem;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active details.group > summary.sidebar-link .arrow {
        display: block !important;
        font-size: 0.75rem;
        margin-left: auto;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active details.group > ul {
        position: relative;
        display: none;
        box-shadow: none;
        border: none;
        padding: 0;
        margin: 0 0 0 0.75rem;
        min-width: 0;
        max-width: none;
    }

    ul.sidebar-submenu-panel.sidebar-flyout-active details.group[open] > ul {
        display: block;
    }

    /* Hide flyout while closed (not portaled) */
    aside.sidebar-collapsed .sidebar-menu > li > details.group:not([open]) > ul.sidebar-submenu-panel {
        display: none !important;
    }

    /* Details summary for main items with submenus */
    details.group>summary.sidebar-link {
        justify-content: space-between;
        width: 100%;
        max-width: 100%;
        padding-right: 0.4rem;
        overflow: hidden;
        box-sizing: border-box;
    }

    details.group>summary.sidebar-link > div {
        min-width: 0;
        flex: 1 1 auto;
        overflow: hidden;
    }

    /* Arrow icon at the end of summary (expanded sidebar) */
    details.group>summary.sidebar-link .arrow {
        margin-left: auto;
        font-size: 0.75rem;
        opacity: 0.9;
        flex-shrink: 0;
    }

    /* Icons inside summary (excluding arrow) */
    details.group>summary.sidebar-link svg:not(.arrow) {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    /* Text inside summary */
    details.group>summary.sidebar-link .sidebar-label {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Submenu ul spacing */
    details.group>ul {
        overflow-x: hidden;
        max-width: 100%;
    }

    /* Sidebar menu list */
    .sidebar-menu {
        max-width: 100%;
        overflow-x: hidden;
    }

    .sidebar-menu > li {
        max-width: 100%;
        overflow: hidden;
    }
</style>

<div id="sidebar-flyout-tooltip" class="sidebar-flyout-tooltip" role="tooltip" aria-hidden="true">
    <span class="sidebar-flyout-tooltip__text"></span>
</div>

<style>
    .sidebar-flyout-tooltip {
        position: fixed;
        z-index: 9999;
        display: none;
        pointer-events: none;
        padding: 0.5rem 0.875rem;
        background: #1F9CA1;
        color: #fff;
        font-size: 0.8125rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        line-height: 1.25;
        border-radius: 0.5rem;
        box-shadow: 0 8px 24px rgba(31, 156, 161, 0.35), 0 2px 8px rgba(15, 23, 42, 0.12);
        white-space: nowrap;
        max-width: 240px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-flyout-tooltip.is-visible {
        display: block;
    }

    .sidebar-flyout-tooltip::before {
        content: '';
        position: absolute;
        left: -5px;
        top: 50%;
        transform: translateY(-50%);
        border-width: 5px 5px 5px 0;
        border-style: solid;
        border-color: transparent #1F9CA1 transparent transparent;
    }

    .sidebar-flyout-tooltip.is-left::before {
        left: auto;
        right: -5px;
        border-width: 5px 0 5px 5px;
        border-color: transparent transparent transparent #1F9CA1;
    }

    .dark .sidebar-flyout-tooltip {
        background: #1F9CA1;
        box-shadow: 0 8px 24px rgba(31, 156, 161, 0.45), 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .dark .sidebar-flyout-tooltip::before {
        border-color: transparent #1F9CA1 transparent transparent;
    }

    .dark .sidebar-flyout-tooltip.is-left::before {
        border-color: transparent transparent transparent #1F9CA1;
    }
</style>

<script>
    (function () {
        const tooltip = document.getElementById('sidebar-flyout-tooltip');
        if (!tooltip) return;

        if (!tooltip.dataset.bound) {
            document.body.appendChild(tooltip);
            tooltip.dataset.bound = '1';
        }

        const tooltipText = tooltip.querySelector('.sidebar-flyout-tooltip__text');
        let activeLink = null;

        function isSidebarCollapsed() {
            return document.querySelector('aside.sidebar-collapsed') !== null;
        }

        function hideTooltip() {
            tooltip.classList.remove('is-visible', 'is-left');
            tooltip.setAttribute('aria-hidden', 'true');
            activeLink = null;
        }

        function showTooltip(link) {
            if (!isSidebarCollapsed()) return hideTooltip();

            const text = link.getAttribute('data-tooltip');
            if (!text) return hideTooltip();

            if (link.tagName === 'SUMMARY' && link.closest('details.group[open]')) {
                return hideTooltip();
            }

            activeLink = link;
            tooltipText.textContent = text;
            tooltip.classList.add('is-visible');
            tooltip.classList.remove('is-left');
            tooltip.setAttribute('aria-hidden', 'false');

            const rect = link.getBoundingClientRect();
            tooltip.style.visibility = 'hidden';
            tooltip.classList.add('is-visible');
            const tipRect = tooltip.getBoundingClientRect();
            tooltip.style.visibility = 'visible';

            let left = rect.right + 10;
            let top = rect.top + (rect.height / 2) - (tipRect.height / 2);
            let flipLeft = false;

            if (left + tipRect.width > window.innerWidth - 8) {
                left = rect.left - tipRect.width - 10;
                flipLeft = true;
            }
            top = Math.max(8, Math.min(top, window.innerHeight - tipRect.height - 8));

            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';
            tooltip.classList.toggle('is-left', flipLeft);
        }

        function getFlyoutPanel(details) {
            const id = details.dataset.flyoutId;
            if (id) {
                const portaled = document.querySelector('ul.sidebar-submenu-panel[data-flyout-id="' + id + '"]');
                if (portaled) return portaled;
            }
            return details.querySelector(':scope > ul.sidebar-submenu-panel');
        }

        function isTopLevelFlyout(details) {
            return details.matches('.sidebar-menu > li > details.group');
        }

        function portalFlyoutBack(details, ul) {
            if (!details || !ul || ul.dataset.portaled !== '1') return;
            details.appendChild(ul);
            ul.dataset.portaled = '0';
            ul.classList.remove('sidebar-flyout-active');
            ul.style.cssText = '';
        }

        function positionFlyoutSubmenu(details) {
            if (!isTopLevelFlyout(details)) return;

            const ul = getFlyoutPanel(details);
            const summary = details.querySelector(':scope > summary');
            if (!ul || !summary) return;

            if (!isSidebarCollapsed()) {
                portalFlyoutBack(details, ul);
                return;
            }

            if (!details.open) {
                portalFlyoutBack(details, ul);
                return;
            }

            if (ul.dataset.portaled !== '1') {
                document.body.appendChild(ul);
                ul.dataset.portaled = '1';
            }

            ul.classList.add('sidebar-flyout-active');
            ul.style.display = 'block';
            ul.style.visibility = 'hidden';

            const rect = summary.getBoundingClientRect();
            let top = rect.top;
            let left = rect.right + 8;
            const ulRect = ul.getBoundingClientRect();

            if (left + ulRect.width > window.innerWidth - 8) {
                left = Math.max(8, rect.left - ulRect.width - 8);
            }
            if (top + ulRect.height > window.innerHeight - 8) {
                top = Math.max(8, window.innerHeight - ulRect.height - 8);
            }

            ul.style.top = top + 'px';
            ul.style.left = left + 'px';
            ul.style.visibility = 'visible';
        }

        function closeAllFlyouts() {
            document.querySelectorAll('aside.sidebar-collapsed .sidebar-menu > li > details.group[open]').forEach(function (d) {
                d.removeAttribute('open');
                portalFlyoutBack(d, getFlyoutPanel(d));
            });
        }

        function repositionOpenFlyouts() {
            document.querySelectorAll('aside.sidebar-collapsed details.group[open]').forEach(positionFlyoutSubmenu);
        }

        function resetFlyouts() {
            document.querySelectorAll('.sidebar-menu > li > details.group').forEach(function (details) {
                details.removeAttribute('open');
                portalFlyoutBack(details, getFlyoutPanel(details));
            });
        }

        document.querySelectorAll('.sidebar-menu > li > details.group').forEach(function (details, index) {
            if (!details.dataset.flyoutId) {
                details.dataset.flyoutId = 'flyout-' + index;
            }
            const ul = details.querySelector(':scope > ul.sidebar-submenu-panel');
            if (ul) ul.dataset.flyoutId = details.dataset.flyoutId;
        });

        document.addEventListener('toggle', function (e) {
            const details = e.target;
            if (!details.matches('details.group')) return;

            if (isSidebarCollapsed() && isTopLevelFlyout(details) && details.open) {
                document.querySelectorAll('aside.sidebar-collapsed .sidebar-menu > li > details.group[open]').forEach(function (other) {
                    if (other !== details) {
                        other.removeAttribute('open');
                        portalFlyoutBack(other, getFlyoutPanel(other));
                    }
                });
            }

            if (isTopLevelFlyout(details)) {
                positionFlyoutSubmenu(details);
            }
        }, true);

        document.addEventListener('click', function (e) {
            if (!isSidebarCollapsed()) return;

            const inFlyout = e.target.closest('ul.sidebar-flyout-active');
            const inTopSummary = e.target.closest('aside.sidebar-collapsed .sidebar-menu > li > details.group > summary');
            const inSidebarIcon = e.target.closest('aside.sidebar-collapsed .sidebar-menu > li > .sidebar-link, aside.sidebar-collapsed .sidebar-menu > li > details.group > summary');

            if (!inFlyout && !inSidebarIcon) {
                closeAllFlyouts();
            }
        });

        document.addEventListener('mouseover', function (e) {
            const link = e.target.closest('aside.sidebar-collapsed [data-tooltip]');
            if (!link) return;
            if (link.closest('ul.sidebar-flyout-active')) return;
            showTooltip(link);
        });

        document.addEventListener('mouseout', function (e) {
            if (!activeLink) return;
            const to = e.relatedTarget;
            if (to && (activeLink === to || activeLink.contains(to))) return;
            hideTooltip();
        });

        document.addEventListener('scroll', function () {
            hideTooltip();
            repositionOpenFlyouts();
        }, true);

        window.addEventListener('resize', function () {
            hideTooltip();
            if (isSidebarCollapsed()) {
                repositionOpenFlyouts();
            } else {
                resetFlyouts();
            }
        });
    })();
</script>

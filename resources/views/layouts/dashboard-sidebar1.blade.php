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

<ul class="mt-6 text-gray-800 dark:text-gray-200">

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
            echo '<summary class="sidebar-link flex items-center justify-between cursor-pointer">';
            echo "<div class='flex items-center gap-2'>";
            echo generateMenuIcon($item->DisplayName, $i++);
            echo '<span>' . e($item->DisplayName) . '</span>';
            echo '</div>';
            echo "<span class='arrow text-gray-400 transition-transform duration-200 group-open:rotate-90 ml-1'>▶</span>";
            echo '</summary>';
            echo "<ul class='ml-" .
                (4 + $level * 2) .
                " pl-2 border-l border-gray-200 dark:border-gray-700 mt-1 space-y-1'>";
            $renderMenu($item->children, $level + 1);
            echo '</ul>';
            echo '</details>';
        } else {
            if ($isLocked) {
                // Locked patient menu item: visible, greyed out, and non-functional.
                echo '<span class="sidebar-link sidebar-link--locked" aria-disabled="true" title="Complete onboarding to unlock this menu item">';
                echo generateMenuIcon($item->DisplayName, $i++);
                echo '<span>' . e($item->DisplayName) . '</span></span>';
            } else {
                // Leaf node: normal clickable link.
                echo '<a href="' . url(trim($item->MenuURL ?? '#', '/')) . '" class="sidebar-link">';
                echo generateMenuIcon($item->DisplayName, $i++);
                echo '<span>' . e($item->DisplayName) . '</span></a>';
            }
        }
        echo '</li>';
            }
        };

        $renderMenu($menuItems);
    @endphp
</ul>

<style>
    /* Sidebar link styling */
    .sidebar-link {
        @apply flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg transition-all duration-150 w-full whitespace-nowrap overflow-hidden hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-gray-700 dark:hover:text-indigo-400;
        display: flex;
        align-items: center;
        white-space: normal;
        margin-bottom: 6px;
    }

    /* Sidebar icons */
    .sidebar-link svg {
        @apply w-[18px] h-[18px] flex-shrink-0 inline-block align-middle;
        margin-right: 6px;
    }

    /* Sidebar text */
    .sidebar-link span {
        @apply text-gray-700 dark:text-gray-200;
        display: inline-block;
        vertical-align: middle;
        line-height: 1.2;
        overflow: visible;
        text-overflow: unset;
        white-space: normal;
        word-break: break-word;
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
    .sidebar-link--locked span {
        color: #9ca3af !important;
    }

    /* Details summary for main items with submenus */
    details.group>summary.sidebar-link {
        justify-content: space-between;
        /* icon + text left, arrow right */
        width: 100%;
        padding-right: 0.4rem;
        /* tidy spacing */
        overflow: hidden;
    }

    /* Arrow icon at the end of summary */
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
    details.group>summary.sidebar-link span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Submenu ul spacing */
    details.group>ul {
        overflow-x: hidden;
    }

    /* Optional: prevent horizontal scroll for entire sidebar */
    .sidebar-menu,
    .sidebar-submenu {
        max-width: 100%;
        overflow-x: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        /* keep in one line */
    }
</style>

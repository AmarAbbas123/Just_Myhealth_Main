<?php

return [
    'therapist_session_lead_minutes' => (int) env('THERAPIST_REMINDER_MINUTES', 30),
    'therapist_session_grace_minutes' => (int) env('THERAPIST_REMINDER_GRACE_MINUTES', 2),
];

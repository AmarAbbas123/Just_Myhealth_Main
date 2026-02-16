
<?php

return [

    'user' => [
        1  => 'USER (Standard)',
      //  2  => 'UserEnhanced',
       // 3  => 'UserDischargedPatient', // you can keep it here if you want later
    ],

    'therapist' => [
        30 => 'THERAPIST (Professional Person)',
       // 31 => 'PersonalTrainer',
       // 32 => 'Dietician',
    ],

    'business' => [
        10 => 'BUSINESS (Local)',
       // 11 => 'BusinessRegional',
       // 12 => 'BusinessNational',
       // 13 => 'BusinessGlobal',
    ],

    // Optional: Admin and Medical Groups kept separate
    'medical_group' => [
        20 => 'MedicalGroupAdmin',
        21 => 'MedicalGroupManager',
        22 => 'MedicalGroupTeamLeader',
        23 => 'MedicalGroupTeamMember',
    ],

    'admins' => [
        90 => 'JmhSuperAdmin',
        91 => 'JmhSystemAdmin',
        92 => 'JmhFinanceAdmin',
        93 => 'JmhRegionalAdmin',
        94 => 'JmhNationalAdmin',
        95 => 'JmhGroupAdmin',
    ],

];
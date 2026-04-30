<?php

return [
    'VerifyEmail' => [
        'ModuleRef'   => 0,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '0001',
        'EmailSubRef' => '001', // REG Validate Email    ✅ APPLIED
        'Label'       => 'VerifyEmail',
    ],
    'ResendVerifyEmail' => [
        'ModuleRef'   => 0,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '0001',
        'EmailSubRef' => '002', // REG Remind 1
        'Label'       => 'ResendVerifyEmail',
    ],
    'ResendVerifyEmail2' => [
        'ModuleRef'   => 0,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '0001',
        'EmailSubRef' => '003', // REG Remind 2
        'Label'       => 'ResendVerifyEmail2',
    ],
    'LoginAlert' => [
        'ModuleRef'   => 0,
        'ModuleSubRef'=> 2,
        'ModuleFull'  => '0002',
        'EmailSubRef' => '001', // LOGIN Notification ✅ APPLIED
        'Label'       => 'LoginAlert',
    ],
    'AccountActivatedNotification' => [
        'ModuleRef'   => 0,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '0001',
        'EmailSubRef' => '004', // REG Account Activated    ✅ APPLIED
        'Label'       => 'AccountActivated',
    ],
    'AccountDeletedNotValidated' => [
        'ModuleRef'   => 0,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '0001',
        'EmailSubRef' => '005', // REG Account Deleted   
        'Label'       => 'AccountDeletedNotValidated',
    ],
    'TherapistSessionReminder' => [
        'ModuleRef'   => 10,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '1001',
        'EmailSubRef' => '001',
        'Label'       => 'TherapistSessionReminder',
    ],
    'UserSessionReminder' => [
        'ModuleRef'   => 10,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '1001',
        'EmailSubRef' => '002',
        'Label'       => 'UserSessionReminder',
    ],
    'UserSessionStartedNotification' => [
        'ModuleRef'   => 10,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '1001',
        'EmailSubRef' => '003',
        'Label'       => 'UserSessionStartedNotification',
    ],
    'TherapistMessageReceivedNotification' => [
        'ModuleRef'   => 10,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '1001',
        'EmailSubRef' => '004',
        'Label'       => 'TherapistMessageReceivedNotification',
    ],
    'UserMessageReceivedNotification' => [
        'ModuleRef'   => 10,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '1001',
        'EmailSubRef' => '005',
        'Label'       => 'UserMessageReceivedNotification',
    ],
    'UserSessionPurchaseConfirmationNotification' => [
        'ModuleRef'   => 10,
        'ModuleSubRef'=> 1,
        'ModuleFull'  => '1001',
        'EmailSubRef' => '006',
        'Label'       => 'UserSessionPurchaseConfirmationNotification',
    ],
    'AdminNewUserRegisteredNotification' => [
        'ModuleRef'   => 1,
        'ModuleSubRef'=> 0,
        'ModuleFull'  => '0100',
        'EmailSubRef' => '001',
        'Label'       => 'AdminNewUserRegisteredNotification',
    ],
    'TherapistAccountApprovedNotification' => [
        'ModuleRef'   => 1,
        'ModuleSubRef'=> 0,
        'ModuleFull'  => '0100',
        'EmailSubRef' => '002',
        'Label'       => 'TherapistAccountApprovedNotification',
    ],
];
<?php
// Stripe $ ZegoCloud
use App\Http\Controllers\StripePayment\TherapistsRegistrationController;
use App\Http\Controllers\StripePayment\BusinessRegistrationController;
use App\Http\Controllers\StripePayment\WebhookController;
use App\Http\Controllers\StripePayment\SessionPurchaseController;
use App\Http\Controllers\StripePayment\PaymentSuccessController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ZegoCloud\ZegoChatController;
use App\Http\Controllers\ZegoCloud\VideoSessionController;
use App\Http\Controllers\ZegoCloud\ZegoRecordingController;
use App\Models\SysMenuDisplayOption;
use App\Models\SysUserType30SessionHistory;

//mod-01 System Administration (Table Management)
use App\Http\Controllers\Modules\Mod00UserAccess\ProfileController;
use App\Http\Controllers\Modules\Mod01SystemAdministration\SysConfigAutoEmailsController;
use App\Http\Controllers\Modules\Mod01SystemAdministration\ModuleListController;
use App\Http\Controllers\Modules\Mod01SystemAdministration\ReportPermissionsController;
use App\Http\Controllers\Modules\Mod01SystemAdministration\SysMenuOptionsController;
// (Therapists Management)
use App\Http\Controllers\Modules\Mod01SystemAdministration\ThrpistMangt\TherapistsStatusController;
use App\Http\Controllers\Modules\Mod01SystemAdministration\ThrpistMangt\TherapistsOnboardingVerifyController;
use App\Http\Controllers\Modules\Mod01SystemAdministration\ThrpistMangt\TherapistsOnboardingApproveController;

//mod-02 System Reporting
use App\Http\Controllers\Modules\Mod02SystemReporting\ChartsDeviceOsBrowserController;
use App\Http\Controllers\Modules\Mod02SystemReporting\UserNumbersController;
use App\Http\Controllers\Modules\Mod02SystemReporting\FinanceReportsRevenueController;

//mod-03 User General
use App\Http\Controllers\Auth\KeycloakCallbackController;
use App\Http\Controllers\Modules\Mod03SocialMedia\MySpaceController;
use App\Http\Controllers\Modules\Mod03SocialMedia\MyGroupsController;
use App\Http\Controllers\Modules\Mod03SocialMedia\MyMessagesController;
use App\Http\Controllers\Modules\Mod03SocialMedia\FindAGroupController;
use App\Http\Controllers\Modules\Mod03SocialMedia\FindAServiceController;

//mod-04  , mod-05
use App\Http\Controllers\Modules\Mod04MedicalData\HealthNewsFeedsController;
use App\Http\Controllers\Modules\Mod05BusinessDirectory\FindABusinessController;

// Common controller  for all users
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\StoreChatMessageController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\MessagesController;

//mod-10 Patients  
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients\PatientsOnboardingController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients\TherapistFinderController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients\PatientsBookSlotsController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients\PatientsCalendarController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients\UsrTherapyHistoryController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients\UsrPreviousTherapistsController;

//mod-10 Therapists 
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\BioDetailsController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\SalutationsLanguagesController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\TherapyTypesController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\QualificationController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\TherapistsBookSlotsController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\TherapistsMessagesController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\WaitingRoomController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\SessionHistoryController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\FinancialManagementController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\ComplaintsIssuesController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\IdRegistrationController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\TasksActionsController;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\SearchMatchQuestionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stripe\Checkout\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Utility & Debug Routes (always safe first)
|--------------------------------------------------------------------------
*/
// 0️⃣ 1️⃣ 2️⃣ 3️⃣ 4️⃣ 5️⃣ 6️⃣ 7️⃣ 8️⃣ 9️⃣ 🔟

Route::get('/clear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
});

Route::get('/optimize1', function () {
    Artisan::call('optimize:clear');
});

Route::get('/optimize1', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
});

Route::get('/log-test', function () {
    Log::info('✅ Laravel log test is working!');
    return 'Log written!';
});

Route::get('/test-session', function () {
    session(['test' => 'value']);
    return 'Session set.';
});

Route::get('/check-session', function () {
    return session('test'); // Should return "value"
});

Route::get('/debug-session', function () {
    return session()->all();
});

Route::get('/test-user/{id}', function ($id) {
    $user = \App\Models\User::where('ID', $id)->first();

    if ($user) {
        return '✅ Found user: ' . $user->Email;
    } else {
        return '❌ No user found';
    }
});

// Testing CRF Token in console 
Route::post('/test-route', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'msg' => 'CSRF works!',
        'received_name' => $request->input('name'),
        'received_message' => $request->input('message')
    ]);
});

// route test
Route::get('/test-route', fn() => 'OK');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// SVG design practise
Route::view('/test', 'test');
Route::view('/', 'modules.mod-ps.general.welcome')->name('home');

// Nav pages
Route::view('/mod-ps/general/faq', 'modules.mod-ps.general.faq')->name('faq');
Route::view('/mod-ps/general/about', 'modules.mod-ps.general.about')->name('about');
Route::view('/mod-ps/general/terms', 'modules.mod-ps.general.terms')->name('terms');
Route::view('/mod-ps/general/privacy', 'modules.mod-ps.general.privacy')->name('privacy');

Route::view('/mod-ps/general/partners', 'modules.mod-ps.general.partners')->name('partners');
Route::view('/mod-ps/general/getting-started', 'modules.mod-ps.general.getting-started')->name('getting-started');
Route::view('/mod-ps/general/blog', 'modules.mod-ps.general.blogs')->name('blogs');

// Carousel Pages
Route::view('/health-care-providers', 'modules.mod-ps.home-page-top-carousel.message-1')->name('health-care-providers');
Route::view('/professional-therapy-sessions', 'modules.mod-ps.services.online-counselling')->name('professional-therapy-sessions');
Route::view('/user-driven-people-focused', 'modules.mod-ps.home-page-top-carousel.message-3')->name('user-driven-people-focused');

// Services Pages
Route::view('/mod-ps/services/online-counselling', 'modules.mod-ps.services.online-counselling')->name('online-counselling');
Route::view('/mod-ps/services/personal-training', 'modules.mod-ps.services.personal-training')->name('personal-training');
Route::view('/mod-ps/services/eating-for-health', 'modules.mod-ps.services.eating-for-health')->name('eating-for-health');

// 6 Online Counselling therapies used in patients side session calendar        
Route::view('/therapy/DialecticalBehaviorTherapy', 'modules.mod-ps.services.six-therapies.dielectical');
Route::view('/therapy/HumanisticTherapy', 'modules.mod-ps.services.six-therapies.Humanistic');
Route::view('/therapy/CognitiveBehavioralTherapy', 'modules.mod-ps.services.six-therapies.cognitive');
Route::view('/therapy/PsychodynamicTherapy', 'modules.mod-ps.services.six-therapies.psychodynamic');
Route::view('/therapy/CouplesTherapy', 'modules.mod-ps.services.six-therapies.couples');
Route::view('/therapy/FamilyTherapy', 'modules.mod-ps.services.six-therapies.family');

// ##############################################################################################################
// ##############################################################################################################
// ##############################################################################################################

/*
|--------------------------------------------------------------------------
| Authentication Routes (from Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Routes (auth required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckUserSession::class])
    ->group(function () {
        Route::get('/dashboard', function () {
            ['id' => optional(Auth::user())->id];
            return view('modules.dashboard');
        })->name('dashboard');      //    Changed return view('therapdashboard.dashboard1');
        // Route::get('/dashboard', function () { return view('modules.dashboard'); })->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::match(['POST', 'PATCH'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
        Route::post('/profile/header', [ProfileController::class, 'uploadHeader'])->name('profile.header.upload');
    });

// check realtime Email & UserName if already used or not for newly Users Registraions  (Ajax checks)
Route::get('/check-email', function (Request $request) {
    $email = $request->query('email');
    return response()->json(['exists' => User::where('Email', $email)->exists()]);
});

Route::get('/check-username', function (Request $request) {
    $username = $request->query('username');
    return response()->json(['exists' => User::where('UserName', $username)->exists()]);
});

// Changing the user email address
Route::get('/email/change/verify/{id}/{hash}', [ProfileController::class, 'verifyNewEmail'])
    ->middleware(['auth', 'signed'])
    ->name('email.change.verify');

//  Changing the user password  (AJAX)
Route::post('/verify-current-password', function (Request $request) {
    return response()->json([
        'valid' => Hash::check($request->current_password, $request->user()->Password),
    ]);
})->middleware(['auth'])->name('verify.current.password');


// Social login
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

/*
|--------------------------------------------------------------------------
| Realtime & Integrations  ZegoCloud
|--------------------------------------------------------------------------
*/

// routes/web.php or api.php this is for Chatting/ messaging
Route::post('/zego/chat-token', [ZegoChatController::class, 'token'])
    ->middleware('auth');    // ->middleware(['web', 'auth']);   in live why just FYI

// Therapist Creates Video Session 
Route::middleware(['auth'])->get('/video/token', [VideoSessionController::class, 'generateToken']);
//Route::get('/video/token', [VideoSessionController::class, 'generateToken'])->name('video.token');    in live cp1

Route::controller(ZegoRecordingController::class)
    ->group(function () {
        // Route to trigger the start of recording
        Route::post('/zego/start-recording', 'start');
    });

Route::post('/zego/callback', function (Illuminate\Http\Request $request) {
    Log::info('ZEGO ROUTE HIT DIRECTLY', $request->all());
    return app(ZegoRecordingController::class)->handleCallback($request);
});

/*
|--------------------------------------------------------------------------
| mod-01 System Administration Block | For  Usertype 90,91,99
|--------------------------------------------------------------------------
*/
///////// TM Table Mangament //////////////
// 1) Config Auto-emails this ::resource BY default Contains all the CRUD Operations.
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/tm/auto-emails', SysConfigAutoEmailsController::class)->names('auto-emails');
});

// 2) module-list
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/tm/module-list', ModuleListController::class)->names('module-list');
});
// 3) report-access
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/tm/report-access', ReportPermissionsController::class)->names('report-access');
});
// 4) menu-display-options
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/tm/menu-display-options', SysMenuOptionsController::class)->names('menu-display-options');
});

///////// ThM Therapists Mangament //////////////
//Therapists Status
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/therapist-management/therapist-status', TherapistsStatusController::class)->names('therapists-status');
});

//Therapists Onboarding Verify (Thm)
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/therapist-management/therapist-onboarding-verify', TherapistsOnboardingVerifyController::class)->names('therapists-onboarding-verify');
    Route::post('/mod-01/therapist-management/therapist-onboarding-verify/{user}/status', [TherapistsOnboardingVerifyController::class, 'updateStatus'])
        ->name('therapists-onboarding-verify.status');
});

//Therapists Onboarding Approve
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::resource('/mod-01/therapist-management/therapist-onboarding-approve', TherapistsOnboardingApproveController::class)->names('therapists-onboarding-approve');
    Route::post('/mod-01/therapist-management/therapist-onboarding-approve/{user}/status', [TherapistsOnboardingApproveController::class, 'updateStatus'])
        ->name('therapists-onboarding-approve.status');
});



/*
|--------------------------------------------------------------------------
| mod-02 System Reporting Block | For Usertype 90,91,99
|--------------------------------------------------------------------------
*/
//Reporting device-os-browser
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::get('/mod-02/user-reports/device-os-browser', [ChartsDeviceOsBrowserController::class, 'index'])->name('reports.device.os.browser');
    Route::get('/mod-02/user-reports/device-os-browser/data', [ChartsDeviceOsBrowserController::class, 'data'])->name('reports.device.os.browser.data');
});

//Reporting user-numbers
Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::get('/mod-02/user-reports/user-numbers', [UserNumbersController::class, 'index'])->name('user-numbers');
});


Route::middleware(['auth', 'usertype:admins'])->group(function () {
    Route::get('/mod-02/finance-reports/revenue', [FinanceReportsRevenueController::class, 'revenue'])->name('finance.reports.revenue');
    Route::get('/mod-02/finance-reports/payments-platform-operations', [FinanceReportsRevenueController::class, 'paymentsPlatformOperations'])->name('finance.reports.payments_platform_operations');
    Route::get('/mod-02/finance-reports/payments-prof-persons', [FinanceReportsRevenueController::class, 'paymentsprofpersons'])->name('finance.reports.payments-prof-persons');
});

/*
|--------------------------------------------------------------------------
| mod-03 USER GENERAL
|--------------------------------------------------------------------------
*/
Route::get('/openid/callback', [KeycloakCallbackController::class, 'handle'])
    ->name('keycloak.callback');

//Route::get('/mod-03/usr-my-space', [MySpaceController::class, 'index'])->middleware('auth');   // https://jmhmod03.xyz/openid/auth/keycloak
Route::get('/mod-03/usr-my-space')->middleware('auth');
Route::get('/mod-03/usr-my-groups', [MyGroupsController::class, 'index'])->middleware('auth');
Route::get('/mod-03/usr-my-messages', [MyMessagesController::class, 'index'])->middleware('auth');
Route::get('/mod-03/usr-group-finder', [FindAGroupController::class, 'index'])->middleware('auth');
Route::get('/mod-03/usr-service-finder', [FindAServiceController::class, 'index'])->middleware('auth');

// | mod-04 , mod-05
Route::get('/mod-04/usr-health-news-feed', [HealthNewsFeedsController::class, 'index'])->middleware('auth');
Route::get('/mod-05/usr-business-finder', [FindABusinessController::class, 'index'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| Common Messaging Routes
|--------------------------------------------------------------------------
*/
//(Patients(1)  + Therapists(30) + Admin(90,91,92)
Route::controller(StoreChatMessageController::class)
    ->middleware('auth')
    ->group(function () {
        // store chat messages
        Route::post('/chat/store-message', 'store');
        // load chat messages
        Route::get('/chat/history/{peerID}', 'history');
    });
//(Patients(1)  + Admin(90,91,92)
Route::controller(MessagesController::class)
    ->middleware(['auth', 'usertype:user,admins'])
    ->group(function () {
        Route::get('/mod-10/my-messages ', 'messages')->name('user.messages');
    });

/*
|--------------------------------------------------------------------------
| mod-10 THERAPY Services Block
|--------------------------------------------------------------------------
*/
// Laravel automatically generates 7 RESTful routes for BioDetailsController:
//
//   Method      URI                        Controller Method   Route Name
// 1 GET         /bio-details               index              bio-details.index    (List all records)
// 2 GET         /bio-details/create        create             bio-details.create   (Show form to create new record)
// 3 POST        /bio-details               store              bio-details.store    (Save new record to DB)
// 4 GET         /bio-details/{id}          show               bio-details.show     (Display single record)
// 5 GET         /bio-details/{id}/edit     edit               bio-details.edit     (Show form to edit record)
// 6 PUT/PATCH   /bio-details/{id}          update             bio-details.update   (Update record in DB)
// 7 DELETE      /bio-details/{id}          destroy            bio-details.destroy  (Delete record from DB)
//
//Route::resource('bio-details', BioDetailsController::class) ->middleware('auth'); // Auto-creates all 7 routes
// Route::resource('bio-details', BioDetailsController::class)
//     ->only(['index', 'store'])
//     ->middleware('auth');


// patients join Session 
Route::get('/patient/join', function (Request $request) {
    $roomID = $request->room ?? $request->roomID;
    $sessionId = $request->session;

    if (!$roomID || !$sessionId) {
        abort(404);
    }
    return view('modules.mod-10.01-counselling.patients.patients-join-session', compact('roomID', 'sessionId'));
})->name('patient.audiovideo.join');

// ##############################################################################################################
// ##################### My Therapist Profile middleware(['auth', 'usertype:therapist'])#########################
// ##############################################################################################################
//1️⃣  bio details
Route::controller(BioDetailsController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/mb/my-bio-details', 'bioDetails')->name('my-bio-details');
        Route::post('mod-10/mb/my-bio-details', 'storeBioDetails')->name('my-bio-details.store');
        Route::post('mod-10/mb/my-bio-details/update', 'updateBioDetails')->name('my-bio-details.update');
        Route::delete('mod-10/mb/my-bio-details/delete', 'deleteBioDetails')->name('my-bio-details.delete');
    });

//2️⃣ salutation&languages
Route::controller(SalutationsLanguagesController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/mb/my-salutationlanguages', 'salutationsLanguages')->name('my-bio-salutationsLanguages');
        Route::post('mod-10/mb/my-salutationlanguages', 'storeSalutationsLanguages')->name('my-bio-salutationsLanguages.store');
        Route::post('mod-10/mb/my-salutationlanguages/update', 'updateSalutationsLanguages')->name('my-bio-salutationsLanguages.update');
        Route::delete('mod-10/mb/my-salutationlanguages/delete', 'deleteSalutationsLanguages')->name('my-bio-salutationsLanguages.delete');
    });

//3️⃣ therapy types
Route::controller(TherapyTypesController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('/mod-10/mb/my-therapy-types', 'profileTherapyTypes')->name('therap.profile.therapytypes');
        Route::post('/mod-10/mb/my-therapy-types/store', 'storeTherapyType')->name('therap.profile.therapytypes.store');
        Route::post('/mod-10/mb/my-therapy-types/update', 'updateTherapyType')->name('therap.profile.therapytypes.update');
        Route::post('/mod-10/mb/my-therapy-types/delete', 'deleteTherapyType')->name('therap.profile.therapytypes.delete');
    });

//4️⃣ QUALIFICATIONS
Route::controller(QualificationController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-qualifications', 'qualification')->name('my-bio-qualifications'); // show or edit page (depending on record)
        Route::post('mod-10/my-qualifications/store', 'storeQualification')->name('my-bio-qualifications.store'); // create new
        Route::post('mod-10/my-qualifications/update', 'updateQualification')->name('my-bio-qualifications.update'); // update existing
        Route::delete('mod-10/my-qualifications/delete', 'deleteQualification')->name('my-bio-qualifications.delete'); // delete all qualifications
    });

//5️⃣ Therapists side Book Slots
Route::controller(TherapistsBookSlotsController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        // Therapist calendar management (own calendar)
        Route::get('/mod-10/my-calendar', 'index')->name('therapist.calendar.index');
        // JSON endpoints for calendar UI
        Route::get('/therapist/calendar/slots', 'slots')->name('therapist.calendar.slots');
        Route::post('/therapist/calendar/slots', 'store')->name('therapist.calendar.store');
        Route::put('/therapist/calendar/slots/{id}', 'update')->name('therapist.calendar.update');
        Route::delete('/therapist/calendar/slots/{id}', 'destroy')->name('therapist.calendar.destroy');
    });

// 6️⃣ Therapists Messages
Route::controller(TherapistsMessagesController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-messages', 'messages')->name('therap.messages');
    });

//7️⃣  waiting-room
Route::controller(WaitingRoomController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-waiting-room', 'waitingRoom')->name('therap.waiting.room');
        Route::post('/therapist/session/entered-waiting-room', 'therapistEnteredWaitingRoom');
        Route::post('/therapist/session/start', 'start');
        Route::post('/therapist/session/end', 'end');
    });

// 🔔 Send system message to patient with join links
Route::get('/session/join/{roomID}', function ($roomID) {
    return redirect()->route('patient.audiovideo.join', ['roomID' => $roomID]);
});

// Notify backend DB updates the patient actually entered the waiting room
Route::middleware('auth')->post('/patient/session/joined', function (Request $request) {

    $request->validate([
        'roomID'    => 'required|string',
        'sessionID' => 'required|integer',
    ]);

    SysUserType30SessionHistory::where('SessionCalendarID', $request->sessionID)
        ->where('SessionZegoCloudConnectID', $request->roomID)
        ->update([
            'PatientUserID' => auth()->id(),
            'PatientEnteredWaitingRoomDate' => now()->toDateString(),
            'PatientEnteredWaitingRoomTime' => now()->toTimeString(),
        ]);

    return response()->json(['success' => true]);
});


//8️⃣ Sessions History
Route::controller(SessionHistoryController::class)
    ->middleware(['auth', 'usertype:user,therapist'])
    ->group(function () {
        Route::get('mod-10/my-session-history', 'sessionHistory')->name('therap.session.history');
        Route::post('therapist/session-history/details', 'showDetails');
        Route::get('/recordings/{id}', 'getRecording');
    });


//9️⃣ Financials
Route::controller(FinancialManagementController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-financials', 'financialManagement')->name('therap.financial.management');
    });

//🔟 Complaints & Issues       
Route::controller(ComplaintsIssuesController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-complaints&issues', 'complaintsIssues')->name('therap.complaints.issues');
    });

//1️⃣1️⃣ ID & Registration
Route::controller(IdRegistrationController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-id&registration', 'counselorId')->name('therap.profile.counselorid');

        // AJAX CRUD routes
        Route::get('mod-10/id-documents', 'fetchDocuments')->name('therap.documents.fetch');
        Route::post('mod-10/id-documents', 'storeDocument')->name('therap.documents.store');
        Route::post('mod-10/id-documents/update', 'updateDocument')->name('therap.documents.update');
        Route::delete('mod-10/id-documents/{type}', 'deleteDocument')->name('therap.documents.delete');
    });

//1️⃣2️⃣ Support & Tasks
Route::controller(TasksActionsController::class)
    ->middleware(['auth', 'usertype:therapist'])
    ->group(function () {
        Route::get('mod-10/my-tasks', 'tasksActions')->name('therap.tasks.actions');
        Route::post('mod-10/my-tasks/store', 'storeTask')->name('therap.tasks.actions.store');
        Route::post('mod-10/my-tasks/update', 'updateTask')->name('therap.tasks.actions.update');
        Route::delete('mod-10/my-tasks/delete', 'deleteTask')->name('therap.tasks.actions.delete');
    });


// ##############################################################################################################
// #####################  Patients User Block ->middleware(['auth', 'usertype:user']) ###########################
// ##############################################################################################################    

//Onboarding Question and Answers
Route::controller(PatientsOnboardingController::class)
    ->middleware(['auth', 'usertype:user'])
    ->group(function () {
        Route::get('/mod-10/01/usr-how-i-feel-questions', 'showonboardingquestions')->name('onboarding.start');
        Route::post('/mod-10/01/save-onboarding', 'saveonboardingAnswers')->name('onboarding.save');
    });

//TherapistFinder
Route::controller(TherapistFinderController::class)
    ->middleware(['auth', 'usertype:user'])
    ->group(function () {
        Route::get('/mod-10/01/usr-therapist-finder', 'index')->name('therapists.index');
    });

// Patients sides Book Slots
Route::controller(PatientsBookSlotsController::class)
    ->middleware(['auth', 'usertype:user'])
    ->group(function () {
        //note: this below id is representing the therapist's id (TherapistUserID) ok 
        Route::get('/mod-10/01/patients-book-slots/{id}', 'show')->name('session.book');
        // JSON endpoint for dynamic refresh
        Route::get('/patients/{id}/calendar/slots', 'slots')->name('patients.calendar.slots');
        // Booking (POST)
        Route::post('/patients/{id}/book', 'book')->name('patients.calendar.book');
    });

// Patients My Session just ready to join
Route::controller(PatientsCalendarController::class)
    ->middleware(['auth', 'usertype:user'])
    ->group(function () {
        Route::get('mod-10/01/usr-therapy-calendar', 'index');
        Route::put('mod-10/01/usr-therapy-calendar/{calendar}/update-session-type', 'updateSessionType')->name('patient.calendar.updateSessionType');
        Route::patch('mod-10/01/usr-therapy-calendar/{calendar}/cancel', 'cancelSession')->name('patient.calendar.cancel');
        Route::get('/therapy/{therapy}', function ($therapy) {})->name('therapy.filter');
        Route::get('patient/sessions/poll', 'pollSessions');
    });

// UsrTherapyHistoryController  Details 
Route::controller(UsrTherapyHistoryController::class)
    ->middleware(['auth', 'usertype:user'])
    ->group(function () {
        Route::get('/mod-10/01/usr-therapy-history', 'index')->name('usr-therapy-history');
        Route::post('/mod-10/01/usr-therapy-history', 'showDetails');
    });


// UsrPreviousTherapistsController  Details 
Route::controller(UsrPreviousTherapistsController::class)
    ->middleware(['auth', 'usertype:user'])
    ->group(function () {
        Route::get('/mod-10/01/usr-previous-therapists', 'index')->name('usr-previous-therapists');
        Route::post('/mod-10/01/usr-previous-therapists', 'showDetails');
    });

/*
|--------------------------------------------------------------------------
| Stripe Payment Routes
|--------------------------------------------------------------------------
*/
// Therapist Registraion Fee Payment 
Route::controller(TherapistsRegistrationController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/pay/checkout', 'therapistCheckout')->name('therapist.checkout');
    });

// Business Registration Fee Payment
Route::controller(BusinessRegistrationController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/pay/business/checkout', 'businessCheckout')->name('business.checkout');
    });

Route::post('/stripe/webhook', [WebhookController::class, 'handle'])->withoutMiddleware(['web', 'auth', 'verified'])->name('stripe.webhook');

Route::get('/payment/success', [PaymentSuccessController::class, 'handle'])->name('payment.success');

Route::get('/payment/cancel', function () {
    return 'Payment Cancelled.';
})->name('payment.cancel');

// Session purchase UI + checkout
Route::controller(SessionPurchaseController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/mod-10/01/usr-finances', 'showPurchaseOptions')->name('pay.sessions.options');
        Route::post('/pay/sessions/checkout', 'startCheckout')->name('pay.sessions.checkout');
    });

/*
|--------------------------------------------------------------------------
| Catch-All Dynamic Route (must ALWAYS be last)
|--------------------------------------------------------------------------
*/
// latest
Route::get('/{slug?}', function ($slug = null) {
    $slug = trim($slug, '/');

    $menu = SysMenuDisplayOption::whereRaw("TRIM(BOTH '/' FROM LOWER(MenuURL)) = ?", [$slug])
        ->firstOrFail();

    $children = $menu->children;

    if ($children->isEmpty()) {
        $folders = [
            'modules.mod-01',
            'modules.mod-02',
            'modules.mod-03',
            'modules.mod-04',
            'modules.mod-05',
            'modules.mod-06',
            'modules.mod-07',
            'modules.mod-08',
            'modules.mod-09',
            'modules.mod-10',
            // add more folders here
        ];

        foreach ($folders as $folder) {
            $tryView = $folder . '.' . strtolower(str_replace(' ', '-', $menu->MainPaneLabel));
            if (view()->exists($tryView)) {
                return view($tryView, compact('menu'));
            }
        }

        abort(404, "Page for {$menu->MainPaneLabel} not found in any module folder");
    }

    return view('modules.dynamic-dashboard', compact('menu', 'children'));
})->where('slug', '.*')->middleware('auth');

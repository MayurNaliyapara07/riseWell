<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FedexController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Frontend\FrontendCategoryController;
use App\Http\Controllers\Frontend\FrotendController;
use App\Http\Controllers\Frontend\ManageSectionController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationTemplateController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    echo "Cache Clear successfully";
});

Route::get('/checkout/{patientId}',[StripePaymentController::class, 'checkout'])->name('checkout');;
Route::get('success',[StripePaymentController::class,'success'])->name('checkout.success');
Route::post('cancel',[StripePaymentController::class,'cancel'])->name('checkout.cancel');
Route::post('webhook',[StripePaymentController::class,'webhook'])->name('checkout.webhook');

Route::get('survey-form/{flowType}/{uniqueID}',[FrotendController::class, 'index']);
Route::get('/appointment-book', [FrotendController::class, 'appointmentBook'])->name('appointment-book');
Route::get('/get-started', [FrotendController::class, 'getStarted'])->name('get-started');
Route::get('/treat-me-now', [FrotendController::class, 'treatMeNow'])->name('treat-me-now');
Route::get('/thank-you', [FrotendController::class, 'thankYou'])->name('thank-you');
Route::get('/step1', [FrotendController::class, 'step1'])->name('step1');
Route::get('/step2', [FrotendController::class, 'step2'])->name('step2');
Route::get('/step3', [FrotendController::class, 'step3'])->name('step3');
Route::get('/step4', [FrotendController::class, 'step4'])->name('step4');

Route::post('/save-ed-step-one', [FrotendController::class, 'saveEdStepOne'])->name('save-ed-step-one');
Route::post('/save-ed-step-two', [FrotendController::class, 'saveEdStepTwo'])->name('save-ed-step-two');
Route::post('/save-ed-step-three', [FrotendController::class, 'saveEdStepThree'])->name('save-ed-step-three');
Route::post('/save-ed-step-four', [FrotendController::class, 'saveEdStepFour'])->name('save-ed-step-four');

Route::get('/trt-ed-form-survey', [FrotendController::class, 'trtFormSurvey'])->name('trt-ed-form-survey');
Route::get('/trt-step1', [FrotendController::class, 'trtStep1'])->name('trt-step1');
Route::get('/trt-step2', [FrotendController::class, 'trtStep2'])->name('trt-step2');
Route::get('/trt-step3', [FrotendController::class, 'trtStep3'])->name('trt-step3');
Route::get('/trt-step4', [FrotendController::class, 'trtStep4'])->name('trt-step4');
Route::get('/trt-step5', [FrotendController::class, 'trtStep5'])->name('trt-step5');
Route::get('/trt-step6', [FrotendController::class, 'trtStep6'])->name('trt-step6');

Route::post('/save-trt-step-one', [FrotendController::class, 'saveTRTStepOne'])->name('save-trt-step-one');
Route::post('/save-trt-step-one-refill', [FrotendController::class, 'saveTRTStepOneRefill'])->name('save-trt-step-one-refill');
Route::post('/save-trt-step-two-refill', [FrotendController::class, 'saveTRTStepTwoRefill'])->name('save-trt-step-two-refill');
Route::post('/save-trt-step-three-refill', [FrotendController::class, 'saveTRTStepThreeRefill'])->name('save-trt-step-three-refill');
Route::post('/save-trt-step-four-refill', [FrotendController::class, 'saveTRTStepFourRefill'])->name('save-trt-step-four-refill');
Route::post('/save-trt-step-five-refill', [FrotendController::class, 'saveTRTStepFiveRefill'])->name('save-trt-step-five-refill');
Route::post('/save-trt-step-six-refill', [FrotendController::class, 'saveTRTStepSixRefill'])->name('save-trt-step-six-refill');



/* Login */
Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login-perform',  'login')->name('login.perform');
    Route::post('logout',  'logout')->name('logout');
});
Route::get('verify',[HomeController::class,'verify']);
Route::get('sendMail',[HomeController::class,'sendMail']);
Route::controller(CommonController::class)->group(
    function () {
        Route::post('index-search-list', 'indexSearchList');
        Route::post('place-list', 'getPlace');
        Route::post('state-list', 'getState');
        Route::post('event-list', 'getEvent');
        Route::post('assign-program-list', 'getAssignProgram');
        Route::post('provider-list', 'getProvider');
        Route::post('lab-category-list', 'getLabCategory');
        Route::post('product-list', 'getProduct');
        Route::post('category-list', 'getCategory');
        Route::post('country-list', 'getCountry');
        Route::post('country-code-list','getCountryCode');
        Route::post('user-type-list', 'UserTypeSearchList');
        Route::post('user-list', 'GetUser');
        Route::post('get-session-time', 'getSessionTime');
    });

Auth::routes();
Auth::routes(['verify' => true]);

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('user', UserController::class);
    Route::resource('lab-category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::get('product-change-status/{id}', [ProductController::class,'productChangeStatus'])->name('product-change-status');

    Route::resource('category', FrontendCategoryController::class);
    Route::resource('manage-section', ManageSectionController::class);
    Route::get('get-category', [FrontendCategoryController::class,'getCategory'])->name('get-category');
    Route::get('get-manage-section', [ManageSectionController::class,'getManageSection'])->name('get-manage-section');
    Route::get('get-lab-category', [CategoryController::class,'getCategory'])->name('get-lab-category');
    Route::get('get-product', [ProductController::class,'getProduct'])->name('get-product');
    Route::get('get-users', [UserController::class,'getUser'])->name('get-users');
    Route::get('user-change-status/{id}', [UserController::class,'userChangeStatus'])->name('user-change-status');
    Route::get('provider-approval-status-update/{id}', [UserController::class,'providerApprovalStatusUpdate'])->name('provider-approval-status-update');

    Route::controller(NotificationTemplateController::class)->group(function () {
        Route::get('notification-template', 'index')->name('notification-template');
        Route::get('notification-template/create', 'create')->name('notification-template.create');
        Route::get('get-notification-template', 'getNotificationTemplate')->name('get-notification-template');
        Route::get('notification-template/{id}/edit', 'edit')->name('notification-template.edit');
        Route::post('notification-template', 'store')->name('notification-template.store');
        Route::put('notification-template/{id}', 'update')->name('notification-template.update');
        Route::get('update-status/{id}','updateStatus')->name('update-status');

    });



    Route::controller(ProviderController::class)->group(function () {
        Route::get('provider', 'index')->name('provider');
        Route::get('get-provider', 'getProvider')->name('get-provider');
        Route::get('provider/{id}/edit', 'edit')->name('provider.edit');
        Route::put('provider/{id}', 'update')->name('provider.update');
        Route::put('school/{id}', 'schoolUpdate')->name('school.update');
        Route::put('working-hours/{id}', 'workingHoursUpdate')->name('working-hours.update');
        Route::put('state-of-lic/{id}', 'stateOfLicUpdate')->name('state-of-lic.update');
        Route::get('get-assign-program/{id}', 'getAssignProgram')->name('get-assign-program');
        Route::post('save-assign-program', 'saveAssignProgram')->name('save-assign-program');
        Route::post('assign-program-change-status', 'assignProgramChangeStatus');
        Route::post('delete-provider-working-hours', 'deleteWorkingHours');

    });

    Route::controller(PatientsController::class)->group(function () {
        Route::post('get-timeline', 'getTimeLine')->name('get-timeline');
        Route::get('get-survey-form/{id}', 'getSurveyForm')->name('get-survey-form');
        Route::post('get-unique-url', 'getUniqueUrl')->name('get-unique-url');
        Route::get('patients', 'index')->name('patients');
        Route::get('patients/create', 'create')->name('patients.create');
        Route::get('get-patients', 'getPatients')->name('get-patients');
        Route::post('patients', 'store')->name('patients.store');
        Route::get('patients/{id}/edit', 'edit')->name('patients.edit');
        Route::get('patients/{id}/show', 'show')->name('patients.show');
        Route::put('patients/{id}', 'update')->name('patients.update');
        Route::post('visit-note', 'saveVisitNote')->name('visit-note');
        Route::post('save-medication', 'saveMedication')->name('save-medication');
        Route::post('save-order', 'saveOrder')->name('save-order');
        Route::post('save-lab-report', 'saveLabReport')->name('save-lab-report');
        Route::get('patients-status-update/{id}', 'patientsStatusUpdate')->name('patients-status-update');
        Route::post('save-appointment', 'saveAppointment')->name('save-appointment');
        Route::post('appointment-details', 'appointmentDetails')->name('appointment-details');
        Route::post('get-available-times', 'getAvailableTimes')->name('get-available-times');
        Route::get('get-assign-program-details', 'assignProgramDetails')->name('get-assign-program-details');
        Route::get('calender', 'calender')->name('calender');
        Route::get('send-sms', 'appointmentsSmsSend');
        Route::get('send-email', 'appointmentsEmailSend');
        Route::get('chat', 'chat')->name('chat');
        Route::get('chat/{id}', 'chat');
        Route::post('get-chat-history', 'getChatHistory');
        Route::post('send-msg', 'sendMsg');
    });

    Route::controller(AppointmentController::class)->group(function (){
        Route::get('appointment', 'index')->name('appointment');
        Route::get('get-appointment', 'getAppointment')->name('get-appointment');
    });

    Route::controller(EventController::class)->group(function (){
        Route::get('event', 'index')->name('event');
        Route::get('event/create', 'create')->name('event.create');
        Route::get('get-event', 'getEvent')->name('get-event');
        Route::post('event', 'store')->name('event.store');
        Route::get('event/{id}/edit', 'edit')->name('event.edit');
        Route::get('event/{id}/show', 'show')->name('event.show');
        Route::put('event/{id}', 'update')->name('event.update');
        Route::delete('event/{id}', 'destroy')->name('event.delete');
        Route::get('create-metting', 'createZoomMetting');
        Route::post('delete-working-hours', 'deleteWorkingHours');
    });;

    Route::controller(OrderController::class)->group(function () {
        Route::get('order', 'index')->name('order.index');
        Route::get('get-order', 'getOrder')->name('get-order');
        Route::get('order/{id}/show', 'show')->name('order.show');
        Route::get('order-track/{id}', 'orderTrack')->name('order.track');
        Route::post('order-status-change', 'orderStatusChange')->name('order-status-change');
        Route::post('save-shipment-status', 'saveShipmentStatus')->name('save-shipment-status');
        Route::post('get-tracking-history', 'getTrackingHistory')->name('get-tracking-history');
    });

    Route::controller(SettingsController::class)->group(function (){
        Route::post('send-test-mail', 'sendTestMail')->name('send-test-mail');
        Route::post('send-test-sms', 'sendTestSMS')->name('send-test-sms');
        Route::get('user-change-password', 'userChangePassword')->name('user-change-password');
        Route::get('general-setting', 'generalSetting')->name('general-setting');
        Route::get('email-setting', 'emailSetting')->name('email-setting');
        Route::get('order-setting', 'orderSetting')->name('order-setting');
        Route::get('order-shipping-setting', 'orderShippingSetting')->name('order-shipping-setting');
        Route::get('sms-setting', 'smsSetting')->name('sms-setting');
        Route::get('payment-gateway-setting', 'paymentGateWaySetting')->name('payment-gateway-setting');
        Route::get('zoom-setting', 'zoomSetting')->name('zoom-setting');
        Route::get('setting', 'index')->name('setting');
        Route::post('save-general-setting','saveGeneralSetting')->name('save-general-setting');
        Route::post('save-order-setting','saveOrderSetting')->name('save-order-setting');
        Route::post('save-email-setting','saveEmailSetting')->name('save-email-setting');
        Route::post('save-sms-setting','saveSMSSetting')->name('save-sms-setting');
        Route::post('save-payment-gateway-setting','savePaymentGateWaySetting')->name('save-payment-gateway-setting');
        Route::post('save-zoom-setting','saveZoomSetting')->name('save-zoom-setting');
        Route::put('user-update/{id}', 'userUpdate')->name('user-update');
        Route::post('change-password', 'updatePassword')->name('change-password');
    });

    Route::controller(FedexController::class)->group(function () {
        Route::get('sending-order-fedex','getSendingOrderTrackingDetails')->name('sending-order-fedex');
        Route::get('receiving-order-fedex','getReceivingOrderTrackingDetails')->name('receiving-order-fedex');
        Route::get('sending-lab-fedex','getSendingLabTrackingDetails')->name('sending-lab-fedex');
        Route::get('receiving-lab-fedex','getReceivingLabTrackingDetails')->name('receiving-lab-fedex');
    });

});

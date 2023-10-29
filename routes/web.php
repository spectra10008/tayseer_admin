<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\FormRequestController;
use App\Http\Controllers\Frontend\FormRequestController as FrontendFormRequest;
use App\Http\Controllers\FundTypeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupRegisterTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanProductController;
use App\Http\Controllers\MfiProviderController;
use App\Http\Controllers\MfiProviderUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Providers\Auth\ProfileController as profile_mfi;
use App\Http\Controllers\Providers\FormRequestController as form_mfi;
use App\Http\Controllers\Providers\HomeController as home_mfi;
use App\Http\Controllers\Providers\LoanController as loan_mfi;
use App\Http\Controllers\Providers\InstallmentController as installment_mfi;
use App\Http\Controllers\Providers\VendorController as vendor_mfi;
use App\Http\Controllers\Providers\UserController as users_mfi;

use App\Http\Controllers\SectorController;
use App\Http\Controllers\SocialSituationController;

// mfi providers controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::redirect('/', '/panel-admin/login');
Route::get('/form-request', [FrontendFormRequest::class, 'index']);
Route::post('/form-request', [FrontendFormRequest::class, 'store']);
Route::get('/result', [FrontendFormRequest::class, 'result']);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('panel-admin')->middleware(['auth', 'web'])->group(function () {

    Route::get('/edit_profile', [ProfileController::class, 'edit_profile']);
    Route::post('/update_profile', [ProfileController::class, 'update_profile']);
    Route::post('/update_password', [ProfileController::class, 'update_password']);

    Route::post('/add-beneficiaries-group', [GroupController::class, 'add_beneficiaries_group']);
    Route::get('/delete-beneficiaries-group/{id}', [GroupController::class, 'delete_beneficiaries_group']);

    Route::post('/add-beneficiaries-project', [ProjectController::class, 'add_beneficiaries_project']);
    Route::get('/delete-beneficiaries-project/{id}', [ProjectController::class, 'delete_beneficiaries_project']);

    // upload beneficiaries files
    Route::post('/add-beneficiaries-file', [BeneficiaryController::class, 'add_beneficiaries_file']);
    Route::get('/delete-beneficiaries-file/{id}', [BeneficiaryController::class, 'delete_beneficiaries_file']);

    // upload files
    Route::post('/add-project-file', [ProjectController::class, 'add_project_file']);
    Route::get('/delete-project-file/{id}', [ProjectController::class, 'delete_project_file']);

    // request form proccess
    Route::get('/form-sms/{id}', [FormRequestController::class, 'form_sms']);
    Route::post('/form-send-sms', [FormRequestController::class, 'form_send_sms']);

    //
    Route::post('/form-requets/approved', [FormRequestController::class, 'form_request_approved']);
    Route::post('/form-requets/transferـreview', [FormRequestController::class, 'transferـreview']);
    Route::post('/form-requets/reject', [FormRequestController::class, 'form_request_reject']);

    Route::post('/form-requets/add-note', [FormRequestController::class, 'add_note']);
    Route::delete('/form-requets/remove-note/{id}', [FormRequestController::class, 'remove_note']);
    Route::post('/form-requets/check-note', [FormRequestController::class, 'check_note']);
    Route::get('/form-requets/note-change-status/{id}/{status_id}', [FormRequestController::class, 'note_change_status']);

    Route::post('/form-requets/transfer-mfi', [FormRequestController::class, 'transferـmfi']);

    // upload form request files
    Route::post('/add-form-requets-file', [FormRequestController::class, 'add_form_requets_file']);
    Route::get('/delete-form-requets-file/{id}', [FormRequestController::class, 'delete_form_requets_file']);

    // system installment divides
    Route::post('/system-installments', [InstallmentController::class, 'system_installments']);

    Route::resource('/users', UserController::class);
    Route::resource('/social-situations', SocialSituationController::class);
    Route::resource('/sectors', SectorController::class);
    Route::resource('/fund-types', FundTypeController::class);
    Route::resource('/group-register-types', GroupRegisterTypeController::class);
    Route::resource('/banks', BankController::class);
    Route::resource('/vendors', VendorController::class);
    Route::resource('/beneficiaries', BeneficiaryController::class);
    Route::resource('/groups', GroupController::class);
    Route::resource('/projects', ProjectController::class);
    Route::resource('/form-requets', FormRequestController::class);
    Route::resource('/installments', InstallmentController::class);
    Route::resource('/loans-products', LoanProductController::class);
    Route::resource('/loans', LoanController::class);
    Route::resource('/mfis', MfiProviderController::class);
    Route::resource('/mfis-users', MfiProviderUserController::class);

    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::get('/notifications', [HomeController::class, 'notifications']);
    Route::get('/notifications_read', [HomeController::class, 'notification_read']);
});

Route::prefix('panel-mfi')->middleware(['auth:mfis_providers', 'web'])->group(function () {
    Route::get('/dashboard', [home_mfi::class, 'index']);

    Route::get('/edit_profile', [profile_mfi::class, 'edit_profile']);
    Route::post('/update_profile', [profile_mfi::class, 'update_profile']);
    Route::post('/update_password', [profile_mfi::class, 'update_password']);

    // request form proccess
    Route::get('/form-sms/{id}', [form_mfi::class, 'form_sms']);
    Route::post('/form-send-sms', [form_mfi::class, 'form_send_sms']);

    Route::post('/form-requets/add-note', [form_mfi::class, 'add_note']);
    Route::delete('/form-requets/remove-note/{id}', [form_mfi::class, 'remove_note']);
    Route::post('/form-requets/check-note', [form_mfi::class, 'check_note']);
    Route::get('/form-requets/note-change-status/{id}/{status_id}', [form_mfi::class, 'note_change_status']);
    Route::post('/form-requets/approved', [form_mfi::class, 'form_request_approved']);
    Route::post('/form-requets/transferـreview', [form_mfi::class, 'transferـreview']);
    Route::post('/form-requets/reject', [form_mfi::class, 'form_request_reject']);

    // upload form request files
    Route::post('/add-form-requets-file', [form_mfi::class, 'add_form_requets_file']);
    Route::get('/delete-form-requets-file/{id}', [form_mfi::class, 'delete_form_requets_file']);


    Route::resource('/loans', loan_mfi::class);
    Route::resource('/form-requets', form_mfi::class);
    Route::resource('/installments', installment_mfi::class);
    Route::post('/system-installments', [installment_mfi::class, 'system_installments']);

    Route::resource('/vendors', vendor_mfi::class);
    Route::resource('/mfi-users', users_mfi::class);
    Route::get('/notifications', [home_mfi::class, 'notifications']);
    Route::get('/notifications_read', [home_mfi::class, 'notification_read']);

});
require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SocialSituationController;
use App\Http\Controllers\FundTypeController;
use App\Http\Controllers\GroupRegisterTypeController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FormRequestController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanProductController;
use App\Http\Controllers\LoanController;

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
Route::redirect('/', '/panel-admin/login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::prefix('panel-admin')->middleware(['auth','web'])->group(function () {

    Route::get('/edit_profile',[ProfileController::class,'edit_profile']);
    Route::post('/update_profile',[ProfileController::class,'update_profile']);
    Route::post('/update_password',[ProfileController::class,'update_password']);

    Route::post('/add-beneficiaries-group',[GroupController::class,'add_beneficiaries_group']);
    Route::get('/delete-beneficiaries-group/{id}',[GroupController::class,'delete_beneficiaries_group']);

    Route::post('/add-beneficiaries-project',[ProjectController::class,'add_beneficiaries_project']);
    Route::get('/delete-beneficiaries-project/{id}',[ProjectController::class,'delete_beneficiaries_project']);

    // upload beneficiaries files
    Route::post('/add-beneficiaries-file',[BeneficiaryController::class,'add_beneficiaries_file']);
    Route::get('/delete-beneficiaries-file/{id}',[BeneficiaryController::class,'delete_beneficiaries_file']);

    // upload files
    Route::post('/add-project-file',[ProjectController::class,'add_project_file']);
    Route::get('/delete-project-file/{id}',[ProjectController::class,'delete_project_file']);

    // request form proccess
    Route::get('/form-sms/{id}',[FormRequestController::class,'form_sms']);
    Route::post('/form-send-sms',[FormRequestController::class,'form_send_sms']);

    //
    Route::post('/form-requets/approved',[FormRequestController::class,'form_request_approved']);
    Route::post('/form-requets/reject',[FormRequestController::class,'form_request_reject']);

    // upload form request files
    Route::post('/add-form-requets-file',[FormRequestController::class,'add_form_requets_file']);
    Route::get('/delete-form-requets-file/{id}',[FormRequestController::class,'delete_form_requets_file']);


    Route::resource('/users',UserController::class);
    Route::resource('/social-situations',SocialSituationController::class);
    Route::resource('/sectors',SectorController::class);
    Route::resource('/fund-types',FundTypeController::class);
    Route::resource('/group-register-types',GroupRegisterTypeController::class);
    Route::resource('/banks',BankController::class);
    Route::resource('/vendors',VendorController::class);
    Route::resource('/beneficiaries',BeneficiaryController::class);
    Route::resource('/groups',GroupController::class);
    Route::resource('/projects',ProjectController::class);
    Route::resource('/form-requets',FormRequestController::class);
    Route::resource('/installments',InstallmentController::class);
    Route::resource('/loans-products',LoanProductController::class);
    Route::resource('/loans',LoanController::class);


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});
require __DIR__ . '/auth.php';

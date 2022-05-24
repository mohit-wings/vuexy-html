<?php

use App\Http\Controllers\Access\PermissionController;
use App\Http\Controllers\Access\RoleController;
use App\Http\Controllers\Access\UserAccessController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BusinessTypeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CompanyTypeController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\MailSettingController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TotalEmployeeController;
use App\Http\Controllers\Admin\UserBrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::post('/change-status/{id}', [Controller::class, 'changeStatus'])->name('change-status');
Route::post('/check-exist', [Controller::class, 'checkExist'])->name('check.exist');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    // User Route's
    Route::resource('user', UserController::class);
    Route::post('user-datalist', [UserController::class, 'dataList'])->name('user.datalist');

    // Industry Route's
    Route::resource('industry', IndustryController::class);
    Route::post('industry-datalist', [IndustryController::class, 'dataList'])->name('industry.datalist');
});

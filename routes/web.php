<?php

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

Auth::user()->role == ''
*/

Route::get('/', function () {


    if (Auth::check()) {
        if (Auth::user()->role == '') {
            return view('hello');
        } else if (Auth::user()->role == 'vendor') {
            return redirect('/services');
        } else {
            return redirect('/dashboard');
        } 
    } else {
        return view('auth.login');
    }



});



Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/map', [App\Http\Controllers\DashboardController::class, 'map'])->name('map')->middleware('auth');



Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');





Auth::routes();
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'], [App\Http\Controllers\VendorsController::class, 'index'])->name('dashboard')->middleware('auth');
Route::resource('vendors', App\Http\Controllers\VendorsController::class)->middleware('auth');
Route::resource('contacts', App\Http\Controllers\contactsController::class)->middleware('auth');
Route::get('/sendbasicemail', [App\Http\Controllers\MailController::class, 'basic_email'])->middleware('auth');
Route::get('/sendhtmlemail', [App\Http\Controllers\MailController::class, 'html_email'])->middleware('auth');
Route::get('/sendattachmentemail', [App\Http\Controllers\MailController::class, 'attachment_email'])->middleware('auth');
Route::resource('services', App\Http\Controllers\ServicesController::class)->middleware('auth');

Route::post('someurl', [App\Http\Controllers\ServicesController::class, 'someMethod'])->middleware('auth');
Route::post('inventories/mount', [App\Http\Controllers\inventoryController::class, 'mount'])->middleware('auth');
Route::post('comments/new', [App\Http\Controllers\CommentsController::class, 'newComment'])->middleware('auth');


Route::resource('units', App\Http\Controllers\UnitsController::class)->middleware('auth');

Route::resource('activities', App\Http\Controllers\ActivitiesController::class)->middleware('auth');
Route::post('/activities/unitcounter', [App\Http\Controllers\ActivitiesController::class, 'unitCounter'])->middleware('auth');



Route::get('/file-upload', [App\Http\Controllers\FileUploadController::class, 'fileUpload'])->name('file.upload')->middleware('auth');
Route::post('/file-upload', [App\Http\Controllers\FileUploadController::class, 'fileUploadPost'])->name('file.upload.post')->middleware('auth');

// custom fileupload delete and download functions
Route::get('/file-upload/download/{type}/{id}/{file}', [App\Http\Controllers\FileUploadController::class, 'getDownload'])->middleware('auth');
Route::get('/file-upload/delete/{type}/{id}/{file}', [App\Http\Controllers\FileUploadController::class, 'getDelete'])->middleware('auth');


Route::post('/profile/update/photo', [App\Http\Controllers\ProfileController::class, 'photo'])->name('profile.photo.post')->middleware('auth');



Route::get('/filemanager', [App\Http\Controllers\FileManagerController::class, 'index'])->middleware('auth');

Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth');

Route::resource('serviceTypes', App\Http\Controllers\serviceTypeController::class)->middleware('auth');


Route::resource('rents', App\Http\Controllers\RentController::class)->middleware('auth');


Route::resource('inventories', App\Http\Controllers\inventoryController::class)->middleware('auth');


Route::resource('makeLists', App\Http\Controllers\makeListController::class)->middleware('auth');
Route::resource('customers', App\Http\Controllers\CustomersController::class)->middleware('auth');


// example "reports/view/rental/returns/2022/04"
Route::get('reports/{api}/rental/{type}/{year}/{month}', [App\Http\Controllers\ReportsController::class, 'rental'])->middleware('auth');

Route::get('reports/{api}/rental/gantt/{type}/', [App\Http\Controllers\ReportsController::class, 'gantt'])->middleware('auth');

Route::get('reports/{api}/counter/{type}/{year}/{month}', [App\Http\Controllers\ReportsController::class, 'counter'])->middleware('auth');

Route::get('reports/{api}/orderValue/', [App\Http\Controllers\ReportsController::class, 'orderValue'])->middleware('auth');




Route::post('/search', [App\Http\Controllers\searchController::class, 'search'])->name('globalSearch')->middleware('auth');

Route::get('generate-pdf', [App\Http\Controllers\PDFController::class, 'generatePDF'])->middleware('auth');

Route::get('unitStatus/counter', [App\Http\Controllers\UnitStatusController::class, 'counter'])->middleware('auth');
Route::get('unitStatus/dates', [App\Http\Controllers\UnitStatusController::class, 'dates'])->middleware('auth');
Route::get('unitStatus/parts', [App\Http\Controllers\UnitStatusController::class, 'parts'])->middleware('auth');

Route::get('units/servicePlan/{id}/{type}', [App\Http\Controllers\UnitsController::class, 'generateServicePlan'])->middleware('auth');
Route::get('units/inservice/{id}/{value}', [App\Http\Controllers\UnitsController::class, 'inService'])->middleware('auth');

Route::get('unitstatusupdate', [App\Http\Controllers\UnitsController::class, 'updateUnitStatus'])->middleware('auth');
Route::get('oneunitstatusupdate/{id}', [App\Http\Controllers\UnitsController::class, 'updateOneUnitStatus'])->middleware('auth');


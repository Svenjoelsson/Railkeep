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
*/

Route::get('/', function () {
    
    if (Auth::check()) {
        return view('dashboard');
    } else {
        return view('auth.login');
    }
});



Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');


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
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'], [App\Http\Controllers\VendorsController::class, 'index'])->name('dashboard');
Route::resource('vendors', App\Http\Controllers\VendorsController::class);
Route::resource('contacts', App\Http\Controllers\contactsController::class);
Route::get('/sendbasicemail', [App\Http\Controllers\MailController::class, 'basic_email']);
Route::get('/sendhtmlemail', [App\Http\Controllers\MailController::class, 'html_email']);
Route::get('/sendattachmentemail', [App\Http\Controllers\MailController::class, 'attachment_email']);
Route::resource('services', App\Http\Controllers\ServicesController::class);

Route::post('someurl', [App\Http\Controllers\ServicesController::class, 'someMethod']);


Route::resource('units', App\Http\Controllers\UnitsController::class);
Route::resource('activities', App\Http\Controllers\ActivitiesController::class);

Route::get('/file-upload', [App\Http\Controllers\FileUploadController::class, 'fileUpload'])->name('file.upload');
Route::post('/file-upload', [App\Http\Controllers\FileUploadController::class, 'fileUploadPost'])->name('file.upload.post');

// custom fileupload delete and download functions
Route::get('/file-upload/download/{type}/{id}/{file}', [App\Http\Controllers\FileUploadController::class, 'getDownload']);
Route::get('/file-upload/delete/{type}/{id}/{file}', [App\Http\Controllers\FileUploadController::class, 'getDelete']);




Route::get('/filemanager', [App\Http\Controllers\FileManagerController::class, 'index']);

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index']);

Route::resource('serviceTypes', App\Http\Controllers\serviceTypeController::class);


Route::resource('rents', App\Http\Controllers\RentController::class);


Route::resource('inventories', App\Http\Controllers\inventoryController::class);


Route::resource('makeLists', App\Http\Controllers\makeListController::class);
Route::resource('customers', App\Http\Controllers\CustomersController::class);

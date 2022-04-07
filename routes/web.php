<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

/* Without NameSpace Routes */
//Route::resource('/', ContactController::class, ['as'=>'contact']);                                                                                                                                                                                                                                                                                                                                                                                                
//Route::post('/', [ContactController::class, 'import']);

//With NameSpace routes
Route::get('/', function()
{
    return View::make('contact.index');
});
Route::resource('contact', 'ContactController', ['names' => ['contact' => 'contact']] , ['as'=>'contact']);
Route::post('contact/import', [ 'as' => 'contact.import', 'uses' => 'ContactController@import']);
Route::get('/datatable', [ 'as' => 'contact.datatable', 'uses' => 'ContactController@datatable']);
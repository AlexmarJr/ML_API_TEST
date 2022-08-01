<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainControler;
use App\Models\ML_Categories;
use Illuminate\Support\Facades\DB;
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
    $data = ML_Categories::all();
    return view('ml', compact('data'));
    /* Eu sei eu sei, campact é coisa de doente, mas nao quis usar ajax pq namoral,
    tempo é meu melhor amigo, e nao quero perder ele, tem no meu git la uns projeto com ajax caso queira ver */
});

Route::get('/wipe_api_data', function () {
    ML_Categories::truncate();
    return redirect('/');
})->name('wipe_api_data');

Route::get('/loadData', [MainControler::class, 'loadMLData']);
Route::get('/details/{id?}', [MainControler::class, 'details']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homecontroller;

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
    return view('home.index');
});

Route::get('/registration', function () {
    return view('home.registration');
});

Route::get('login', function () {
    return view('home.login');
});

// Route::get('adminview', function () {
//     return view('home.adminview');
// });
Route::get('sign', function () {
    return view('home.sign');
});

Route::get('registration_copy', function () {
    return view('home.registration_copy');
});




Route::post('coursesave', [homecontroller::class, 'coursesave']);
Route::post('admin_check_login', [homecontroller::class, 'admin_login_check']);
Route::get('dashboard', [homecontroller::class, 'dashboardview']);

Route::get('adminview', [homecontroller::class, 'adminview']);

Route::get('{id?}', [homecontroller::class, 'adminshow']);


<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\UserSession;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/login', function () {
    $sessions = UserSession::all();
    $loggedInUsers = [];

    foreach ($sessions as $session) {
        $user = User::find($session->user_id);
        if ($user) {
            $loggedInUsers[] = $user;
        }
    }
    return view('auth.login',compact('loggedInUsers'));
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

// Show the dashboard
Route::get('/dashboard', function () {
    $sessions = UserSession::all();
        $loggedInUsers = [];

        foreach ($sessions as $session) {
            $user = User::find($session->user_id);
            if ($user) {
                $loggedInUsers[] = $user;
            }
        }
    return view('dashboard',compact('loggedInUsers'));
})->middleware(['auth'])->name('dashboard');

// Switch to a different user
Route::get('/user/switch/{user}', function ($user) {
    $user = \App\Models\User::findOrFail($user);
    \App\Models\UserSession::create([
        'user_id' => $user->id,
        'session_id' => session()->getId(),
    ]);
    Auth::login($user);
    return redirect()->route('dashboard');
})->middleware(['auth'])->name('user.switch');

// Logout a specific user
Route::post('/user/logout/{user_id}', function ($user_id) {
    $session = \App\Models\UserSession::where('user_id', $user_id)
        // ->where('session_id', session()->getId())
        ->first();
    if ($session) {
        $session->delete();
    }
    $session = \App\Models\UserSession::first();
    if($session){
        return back();
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('user.logout');



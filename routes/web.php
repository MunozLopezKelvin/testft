<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\HomeController;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-google', function () {
    //Llamamos a los servicios de Google para que envíe a la página de consentimiento al cliente.
    return Socialite::driver('google')->redirect();
});
 
Route::get('/google-callback', function () {
    //Los datos de usuario que nos regresa Google los almacenamos en $user
    $user = Socialite::driver('google')->user();
    //Utilizando condicionantes y el método exists() validamos si el usuario ya existe en nuestra BD
    $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->exists();

        if($userExists){
            return redirect('/home');
        }else{
        //En caso de que el usuario no exista lo creamos y alacenamos
        $userNew = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google',
        ]);
        //Una vez creado lo enviamos con un login y los datos del usuario
        Auth::login($userNew);
        }
        return redirect('/home');
        //return redirect('/dashboard');
    // $user->token
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login-facebook', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/facebook-callback', function () {
    $user = Socialite::driver('facebook')->user();
    $userExists = User::where('external_id', $user->id)->where('external_auth', 'facebook')->exists();

        if($userExists){
            Auth::login($userExists);
        }else{
        $userNew = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'facebook',
        ]);
        Auth::login($userNew);
        }
        dd($user);
        //return redirect('/dashboard');
});

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario está autenticado
        if ($user) {
            // Obtener los datos del usuario
            $name = $user->name;
            $email = $user->email;
            $avatar = $user->avatar;

            // Retornar la vista con los datos del usuario
            return view('home', compact('name', 'email', 'avatar'));
        } else {
            // Si el usuario no está autenticado, redirigir al inicio de sesión
            return redirect()->route('login');
        }
    }
}

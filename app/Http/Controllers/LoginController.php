<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use TwigBridge\Facade\Twig;

class LoginController extends Controller
{
    //
    public function index() {
        return Twig::render('login');
    }

    public function login() {
        $this->validate(request(),[
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        return redirect('home');
    }
}

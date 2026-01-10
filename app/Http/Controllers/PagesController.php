<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        return view('welcome');
    }
    public function apropos()
    {
        return view('pages.Apropos');
    }

    public function fonctionnalite()
    {
        return view('pages.Fonctionnalite');
    }

    public function contact()
    {
        return view('pages.Contact');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
}

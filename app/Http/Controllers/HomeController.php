<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Retorna a tela de dashboard
     *
     * @return View
     */
    public function index(): View
    {
        return view('dashboard');
    }

}

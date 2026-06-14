<?php

namespace App\Http\Controllers;

use App\Models\Aviso;

class HomeController extends Controller
{
    public function index()
    {
        $urgentes   = Aviso::pendientes()->where('prioridad', 'urgente')->latest()->get();
        $generales  = Aviso::pendientes()->where('prioridad', 'general')->latest()->get();
        $historial  = Aviso::where('completado', true)->latest()->get();

        return view('home', compact('urgentes', 'generales', 'historial'));
    }
}

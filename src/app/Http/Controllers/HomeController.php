<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $urgentes = [
            (object)['id' => 1, 'texto' => 'Revisar frenos de la Honda CB500 antes del jueves'],
            (object)['id' => 2, 'texto' => 'Llamar al cliente Martínez — reserva sin confirmar'],
        ];

        $generales = [
            (object)['id' => 3, 'texto' => 'Pasar ITV a la Yamaha MT-07 este mes'],
            (object)['id' => 4, 'texto' => 'Reponer aceite en el almacén'],
            (object)['id' => 5, 'texto' => 'Actualizar tarifas de temporada alta'],
        ];

        return view('home', compact('urgentes', 'generales'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Moto;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Reservas SIN moto asignada
        $reservasSinMoto = Reserva::with('moto')
            ->whereNull('moto_id')
            ->orderBy('fecha_desde')
            ->get();

        // Reservas CON moto asignada
        $reservasConMoto = Reserva::with('moto')
            ->whereNotNull('moto_id')
            ->orderBy('fecha_desde')
            ->get();

        return view('reservas.index', compact('reservasSinMoto', 'reservasConMoto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Listado de motos “libres” o “reservables”
        $motos = Moto::pluck('modelo', 'id');
        return view('reservas.create', compact('motos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'moto_id'      => 'nullable|exists:motos,id',
            'cliente'      => 'nullable|string|max:255',
            'fecha_desde'  => 'required|date',
            'fecha_hasta'  => 'required|date|after_or_equal:fecha_desde',
        ]);

        Reserva::create($data);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        $motos = Moto::pluck('modelo', 'id');
        return view('reservas.edit', compact('reserva', 'motos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $data = $request->validate([
            'moto_id'      => 'nullable|exists:motos,id',
            'cliente'      => 'nullable|string|max:255',
            'fecha_desde'  => 'required|date',
            'fecha_hasta'  => 'required|date|after_or_equal:fecha_desde',
        ]);

        $reserva->update($data);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada.');
    }
}

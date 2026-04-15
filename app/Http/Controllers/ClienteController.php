<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Muestra el formulario
    public function create()
    {
        return view('clientes.create');
    }

    // Guarda el cliente en la BD
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|unique:clientes|max:15',
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'nullable|email|unique:clientes',
        ]);

        Cliente::create($validated);

        return redirect()->back()->with('success', 'Cliente guardado correctamente.');
    }
}

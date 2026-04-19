<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\Repuesto;
use App\Mail\EstadoTicketMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $estado = $request->input('estado');

        $tickets = Ticket::with('cliente')
            // Lógica de búsqueda avanzada
            ->when($buscar, function ($query, $buscar) {
                return $query->where(function ($q) use ($buscar) {
                    // Buscamos en la tabla de tickets (código del parte)
                    $q->where('codigo', 'LIKE', "%{$buscar}%")
                        // Y buscamos dentro de la relación con el cliente
                        ->orWhereHas('cliente', function ($subQuery) use ($buscar) {
                            $subQuery->where('nombre', 'LIKE', "%{$buscar}%")
                                ->orWhere('apellidos', 'LIKE', "%{$buscar}%")
                                ->orWhere('telefono', 'LIKE', "%{$buscar}%")
                                ->orWhere('dni', 'LIKE', "%{$buscar}%");
                        });
                });
            })
            // Filtro por estado (si existe)
            ->when($estado, function ($query, $estado) {
                return $query->where('estado', $estado);
            })
            ->latest()
            ->get();

        return view('tickets.index', compact('tickets'));
    }


    public function consultar(Request $request)
    {
        // Buscamos el ticket por el código introducido
        $ticket = Ticket::where('codigo', $request->codigo)->first();

        if (!$ticket) {
            // CAMBIO CLAVE: Usamos withErrors para que se guarde en la bolsa de errores de 'codigo'
            // y withInput para que el código mal escrito no se borre del cuadro
            return back()
                ->withInput()
                ->withErrors(['codigo' => 'El número de parte no existe o es incorrecto.']);
        }

        return view('tickets.estado', compact('ticket'));
    }


    public function show(Ticket $ticket)
    {
        // Cargamos el cliente y los repuestos usados
        $ticket->load(['cliente', 'repuestos']);
        return view('tickets.show', compact('ticket'));
    }


    public function create()
    {
        $clientes = Cliente::all();
        return view('tickets.create', compact('clientes'));
    }

    public function historialCliente(Cliente $cliente)
    {
        // Cargamos todos los tickets de este cliente, del más nuevo al más viejo
        $tickets = Ticket::where('cliente_id', $cliente->id)->latest()->get();

        return view('admin.historial_cliente', compact('cliente', 'tickets'));
    }


    public function store(Request $request)
    {
        if (!$request->cliente_id) {
            $request->validate([
                // DNI: 8 números y una letra (mayúscula o minúscula)
                'nuevo_dni' => [
                    'required',
                    'unique:clientes,dni',
                    'regex:/^[0-9]{8}[a-zA-Z]$/'
                ],
                // Nombre y Apellidos: Solo letras y espacios
                'nuevo_nom' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'nuevo_ape' => 'nullable|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                // Teléfono: Exactamente 9 números
                'nuevo_tel' => 'required|digits:9',
                // Email: Formato correcto
                'nuevo_email' => 'nullable|email',
            ], [
                // Mensajes personalizados (Requisito: emitir mensajes apropiados de error)
                'nuevo_dni.required' => 'El DNI es obligatorio para nuevos clientes.',
                'nuevo_dni.unique' => 'Este DNI ya está registrado en el sistema.',
                'nuevo_dni.regex' => 'El DNI debe tener 8 números y una letra (ej: 12345678A).',
                'nuevo_nom.required' => 'El nombre del cliente es obligatorio.',
                'nuevo_nom.regex' => 'El nombre solo puede contener letras.',
                'nuevo_ape.regex' => 'Los apellidos solo pueden contener letras.',
                'nuevo_tel.required' => 'El teléfono es necesario para avisar al cliente.',
                'nuevo_tel.digits' => 'El teléfono debe tener exactamente 9 dígitos.',
                'nuevo_email.email' => 'Introduce una dirección de correo válida.',
            ]);

            $cliente = Cliente::create([
                'dni' => $request->nuevo_dni,
                'nombre' => $request->nuevo_nom,
                'apellidos' => $request->nuevo_ape,
                'telefono' => $request->nuevo_tel,
                'email' => $request->nuevo_email,
            ]);
            $cliente_id = $cliente->id;
        } else {
            $cliente_id = $request->cliente_id;
            $cliente = Cliente::find($cliente_id);
        }

        // Validación de datos del equipo (también obligatorios)
        $request->validate([
            'equipo' => 'required|min:3',
            'averia' => 'required|min:5',
        ], [
            'equipo.required' => 'Debes indicar qué equipo se está recibiendo.',
            'averia.required' => 'Es necesario describir la avería.',
        ]);

        // Generar Código Correlativo SAT-00X
        $ultimo = Ticket::latest()->first();
        $num = $ultimo ? ((int) str_replace('SAT-', '', $ultimo->codigo)) + 1 : 1;
        $codigo = 'SAT-' . str_pad($num, 3, '0', STR_PAD_LEFT);

        // Crear el Ticket
        $ticket = Ticket::create([
            'codigo' => $codigo,
            'cliente_id' => $cliente_id,
            'equipo' => $request->equipo,
            'averia' => $request->averia,
            'estado' => 'Recibido',
        ]);

        // --- ENVÍO AUTOMÁTICO AL CREAR ---
        if ($cliente && $cliente->email) {
            try {
                Mail::to($cliente->email)->send(new EstadoTicketMail($ticket));
            } catch (\Exception $e) {
                Log::error("Error enviando correo: " . $e->getMessage());
            }
        }

        return redirect()->route('tickets.imprimir', $ticket->id);
    }

    public function imprimir(Ticket $ticket)
    {
        $ticket->load('cliente');
        return view('tickets.imprimir', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $clientes = Cliente::all();
        $repuestos = Repuesto::all();
        return view('tecnico.edit', compact('ticket', 'clientes', 'repuestos'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'equipo' => 'required|string|max:255',
            'estado' => 'required|in:Recibido,En Proceso,Esperando Repuesto,Listo,Entregado',
            'averia' => 'nullable|string|max:2000',          // Opcional, pero con límite
            'notas_tecnicas' => 'nullable|string|max:5000', // Opcional, pero con límite
        ]);
        // 1. Guardamos el estado previo y actualizamos los datos básicos
        $estadoAnterior = $ticket->estado;
        // Solo actualizamos los campos validados
        $ticket->update($request->only(['equipo', 'estado', 'averia', 'notas_tecnicas']));

        // 2. GESTIÓN DE REPUESTOS (Lo hacemos antes del correo para asegurar los datos)
        if ($request->filled('repuesto_id')) {
            $repuesto = Repuesto::findOrFail($request->repuesto_id);
            $cantidad = $request->cantidad_repuesto;

            if ($repuesto->stock_actual >= $cantidad) {
                $ticket->repuestos()->attach($repuesto->id, ['cantidad' => $cantidad]);
                $repuesto->decrement('stock_actual', $cantidad);
            } else {
                return back()->with('error', 'No hay stock suficiente de: ' . $repuesto->descripcion);
            }
        }

        // 3. ENVÍO AUTOMÁTICO SI PASA A LISTO (Con Try-Catch para evitar el Error 500)
        if ($estadoAnterior !== 'Listo' && $ticket->estado === 'Listo') {
            $ticket->load('cliente');

            if ($ticket->cliente && $ticket->cliente->email) {
                try {
                    // Intentamos el envío con Mailjet a través de Railway
                    Mail::to($ticket->cliente->email)->send(new EstadoTicketMail($ticket));

                    // Si llega aquí, el correo se envió bien
                    session()->flash('success', 'Parte actualizado y cliente notificado.');
                } catch (\Exception $e) {
                    // Si Railway o Mailjet fallan, registramos el error en el Log
                    Log::error("Error SMTP en Ticket {$ticket->codigo}: " . $e->getMessage());

                    // Avisamos al usuario pero permitimos que continúe
                    session()->flash('warning', 'Cambios guardados, pero no se pudo enviar el aviso al cliente.');
                }
            }
        } else {
            session()->flash('success', 'Parte actualizado correctamente.');
        }

        return redirect()->route('tickets.index');
    }


    public function destroyRepuesto(Ticket $ticket, $repuestoId, $cantidad)
    {
        // 1. Buscamos el repuesto en el almacén para devolverle el stock
        $repuestoAlmacen = \App\Models\Repuesto::find($repuestoId);

        if ($repuestoAlmacen) {
            // Devolvemos exactamente la cantidad de la línea pulsada
            $repuestoAlmacen->increment('stock_actual', $cantidad);

            // 2. Borramos SOLO UNA fila que coincida con el ticket, el repuesto Y LA CANTIDAD
            $ticket->repuestos()->newPivotStatement()
                ->where('ticket_id', $ticket->id)
                ->where('repuesto_id', $repuestoId)
                ->where('cantidad', $cantidad)
                ->limit(1) // Solo una, por si hubiera dos líneas de la misma cantidad
                ->delete();
        }

        return redirect()->back();
    }
}

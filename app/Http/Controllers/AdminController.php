<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\Repuesto;


class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'total_tickets' => \App\Models\Ticket::count(),
            'total_clientes' => \App\Models\Cliente::count(),
            'total_repuestos' => \App\Models\Repuesto::count(),
            'tickets_pendientes' => \App\Models\Ticket::where('estado', '!=', 'Entregado')->count(),
            'bajo_stock' => \App\Models\Repuesto::where('stock_actual', '<', 5)->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function usuariosIndex()
    {
        $usuarios = User::with('role')->get();
        $roles = Role::all();
        return view('admin.usuarios', compact('usuarios', 'roles'));
    }

    public function usuariosStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return back()->with('success', 'Usuario creado correctamente.');
    }
    public function usuariosEdit(User $user)
    {
        $roles = Role::all();
        return view('admin.usuarios_edit', compact('user', 'roles'));
    }

    public function usuariosUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'activo' => 'required|in:0,1',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'activo' => $request->activo, // Aquí recibirá el "0" o "1" del select
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function inventarioIndex()
    {
        $repuestos = \App\Models\Repuesto::all();
        return view('admin.inventario', compact('repuestos'));
    }
    public function inventarioStore(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
        ]);

        Repuesto::create($request->all());

        return back()->with('success', 'Producto añadido al inventario.');
    }
    public function inventarioEdit(Repuesto $repuesto)
    {
        return view('admin.inventario_edit', compact('repuesto'));
    }

    public function inventarioUpdate(Request $request, Repuesto $repuesto)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
        ]);

        $repuesto->update($request->all());

        return redirect()->route('admin.inventario')->with('success', 'Repuesto actualizado correctamente.');
    }
    public function inventarioDestroy(Repuesto $repuesto)
    {
        // 1. Verificamos si el repuesto tiene tickets asociados (tabla ticket_repuesto)
        if ($repuesto->tickets()->exists()) {
            // Si existe relación, no borramos y devolvemos un mensaje de error
            return redirect()->route('admin.inventario')
                ->with('error', 'No se puede eliminar: Este repuesto ya ha sido utilizado en uno o más partes de trabajo.');
        }

        // 2. Si no tiene relaciones, procedemos al borrado
        $repuesto->delete();

        return redirect()->route('admin.inventario')
            ->with('success', 'Repuesto eliminado del catálogo correctamente.');
    }
    public function facturacionIndex()
    {
        // Obtenemos los tickets que tienen repuestos asociados
        $tickets = Ticket::with('repuestos', 'cliente')
            ->whereIn('estado', ['Listo', 'Entregado'])
            ->latest()
            ->get();

        // Calculamos el total global de todos los repuestos vendidos
        $totalFacturado = 0;
        foreach ($tickets as $ticket) {
            foreach ($ticket->repuestos as $repuesto) {
                $totalFacturado += $repuesto->precio * $repuesto->pivot->cantidad;
            }
        }

        return view('admin.facturacion', compact('tickets', 'totalFacturado'));
    }
    public function clientesIndex()
    {
        $clientes = \App\Models\Cliente::all();
        return view('admin.clientes', compact('clientes'));
    }

    public function clientesEdit(\App\Models\Cliente $cliente)
    {
        return view('admin.clientes_edit', compact('cliente'));
    }
    public function clientesUpdate(Request $request, \App\Models\Cliente $cliente)
    {
        $request->validate([
            'dni' => 'required|string|max:15|unique:clientes,dni,' . $cliente->id,
            'nombre' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'telefono' => 'required|digits:9',
            'email' => 'nullable|email|max:255',
        ], [
            // Mensajes personalizados para una interfaz amigable e intuitiva
            'dni.required' => 'El DNI es un campo obligatorio.',
            'dni.unique' => 'Este DNI ya pertenece a otro cliente registrado.',
            'nombre.required' => 'El nombre del cliente no puede estar vacío.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellidos.required' => 'Los apellidos son obligatorios para la ficha del cliente.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'telefono.required' => 'El teléfono es obligatorio para contactar con el cliente.',
            'telefono.digits' => 'El teléfono debe tener exactamente 9 números.',
            'email.email' => 'El formato del correo electrónico no es correcto.',
        ]);


        $cliente->update($request->all());

        return redirect()->route('admin.clientes')->with('success', 'Datos del cliente actualizados correctamente.');
    }
}

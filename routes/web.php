<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController; // Importante añadirlo aquí
use Illuminate\Support\Facades\Route;

// Landing Page (Doble Panel)
Route::get('/', function () {
    return view('welcome');
});

// RUTA PÚBLICA (Ruta pública para clientes)
Route::get('/consulta', [TicketController::class, 'consultar'])->name('tickets.consulta');

// ---------------------------------------------------------
// RUTAS PROTEGIDAS (Solo usuarios logueados)
// ---------------------------------------------------------
Route::middleware('auth')->group(function () {

    // Rutas para TÉCNICOS
    Route::get('/tecnico/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tecnico/tickets/crear', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tecnico/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tecnico/tickets/{ticket}/imprimir', [TicketController::class, 'imprimir'])->name('tickets.imprimir');
    Route::get('/tecnico/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tecnico/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}/repuesto/{repuesto}/{cantidad}', [TicketController::class, 'destroyRepuesto'])
        ->name('tickets.repuesto.destroy');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    // Rutas de Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------------------------------------
    // RUTAS EXCLUSIVAS DE ADMINISTRADOR (Escudo 'admin')
    // ---------------------------------------------------------
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/usuarios', [AdminController::class, 'usuariosIndex'])->name('admin.usuarios');
        Route::post('/usuarios', [AdminController::class, 'usuariosStore'])->name('admin.usuarios.store');
        Route::get('/inventario', [AdminController::class, 'inventarioIndex'])->name('admin.inventario');
        Route::post('/inventario', [AdminController::class, 'inventarioStore'])->name('admin.inventario.store');
        Route::get('/inventario/{repuesto}/edit', [AdminController::class, 'inventarioEdit'])->name('admin.inventario.edit');
        Route::put('/inventario/{repuesto}', [AdminController::class, 'inventarioUpdate'])->name('admin.inventario.update');
        Route::delete('/inventario/{repuesto}', [AdminController::class, 'inventarioDestroy'])->name('admin.inventario.destroy');
        Route::get('/facturacion', [AdminController::class, 'facturacionIndex'])->name('admin.facturacion');
        Route::get('/clientes', [AdminController::class, 'clientesIndex'])->name('admin.clientes');
        Route::get('/clientes/{cliente}/edit', [AdminController::class, 'clientesEdit'])->name('admin.clientes.edit');
        Route::put('/clientes/{cliente}', [AdminController::class, 'clientesUpdate'])->name('admin.clientes.update');
        Route::get('/usuarios/{user}/edit', [AdminController::class, 'usuariosEdit'])->name('admin.usuarios.edit');
        Route::put('/usuarios/{user}', [AdminController::class, 'usuariosUpdate'])->name('admin.usuarios.update');
        Route::get('/clientes/{cliente}/historial', [App\Http\Controllers\TicketController::class, 'historialCliente'])->name('clientes.historial');
    });
});

require __DIR__ . '/auth.php';

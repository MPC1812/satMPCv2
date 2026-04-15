<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control - Administración SAT MPC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- SECCIÓN 1: Estadísticas Rápidas (Resumen de las 6 tablas) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card Tickets -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Partes Totales</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_tickets }}</p>
                </div>

                <!-- Card Clientes -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Clientes Registrados</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_clientes }}</p>
                </div>

                <!-- Card Stock -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Repuestos en Catálogo</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $total_repuestos }}</p>
                </div>

                <!-- Card Pendientes -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Trabajos en Curso</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $tickets_pendientes }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- SECCIÓN 2: Alertas de Stock (Tabla Repuestos) -->
                <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                        <span class="bg-red-100 p-2 rounded-lg mr-2">⚠️</span>
                        Bajo Stock
                    </h3>
                    <div class="space-y-4">
                        @forelse($bajo_stock as $item)
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">{{ $item->descripcion }}</span>
                                <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                                    {{ $item->stock_actual }} ud.
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No hay alertas de stock.</p>
                        @endforelse
                    </div>
                </div>

                <!-- SECCIÓN 3: Accesos Rápidos de Gestión (Roles y Usuarios) -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700 mb-6">Gestión del Sistema</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Gestión de Usuarios y Roles -->
                        <a href="{{ route('admin.usuarios') }}" class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition-colors group">
                            <div class="bg-blue-100 p-3 rounded-lg group-hover:bg-blue-200">👥</div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-800">Usuarios y Roles</p>
                                <p class="text-xs text-gray-500">Configurar técnicos y administradores</p>
                            </div>
                        </a>
                        <!-- Gestión de Inventario (Vamos a crear esta ruta ahora) -->
                        <a href="{{ route('admin.inventario') }}" class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-green-50 transition-colors group">
                            <div class="bg-green-100 p-3 rounded-lg group-hover:bg-green-200">🛠️</div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-800">Inventario</p>
                                <p class="text-xs text-gray-500">Actualizar precios y stock general</p>
                            </div>
                        </a>

                        <!-- Facturación/Informes -->
                        <a href="{{ route('admin.facturacion') }}" class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-colors group">
                            <div class="bg-purple-100 p-3 rounded-lg group-hover:bg-purple-200">📊</div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-800">Facturación</p>
                                <p class="text-xs text-gray-500">Cierre de caja y piezas gastadas</p>
                            </div>
                        </a>

                        <!-- Clientes -->
                        <a href="{{ route('admin.clientes') }}" class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-orange-50 transition-colors group">
                            <div class="bg-orange-100 p-3 rounded-lg group-hover:bg-orange-200">📧</div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-800">Base de Clientes</p>
                                <p class="text-xs text-gray-500">Listado completo y DNI</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

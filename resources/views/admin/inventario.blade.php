<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Formulario: Añadir Nuevo Repuesto -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Añadir Nuevo Repuesto</h3>
                    <form action="{{ route('admin.inventario.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción de la pieza</label>
                            <input type="text" name="descripcion" placeholder="Ej: Pantalla LED 15.6" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Precio (€)</label>
                                <input type="number" name="precio" step="0.01" placeholder="0.00" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock Inicial</label>
                                <input type="number" name="stock_actual" placeholder="0" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 font-bold transition-colors">
                            Registrar en Almacén
                        </button>
                    </form>
                </div>

                <!-- Tabla de Inventario -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b">
                        <h3 class="font-bold text-gray-700 uppercase text-sm">Control de Stock y Precios</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">Producto</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase italic">Precio</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase italic">Stock</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase italic">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($repuestos as $repuesto)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $repuesto->descripcion }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-600 font-bold">{{ number_format($repuesto->precio, 2) }}€</td>
                                <td class="px-6 py-4 text-sm text-center">
                                    <span class="font-mono {{ $repuesto->stock_actual < 5 ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                        {{ $repuesto->stock_actual }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($repuesto->stock_actual <= 0)
                                        <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-800 rounded-full">Agotado</span>
                                    @elseif($repuesto->stock_actual < 5)
                                        <span class="px-2 py-1 text-xs font-bold bg-yellow-100 text-yellow-800 rounded-full">Pedido Nec.</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-800 rounded-full">Disponible</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right flex justify-end space-x-3">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('admin.inventario.edit', $repuesto->id) }}" 
                                    class="text-blue-600 hover:underline font-bold text-xs uppercase">
                                        Editar
                                    </a>

                                    <!-- Formulario para Borrar -->
                                    <form action="{{ route('admin.inventario.destroy', $repuesto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este repuesto? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-bold text-xs uppercase">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

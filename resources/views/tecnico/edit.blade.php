<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Editar Parte: <span class="text-blue-600">{{ $ticket->codigo }}</span>
                    </h2>
                    <a href="{{ route('tickets.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                        Volver al listado
                    </a>
                </div>

                <!-- FORMULARIO PRINCIPAL: ACTUALIZAR DATOS Y AÑADIR PIEZAS -->
                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Campo Equipo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Equipo</label>
                            <input type="text" name="equipo" value="{{ old('equipo', $ticket->equipo) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Selector de Estado -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado del Parte</label>
                            <select name="estado" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Recibido" {{ $ticket->estado == 'Recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="En Proceso" {{ $ticket->estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="Esperando Repuesto" {{ $ticket->estado == 'Esperando Repuesto' ? 'selected' : '' }}>Esperando Repuesto</option>
                                <option value="Listo" {{ $ticket->estado == 'Listo' ? 'selected' : '' }}>Listo</option>
                                <option value="Entregado" {{ $ticket->estado == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>

                        </div>
                    </div>

                    <!-- Campo Avería -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la Avería</label>
                        <textarea name="averia" rows="4" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('averia', $ticket->averia) }}</textarea>
                    </div>

                    <!-- Campo Notas Técnicas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones del Técnico</label>
                        <textarea name="notas_tecnicas" rows="3" placeholder="Detalles de la reparación..."
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notas_tecnicas', $ticket->notas_tecnicas) }}</textarea>
                    </div>

                    <!-- Selección de Repuestos -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase text-blue-600">Añadir Material al Parte</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs text-gray-500">Pieza / Repuesto</label>
                                <select name="repuesto_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Seleccionar pieza para añadir --</option>
                                    @foreach($repuestos as $repuesto)
                                        <option value="{{ $repuesto->id }}">
                                            {{ $repuesto->descripcion }} (Stock: {{ $repuesto->stock_actual }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500">Cantidad</label>
                                <input type="number" name="cantidad_repuesto" value="1" min="1" 
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Botón Guardar Cambios Principal -->
                    <div class="flex justify-end pt-4 border-b pb-6">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors">
                            Guardar Cambios y Piezas
                        </button>
                    </div>
                </form>

                <!-- TABLA DE REPUESTOS (FUERA DEL FORMULARIO ANTERIOR) -->
                <div class="mt-8">
                    <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase">Repuestos ya utilizados</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pieza</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Cant.</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($ticket->repuestos as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $item->descripcion }}</td>
                                    <td class="px-4 py-2 text-sm text-center font-bold">{{ $item->pivot->cantidad }}</td>
                                    <td class="px-4 py-2 text-sm text-right">
                                        <!-- Formulario de borrado independiente -->
                                        <form action="{{ route('tickets.repuesto.destroy', [$ticket->id, $item->id]) }}" method="POST" onsubmit="return confirm('¿Devolver esta pieza al stock?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs uppercase hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-sm text-gray-500 text-center italic">No hay repuestos asignados a este parte todavía.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

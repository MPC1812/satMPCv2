<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Resumen de Ingresos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border-l-8 border-green-500">
                <h3 class="text-gray-500 text-sm font-bold uppercase">Total Facturado en Repuestos</h3>
                <p class="text-4xl font-black text-gray-800">{{ number_format($totalFacturado, 2) }}€</p>
                <p class="text-xs text-gray-400 mt-1">* Solo se incluyen partes en estado 'Listo' o 'Entregado'</p>
            </div>

            <!-- Listado de Cobros -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase italic">Cód. Parte</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase italic">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase italic">Repuestos Utilizados</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase italic">Total Parte</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tickets as $ticket)
                        @php $subtotal = 0; @endphp
                        <tr>
                            <td class="px-6 py-4 text-sm font-bold text-blue-600">{{ $ticket->codigo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $ticket->cliente->nombre }}</td>
                            <td class="px-6 py-4 text-sm">
                                <ul class="list-disc list-inside text-gray-500 text-xs">
                                    @foreach($ticket->repuestos as $repuesto)
                                        @php $subtotal += $repuesto->precio * $repuesto->pivot->cantidad; @endphp
                                        <li>{{ $repuesto->descripcion }} (x{{ $repuesto->pivot->cantidad }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-gray-800">
                                {{ number_format($subtotal, 2) }}€
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

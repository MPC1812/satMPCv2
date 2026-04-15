<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">Base de Datos de Clientes</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">DNI</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Teléfono</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($clientes as $cliente)
                        <tr>
                            <td class="px-6 py-4 text-sm font-mono">{{ $cliente->dni }}</td>
                            <td class="px-6 py-4 text-sm">{{ $cliente->nombre }} {{ $cliente->apellidos }}</td>
                            <td class="px-6 py-4 text-sm">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="text-blue-600 font-bold hover:underline">Editar</a>
                                <a href="{{ route('clientes.historial', $cliente->id) }}" class="text-red-600 font-bold hover:underline">Historial</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

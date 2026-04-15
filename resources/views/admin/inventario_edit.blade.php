<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold mb-6">Corregir Repuesto: {{ $repuesto->descripcion }}</h2>

                <form action="{{ route('admin.inventario.update', $repuesto->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium">Nombre de la pieza</label>
                        <input type="text" name="descripcion" value="{{ $repuesto->descripcion }}" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Precio (€)</label>
                            <input type="number" name="precio" step="0.01" value="{{ $repuesto->precio }}" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Stock Actual</label>
                            <input type="number" name="stock_actual" value="{{ $repuesto->stock_actual }}" class="w-full border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('admin.inventario') }}" class="text-gray-500 hover:underline mt-2">Cancelar</a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

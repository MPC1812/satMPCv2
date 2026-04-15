<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-sm border">
                <h2 class="text-xl font-bold mb-6">Editar Usuario: {{ $user->name }}</h2>

                <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium">Nombre</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Rol</label>
                            <select name="role_id" class="w-full border-gray-300 rounded-md">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ $user->role_id == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Estado de Acceso</label>
                            <select name="activo" class="w-full border-gray-300 rounded-md">
                                <option value="1" {{ $user->activo ? 'selected' : '' }}>Permitido (Activo)</option>
                                <option value="0" {{ !$user->activo ? 'selected' : '' }}>Bloqueado (Inactivo)</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md mt-4 border border-blue-100">
                        <label class="block text-sm font-bold text-blue-800 mb-1">Cambiar Contraseña</label>
                        <input type="password" name="password" placeholder="Dejar en blanco para no cambiar" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex justify-end pt-4 space-x-3">
                        <a href="{{ route('admin.usuarios') }}" class="py-2 px-4 text-gray-600">Cancelar</a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

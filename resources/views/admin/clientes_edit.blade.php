<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen flex items-start justify-center">
        <div class="w-full max-w-xl px-4">
            
            <div class="bg-white p-8 rounded-[2rem] shadow-lg border border-slate-100">
                
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-50">
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase italic tracking-tighter">
                            Ficha: <span class="text-blue-600">{{ $cliente->nombre }}</span>
                        </h2>
                    </div>
                    <a href="{{ route('clientes.historial', $cliente->id) }}" class="text-[9px] font-bold text-slate-400 hover:text-blue-600 transition-colors uppercase italic">
                        <i class="fas fa-history mr-1"></i> Historial
                    </a>
                </div>

                <!-- Bloque de Errores -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                        <ul class="text-[10px] text-red-600 font-bold space-y-1">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-times-circle mr-1"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.clientes.update', $cliente->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Campo DNI oculto para que pase la validación -->
                    <input type="hidden" name="dni" value="{{ $cliente->dni }}">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black uppercase text-slate-400 italic tracking-widest ml-1">DNI (Bloqueado)</label>
                            <!-- Este es solo visual, no se envía -->
                            <input type="text" value="{{ $cliente->dni }}" disabled
                                   class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl font-bold text-xs text-slate-400 outline-none cursor-not-allowed">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-black uppercase text-slate-400 italic tracking-widest ml-1">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" 
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('telefono') ? 'border-red-300' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-100 outline-none font-bold text-xs transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black uppercase text-slate-400 italic tracking-widest ml-1">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" 
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('nombre') ? 'border-red-300' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-100 outline-none font-bold text-xs transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-black uppercase text-slate-400 italic tracking-widest ml-1">Apellidos</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" 
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('apellidos') ? 'border-red-300' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-100 outline-none font-bold text-xs transition-all">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-black uppercase text-slate-400 italic tracking-widest ml-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $cliente->email) }}" 
                               class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-300' : 'border-slate-200' }} rounded-xl focus:ring-2 focus:ring-blue-100 outline-none font-bold text-xs transition-all">
                    </div>

                    <div class="flex justify-between items-center pt-6 mt-4">
                        <a href="{{ route('admin.clientes') }}" class="text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition italic">
                            ← Volver
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-3 px-8 rounded-xl shadow-lg shadow-blue-100 uppercase text-[10px] tracking-widest transition-all transform active:scale-95 italic">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>





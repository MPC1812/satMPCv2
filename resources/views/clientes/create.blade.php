<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Cliente - SAT MPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/50 border border-slate-100">
        <!-- Encabezado del Mockup -->
        <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-6 flex items-center">
            <span class="mr-2 text-lg">👤</span> Identificación del Cliente (RF1)
        </h3>

        <form action="/satMPC/public/index.php/clientes" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- DNI -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 italic">DNI / NIE</label>
                    <input type="text" name="dni" placeholder="12345678X" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none transition font-bold" required>
                </div>
                <!-- Teléfono -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 italic">Teléfono de Contacto</label>
                    <input type="text" name="telefono" placeholder="600 000 000" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none transition font-bold" required>
                </div>
                <!-- Nombre -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 italic">Nombre</label>
                    <input type="text" name="nombre" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none transition font-bold" required>
                </div>
                <!-- Apellidos -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 italic">Apellidos</label>
                    <input type="text" name="apellidos" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none transition font-bold" required>
                </div>
            </div>

            <!-- Botón de Acción Principal (Pág 9 PDF) -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-3xl shadow-2xl shadow-blue-200 uppercase text-sm tracking-widest transition-all transform hover:-translate-y-1 active:scale-95 italic">
                    Guardar Cliente y Continuar (RF1)
                </button>
            </div>
        </form>
    </div>
</body>
</html>

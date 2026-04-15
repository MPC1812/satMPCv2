@if (session('success') || session('error'))
    <div id="alerta-flotante" 
         class="fixed top-5 right-5 z-50 min-w-[300px] p-4 rounded-lg shadow-xl transform transition-all duration-500 ease-in-out border-l-4 
         {{ session('success') ? 'bg-green-100 border-green-500 text-green-800' : 'bg-red-100 border-red-500 text-red-800' }}">
        
        <div class="flex items-center">
            <span class="mr-3 text-xl">
                {{ session('success') ? '✅' : '⚠️' }}
            </span>
            <p class="font-bold">
                {{ session('success') ?? session('error') }}
            </p>
        </div>
    </div>

    <script>
        // Función para que el mensaje desaparezca solo después de 4 segundos
        setTimeout(() => {
            const alerta = document.getElementById('alerta-flotante');
            if (alerta) {
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-20px)';
                setTimeout(() => alerta.remove(), 500); // Lo elimina del todo tras la animación
            }
        }, 4000);
    </script>
@endif

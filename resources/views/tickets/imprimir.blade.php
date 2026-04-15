<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resguardo SAT - {{ $ticket->codigo }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; margin: 0; padding: 0; }
            @page { margin: 0.5cm; }
        }
        .document-box { border: 1.5px solid #000; padding: 15px; margin-bottom: 10px; font-family: Arial, sans-serif; }
        .section-title { font-size: 10px; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #eee; margin-bottom: 5px; padding-bottom: 2px; }
        .data-text { font-size: 13px; font-weight: bold; }
        .cut-line { border-top: 1px dashed #000; margin: 20px 0; position: relative; text-align: center; }
        .cut-line:after { content: '✂ CORTE POR AQUÍ'; font-size: 9px; position: absolute; top: -7px; background: #fff; padding: 0 10px; left: 42%; }
        
        /* Ajuste RGPD: Fuente mínima de 9pt (~2.5mm) para cumplir normativa legal */
        .rgpd { font-size: 9.5pt; line-height: 1.3; text-align: justify; margin-top: 10px; color: #1a1a1a; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto no-print p-4 flex justify-between items-center">
        <div>
            <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded font-bold text-xs uppercase">Imprimir Ahora</button>
            <a href="{{ route('tickets.index') }}" class="ml-4 text-xs font-bold text-gray-500 uppercase italic">← Volver</a>
        </div>
        <div class="text-[10px] font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded">NOTIFICACIÓN POR EMAIL ENVIADA</div>
    </div>

    <div class="max-w-[21cm] mx-auto bg-white p-4">
        @foreach(['COPIA PARA EL CLIENTE', 'COPIA PARA EL TALLER'] as $index => $tipo)
        <div class="document-box">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-white flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo satMPC" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-2xl font-black uppercase tracking-tighter leading-none">satMPC</h1>
                        <p class="text-[10px] font-bold border-t border-black mt-1">{{ $tipo }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold uppercase italic">Parte de Entrada</p>
                    <p class="text-3xl font-black tracking-tighter">{{ $ticket->codigo }}</p>
                    <!-- Formato de fecha estándar español -->
                    <p class="text-[11px] font-bold">{{ $ticket->created_at->format('d/m/Y - H:i') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="border border-gray-200 p-3 rounded">
                    <p class="section-title">Datos del Cliente</p>
                    <p class="data-text">{{ $ticket->cliente->nombre }} {{ $ticket->cliente->apellidos }}</p>
                    <!-- <p class="text-[12px]">DNI: {{ $ticket->cliente->dni }}</p> -->
                    <p class="text-[12px]">Tel: {{ $ticket->cliente->telefono }}</p>
                </div>
                <div class="border border-gray-200 p-3 rounded">
                    <p class="section-title">Datos del Equipo</p>
                    <p class="data-text uppercase">{{ $ticket->equipo }}</p>
                </div>
            </div>

            <div class="border border-gray-200 p-3 rounded mb-4">
                <p class="section-title">Avería / Observaciones</p>
                <p class="text-[12px] italic min-h-[50px]">{{ $ticket->averia }}</p>
            </div>

            <div class="grid grid-cols-12 gap-6 items-end">
                <div class="col-span-8">
                    @if($index === 0)
                    <div class="rgpd">
                        <strong>PROTECCIÓN DE DATOS:</strong> {{ config('app.name') }} tratará sus datos para gestionar la reparación. Puede ejercer sus derechos de acceso, rectificación y supresión conforme al RGPD. La firma implica la aceptación de las condiciones de servicio y el presupuesto mínimo de revisión.
                    </div>
                    @else
                    <p class="text-[10px] font-bold text-gray-400">NOTAS TÉCNICAS: __________________________________________________________________</p>
                    @endif
                </div>
                <div class="col-span-4 text-center">
                    <div class="border-t border-black pt-1">
                        <p class="text-[10px] font-bold uppercase">Firma</p>
                        <div class="h-16"></div>
                    </div>
                </div>
            </div>
        </div>

        @if($index === 0)
            <div class="cut-line no-print"></div>
            <div class="hidden print:block h-12"></div>
        @endif
        @endforeach
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                setTimeout(() => { window.location.href = "{{ route('tickets.index') }}"; }, 500);
            };
        }
    </script>
</body>
</html>

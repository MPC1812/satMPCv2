<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: 900; color: #1e293b; text-transform: uppercase; font-style: italic; }
        .logo span { color: #3b82f6; }
        .status-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0; }
        .status-text { font-size: 18px; font-weight: bold; color: #2563eb; text-transform: uppercase; }
        .button { 
            display: inline-block; background-color: #2563eb; color: #ffffff !important; 
            padding: 14px 28px; text-decoration: none; border-radius: 50px; 
            font-weight: bold; font-size: 14px; text-transform: uppercase; 
            letter-spacing: 1px; margin-top: 20px; 
        }
        .footer { font-size: 11px; color: #64748b; text-align: center; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SAT <span>MPC</span></div>
            <p style="font-size: 12px; color: #64748b; font-weight: bold; letter-spacing: 2px; margin: 0;">satMPC - SERVICIO TÉCNICO</p>
        </div>

        <h2 style="font-size: 20px;">Hola, {{ $ticket->cliente->nombre }}:</h2>
        <p>Te enviamos este correo para informarte sobre la evolución de tu <strong>parte de reparación</strong>.</p>
        
        <div class="status-box">
            <p style="margin: 0; font-size: 12px; color: #64748b; font-weight: bold; text-transform: uppercase;">Estado actual de tu equipo:</p>
            <div class="status-text">{{ $ticket->estado }}</div>
            <p style="margin: 10px 0 0; font-size: 13px; color: #475569;">Código de Parte: <strong>{{ $ticket->codigo }}</strong></p>
        </div>

        @if($ticket->estado == 'Finalizado')
            <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 15px; margin-bottom: 20px;">
                <p style="color: #166534; font-weight: bold; margin: 0;">¡Buenas noticias! Tu equipo ya está listo. Puedes pasar a recogerlo por nuestra tienda en el horario habitual.</p>
            </div>
        @endif

        <div style="text-align: center;">
            <p>Puedes consultar el detalle completo y el historial pulsando aquí:</p>
            <a href="{{ url('/consulta?codigo=' . $ticket->codigo) }}" class="button">
                Consultar mi Parte
            </a>
        </div>

        <div class="footer">
            <p>Este es un mensaje automático, por favor no respondas a este correo.<br>
            © 2026 satMPC - Almería, España</p>
        </div>
    </div>
</body>
</html>


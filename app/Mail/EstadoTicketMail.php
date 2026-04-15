<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        // Pasamos el ticket con la relación del cliente cargada
        $this->ticket = $ticket->load('cliente');
    }

    public function build()
    {
        return $this->view('emails.ticket_status')
            ->subject('Estado de su reparación - ' . $this->ticket->codigo);
    }
}

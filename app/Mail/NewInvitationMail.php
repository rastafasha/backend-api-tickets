<?php

namespace App\Mail;

use App\Models\Cliente;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->cliente->email, 'Sistema Automatizado de Envio de Notificaciones por correo')
            ->subject('Invitacion a unirse a la plataforma')
            ->markdown('emails.admin.new_invitation_register' , ['cliente' => $this->cliente]);
    }
}

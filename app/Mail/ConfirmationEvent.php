<?php

namespace App\Mail;

use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $evento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->from('mercadocreativo@gmail.com', 'Certificación de asistencia al evento')->subject('Certificación de Asistencia')
    //         ->markdown('emails.admin.new_evento_certificado' , ['evento' => $this->evento]);
    // }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificado de Asistencia',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $evento = $this->evento;
        return $this->view('emails.admin.new_evento_certificado');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class envioDeForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;
   public function __construct($data)
{
    $this->data = $data;
}

    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
{
    $email = $this->subject($this->data['asunto'] ?? 'Nuevo mensaje desde CISNE')
        ->view('emails.contact')
        ->with('data', $this->data);

    // respuesta automática al usuario
    if (!empty($this->data['email'])) {
        $email->replyTo($this->data['email'], $this->data['name'] ?? 'Usuario');
    }

    // adjuntar CV
    if (isset($this->data['cv']) && $this->data['cv'] instanceof \Illuminate\Http\UploadedFile) {
        $email->attach(
            $this->data['cv']->getRealPath(),
            [
                'as' => $this->data['cv']->getClientOriginalName(),
                'mime' => $this->data['cv']->getClientMimeType(),
            ]
        );
    }

    return $email;
}
}

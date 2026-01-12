<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Contiendra les données du formulaire

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Nouveau message de : ' . $this->data['nom'])
                    ->html("
                        <h3>Nouveau message de contact</h3>
                        <p><strong>Nom :</strong> {$this->data['nom']}</p>
                        <p><strong>Email :</strong> {$this->data['email']}</p>
                        <p><strong>Sujet :</strong> {$this->data['sujet']}</p>
                        <p><strong>Organisation :</strong> {$this->data['organisation']}</p>
                        <p><strong>Message :</strong><br>{$this->data['message']}</p>
                    ");
    }
}
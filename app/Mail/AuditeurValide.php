<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuditeurValide extends Mailable
{
    use Queueable, SerializesModels;

    public $auditeur;
    public $messagePersonnalise;

    public function __construct($auditeur, $messagePersonnalise = null)
    {
        $this->auditeur = $auditeur;
        $this->messagePersonnalise = $messagePersonnalise;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Validation de votre compte auditeur',
        );
    }

    public function auditeur_valide(): Content
    {
        return new Content(
            view: 'emails.auditeur_valide',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
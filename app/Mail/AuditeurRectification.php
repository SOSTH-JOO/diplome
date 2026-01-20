<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuditeurRectification extends Mailable
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
            subject: 'Rectification de vos informations requise',
        );
    }

    public function auditeur_rectification(): Content
    {
        return new Content(
            view: 'emails.auditeur_rectification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
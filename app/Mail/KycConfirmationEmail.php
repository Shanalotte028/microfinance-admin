<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KycConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $documentTypes;

    public function __construct(Client $client, $documentTypes)
    {
        $this->client = $client;
        $this->documentTypes = $documentTypes;
    }

    public function build()
    {
        return $this->view('emails.kyc_confirmation')
            ->subject('Confirmation of Document Submission for KYC Verification');
    }
}

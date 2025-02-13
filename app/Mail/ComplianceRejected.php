<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Compliance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplianceRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $compliance;
    public $remarks;

    public function __construct(Client $client, Compliance $compliance, $remarks = null)
    {
        $this->client = $client;
        $this->compliance = $compliance;
        $this->remarks = $remarks;
    }

    public function build()
    {
        return $this->markdown('emails.rejected')
            ->subject('Compliance Document Rejected')
            ->with([
                'clientName' => $this->client->first_name . ' ' . $this->client->last_name,
                'documentType' => $this->compliance->document_type,
                'remarks' => $this->remarks,
            ]);
    }
}
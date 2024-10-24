<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Compliance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplianceApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $compliance;

    public function __construct(Client $client, Compliance $compliance)
    {
        $this->client = $client;
        $this->compliance = $compliance;
    }

    public function build()
    {
        return $this->markdown('emails.compliance.approved')
            ->subject('Your Compliance Document Has Been Approved')
            ->with([
                'first_name' => $this->client->first_name,
                'compliance_type' => $this->compliance->compliance_type,
                'document_type' => $this->compliance->document_type,
                'approval_date' => $this->compliance->approval_date,
            ]);
    }
}

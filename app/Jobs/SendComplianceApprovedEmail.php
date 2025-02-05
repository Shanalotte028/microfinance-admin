<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Compliance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplianceApproved;

class SendComplianceApprovedEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $client;
    protected $compliance;

    public function __construct(Client $client, Compliance $compliance)
    {
        $this->client = $client;
        $this->compliance = $compliance;
    }

    public function handle()
    {
        // Send the email
        Mail::to($this->client->email)->send(new ComplianceApproved($this->client, $this->compliance));
    }
}
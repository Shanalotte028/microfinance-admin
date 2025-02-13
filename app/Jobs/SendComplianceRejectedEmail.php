<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Compliance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplianceRejected;

class SendComplianceRejectedEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $client;
    protected $compliance;
    protected $remarks;

    public function __construct(Client $client, Compliance $compliance, $remarks = null)
    {
        $this->client = $client;
        $this->compliance = $compliance;
        $this->remarks = $remarks;
    }

    public function handle()
    {
        // Send the email
        Mail::to($this->client->email)->send(new ComplianceRejected($this->client, $this->compliance, $this->remarks));
    }
}
<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientVerified;

class SendClientVerifiedEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        // Send the email
        Mail::to($this->client->email)->send(new ClientVerified($this->client));
    }
}
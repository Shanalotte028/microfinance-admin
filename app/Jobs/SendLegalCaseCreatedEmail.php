<?php

namespace App\Jobs;

use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\LegalCaseCreated;

class SendLegalCaseCreatedEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $legalCase;
    protected $recipientEmail;

    public function __construct(LegalCase $legalCase, $recipientEmail)
    {
        $this->legalCase = $legalCase;
        $this->recipientEmail = $recipientEmail;
    }

    public function handle()
    {
        // Send the email
        Mail::to($this->recipientEmail)->send(new LegalCaseCreated($this->legalCase));
    }
}
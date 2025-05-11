<?php

namespace App\Mail;

use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractsSigningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contract;

    /**
     * Create a new message instance.
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Build the message.
     */
    public function build()
{
    $recipient = $this->contract->client ?? $this->contract->user;
    
    return $this->subject("Sign Your Contract #{$this->contract->id}")
        ->markdown('emails.contract-signing')
        ->with([
            'url' => route('contracts.sign', [
                'contract' => $this->contract->id,
                'token' => $this->contract->signing_token
            ]),
            'recipient' => $recipient,
            'expiry' => $this->contract->signing_expires_at 
                ? Carbon::parse($this->contract->signing_expires_at)->format('M j, Y g:i A') 
                : 'No expiry date',
        ]);
}
}

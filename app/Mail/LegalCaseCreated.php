<?php

namespace App\Mail;

use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LegalCaseCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $legalCase;

    public function __construct(LegalCase $legalCase)
    {
        $this->legalCase = $legalCase;
    }

    public function build()
    {
        return $this->markdown('emails.case_created')
            ->subject('New Legal Case Created')
            ->with([
                'caseNumber' => $this->legalCase->case_number,
                'title' => $this->legalCase->title,
                'createdAt' => $this->legalCase->created_at,
            ]);
    }
}
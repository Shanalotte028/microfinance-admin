<?php

namespace App\Jobs;

use App\Mail\ContractsSigningMail;
use App\Models\Contract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContractSigningMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contract;

    /**
     * Create a new job instance.
     */
    public function __construct(Contract $contract)
    {
        //
        $this->contract = $contract;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->contract->client->email)
            ->send(new ContractsSigningMail($this->contract));
    }
}

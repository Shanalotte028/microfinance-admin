<?php

namespace App\Exports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Contract::with(['client', 'user', 'template','createdBy'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

     public function headings(): array
    {
        return [
            'ID',
            'Client Name',
            'User Name',
            'Template Title',
            'Compliance Record ID',
            'Title',
            'Content',
            'Terms',
            'Status',
            'Signing Token',
            'Signing Expires At',
            'Signing Sent At',
            'Party Signed At',
            'Signature Data',
            'Signer IP',
            'Signer User Agent',
            'Created By',
            'Created At',
            'Updated At',
        ];
    }

    public function map($contract): array
    {
        return [
            $contract->id,
            optional($contract->client)->last_name,
            optional($contract->user)->last_name,
            optional($contract->template)->title,
            $contract->compliance_record_id,
            $contract->title,
            $contract->content,
            json_encode($contract->terms),
            $contract->status,
            $contract->signing_token,
            $contract->signing_expires_at,
            $contract->signing_sent_at,
            $contract->party_signed_at,
            $contract->signature_data,
            $contract->signer_ip,
            $contract->signer_user_agent,
            optional($contract->creator)->last_name,
            $contract->created_at,
            $contract->updated_at,
        ];
    }
}

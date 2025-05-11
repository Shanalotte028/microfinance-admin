<?php

namespace App\Exports;

use App\Models\LegalCase;
use Maatwebsite\Excel\Concerns\FromCollection;

class LegalCaseExport implements FromCollection
{

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LegalCase::whereBetween('filing_date', [$this->startDate, $this->endDate])->get();
    }

    public function map($case): array
    {
        return [
            $case->case_number,
            $case->client->full_name ?? 'N/A',
            $case->assignedLawyer->full_name ?? 'Unassigned',
            ucfirst($case->status),
            $case->filing_date,
            $case->closing_date,
            $case->title,
            $case->description,
        ];
    }

    public function headings(): array
    {
        return [
            'Case Number',
            'Client Name',
            'Assigned Lawyer',
            'Status',
            'Filing Date',
            'Closing Date',
            'Title',
            'Description',
        ];
    }
}

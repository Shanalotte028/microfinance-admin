<?php
namespace App\Exports;

use App\Models\Compliance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class ComplianceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Compliance::whereBetween('submission_date', [$this->startDate, $this->endDate])->get();
    }

    public function headings(): array
    {
        return ["ID", "Client ID", "Compliance Type", "Document Type", "Status", "Submission Date", "Approval Date"];
    }

    public function map($compliance): array
    {
        return [
            $compliance->id,
            $compliance->client_id,
            $compliance->compliance_type,
            $compliance->document_type,
            $compliance->document_status,
            $compliance->submission_date,
            $compliance->approval_date,
        ];
    }
}

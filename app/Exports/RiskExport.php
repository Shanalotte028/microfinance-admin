<?php

namespace App\Exports;

use App\Models\Risk;
use Maatwebsite\Excel\Concerns\FromCollection;

class RiskExport implements FromCollection
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
        return Risk::whereBetween('assessment_date', [$this->startDate, $this->endDate])->get();
    }

    public function map($risk): array
    {
        return [
            $risk->id,
            $risk->client_id,
            optional($risk->client)->full_name ?? 'N/A', // Assuming your Client model has full_name
            $risk->risk_level,
            $risk->confidence_level . '%',
            $risk->recommendation,
            $risk->assessment_date->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'Risk Assessment ID',
            'Client ID',
            'Client Name',
            'Risk Level',
            'Confidence Level (%)',
            'Recommendation',
            'Assessment Date',
        ];
    }
}

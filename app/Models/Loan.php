<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'submitted_at', // Loan Appplication Date
        'term_type', // Loan Duration
        'loan_term', // Loan Duration
        'payment_frequency_method', // Loan Duration
        'principal_amount', //Monthly Debt Payments
        'installment', // Monthly Debt Payments
        'loan_description', // Loan Purpose
        'interest_rate', // Interest Rate
        'loan_status'
        ];

    public function financial(){
        return $this->belongsTo(Financial::class);
    }

    public static function getTotalLoanAmount($financialDetailsId)
    {
        return self::where('financial_details_id', $financialDetailsId)
                   ->sum('principal_amount');
    }
}

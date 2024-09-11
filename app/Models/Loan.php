<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_id',
        'loan_amount',
        'loan_status',
        'interest_rate',
        'start_date',
        'end_date',
        ];

    public function financial(){
        return $this->belongsTo(Financial::class);
    }

    public static function getTotalLoanAmount($financialDetailsId)
    {
        return self::where('financial_details_id', $financialDetailsId)
                   ->sum('loan_amount');
    }
}

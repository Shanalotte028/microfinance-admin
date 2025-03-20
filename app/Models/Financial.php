<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;
    protected $table = 'financial_details';
    protected $fillable = [
        'total_loan_amount_borrowed',
        'late_payments',  // Previous Late Payments
        'loan_defaults', // Previous Loan Defaults
        'number_of_payments', // Payments History
        'annual_income', // Annual Income
        'monthly_income', // Monthly Income
        'monthly_expenses', // Monthly Expenses 
        'savings_account_balance',
        'checking_account_balance',
        'total_assets',
        'networth',
        'credit_score', // Credit Score
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function loans()
    {
        return $this->hasMany(Loan::class, 'financial_id');
    }
    public function getTotalLoanAmountAttribute()
    {
        return $this->loans()->sum('loan_amount');
    }
}

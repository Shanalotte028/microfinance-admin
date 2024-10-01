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
        'loan_repayment_status',
        'income',
        'credit_score',
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

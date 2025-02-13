<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'assigned_to', 'case_number', 'title', 
        'description', 'status', 'filing_date', 'closing_date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedLawyer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

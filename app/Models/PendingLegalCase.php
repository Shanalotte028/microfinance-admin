<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingLegalCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assigned_to', // Assigned lawyer (user_id)
        'case_number',
        'title',
        'description',
        'status',
        'filing_date',
        'closing_date',
        'created_at',
        'updated_at'
    ];

    // Each case belongs to a client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Each case is assigned to a lawyer (User)
    public function assignedLawyer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

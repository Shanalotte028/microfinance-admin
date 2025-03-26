<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldInvestigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'officer_id',
        'observations',
        'verified',
    ];

    // Relationship with Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relationship with Field Officer (User)
    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}

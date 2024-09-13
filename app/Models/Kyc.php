<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;

    protected $table = 'kyc_records';

    protected $fillable = [
        'compliance_id',
        'document_type',
        'document_path',
        'verification_status',
        'uploaded_at',
        'verified_at',
        'verified_by',
    ];

    // Relationship to Compliance
    public function compliance()
    {
        return $this->belongsTo(Compliance::class);
    }

    // Relationship to User (Staff who verified the document)
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}

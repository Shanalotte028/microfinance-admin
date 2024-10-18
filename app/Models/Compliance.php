<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;

    protected $table = 'compliance_records';
    
    protected $fillable = [
        'client_id',
        'compliance_type',
        'document_type',
        'document_path',
        'document_status',
        'submission_date',
        'approval_date',
        'remarks',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;
    protected $table = 'risk_assessments';
    protected $fillable = [
        'confidence_level',
        'risk_level',
        'recommendation',
        'assessment_date',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

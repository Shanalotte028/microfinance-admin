<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;

    protected $fillable = ['risk_score','recommendation'];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

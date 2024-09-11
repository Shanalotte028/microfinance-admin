<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;

    protected $fillable = ['document_status','audit_status'];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'loan_history'
    ];

    public function risk(){
        return $this->hasOne(Risk::class);
    }
    public function compliance(){
        return  $this->hasOne(Compliance::class);
    }
}

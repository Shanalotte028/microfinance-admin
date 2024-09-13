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
        'birthday',
        'gender',
        'client_type',
        'client_status',
    ];

    public function addresses(){
        return $this->hasMany(Address::class);
    }
    
    // Compliances
    public function compliance_records(){
        return  $this->hasMany(Compliance::class);
    }
    //financials
    public function financial_details(){
        return $this->hasOne(Financial::class);
    }
    //risks
    public function risk_assessments(){
        return $this->hasMany(Risk::class);
    }
}

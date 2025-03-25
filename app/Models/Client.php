<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Correct usage for authentication
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable implements AuthenticatableContract
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id', //client_id
        'first_name', //fname
        'last_name', //lname
        'email', 
        'phone_number', // mobilenum
        'birthday',
        'place_of_birth',
        'gender',
        'marital_status', // Civil Status
        'source_of_income', // primary_source
        'number_of_dependents', // Number of Dependents
        'job_temporary', // Employment Status
        'education_level', // Education Level
        'ownership_status', //Home Ownership Status
        'work_duration', // Experience
        'job_tenure', // Job tenure
        /* 'nationality', */
        /* 'tin_number', */
        /* 'client_type',
        'client_status', */
        'password', // might remove
    ];

    public function getRouteKeyName()
    {
        return 'client_id'; // Use 'client_id' instead of 'id'
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
    
    public function compliance_records()
    {
        return $this->hasMany(Compliance::class);
    }

    public function financial_details()
    {
        return $this->hasOne(Financial::class);
    }

    public function risk_assessments()
    {
        return $this->hasMany(Risk::class);
    }

    public function legalCases(){
        return $this->hasMany(LegalCase::class);
    }

    public function fieldInvestigations(){   
    return $this->hasMany(FieldInvestigation::class);
    }
    
}

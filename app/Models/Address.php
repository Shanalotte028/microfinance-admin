<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = [
        'client_id',
        'region',
        'province',
        'city',
        'barangay',
        'permanent_street',
        'postal_code',
        'same_address',
        'present_region',
        'present_province',
        'present_city',
        'present_barangay',
        'present_street',
        'present_postal_code',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

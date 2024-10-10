<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = [
        'client_id',
        'address_line_1',
        'address_line_2',
        'city',
        'province',
        'postal_code',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Contract extends Model
{
    protected $fillable = [
        'client_id',
        'template_id',
        'title',
        'content',
        'terms',
        'status',
        'start_date',
        'end_date',
        'auto_renew',
        'description',
        'created_by',
        'signing_token',
        'signing_sent_at',
        'signing_expires_at',
        'signature_data',
        'signer_ip',
        'signer_user_agent',
        'signing_token',
        'client_signed_at',
    ];

    protected $casts = [
        'terms' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_renew' => 'boolean',
        'client_signed_at' => 'datetime',
        'signing_expires_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function template()
    {
        return $this->belongsTo(ContractTemplate::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isExpired(): bool{
        return $this->status === 'expired' || 
            ($this->end_date && $this->end_date->isPast());
    }
}
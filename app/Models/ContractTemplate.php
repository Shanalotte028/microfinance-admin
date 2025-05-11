<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class ContractTemplate extends Model
{
    protected $fillable = ['name', 'slug', 'content', 'fields', 'is_active'];

    protected $casts = [
        'fields' => 'array',
        'is_active' => 'boolean'
    ];

    // Helper to get placeholders from content
    public function placeholders(): array
    {
        preg_match_all('/\{\{\s*(.*?)\s*\}\}/', $this->content, $matches);
        return $matches[1] ?? [];
    }
}
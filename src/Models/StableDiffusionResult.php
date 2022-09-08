<?php

namespace RuliLG\StableDiffusion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StableDiffusionResult extends Model
{
    use HasFactory;

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    protected $casts = [
        'output' => 'array',
    ];

    public function scopeUnfinished($query)
    {
        return $query->whereIn('status', ['starting', 'processing']);
    }
}

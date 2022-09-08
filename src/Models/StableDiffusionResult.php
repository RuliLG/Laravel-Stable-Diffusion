<?php

namespace RuliLG\StableDiffusion\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function isSuccessful(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === 'succeeded',
        );
    }

    public function isStarting(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === 'starting',
        );
    }

    public function isProcessing(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === 'processing',
        );
    }

    public function isFailed(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === 'failed',
        );
    }
}

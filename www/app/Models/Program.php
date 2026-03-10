<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'direction_id',
        'name',
        'form',
        'duration',
        'qualification',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }
}

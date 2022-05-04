<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_to_end',
        'total_bonus'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function result_details(): HasMany
    {
        return $this->hasMany(ResultDetail::class);
    }
}

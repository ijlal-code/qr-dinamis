<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QrLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'target_url',
        'visit_count',
        'user_id',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(QrVisit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_link_id',
        'ip_address',
        'device_type',
        'os',
        'browser',
    ];

    public function qrLink(): BelongsTo
    {
        return $this->belongsTo(QrLink::class);
    }
}
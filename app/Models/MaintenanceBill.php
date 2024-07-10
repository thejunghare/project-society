<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceBill extends Model
{
    use HasFactory;
    protected $table = 'maintenance_bills';

    protected $fillable = [
        'member_id',
        'amount',
        'status',
        'due_date',
        'billing_month',
        'billing_year'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function member() :BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}

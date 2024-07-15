<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceBill extends Model
{
    use HasFactory;
    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'payment_mode_id',
        'member_id',
        'amount',
        'status',
        'due_date',
        'billing_month',
        'billing_year',
        // Add any other fields you want to allow for mass assignment
        // Add other fillable fields as needed
    ];


    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // Newly added
    public function payment()
    {
        return $this->hasOne(Payment::class, 'maintenance_bills_id');
    }


}

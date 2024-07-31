<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    protected $fillable = [
        'cheque_no',
    ];


    // Newly added
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function maintenanceBill()
    {
        return $this->belongsTo(MaintenanceBill::class, 'maintenance_bills_id');
    }
}

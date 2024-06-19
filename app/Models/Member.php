<?php

namespace App\Models;

use App\Models\Bill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'society_id'
    ];

    public function society(): BelongsTo
    {
        return $this->belongsTo(Societies::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }




  /*   public function maintenacneBill(): HasMany
    {
        return $this->hasMany(MaintenanceBill::class);
    } */

    public function maintenanceBill()
    {
        return $this->hasOne(MaintenanceBill::class);
    }
}

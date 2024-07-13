<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Societies extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'address', 'member_count', 'bank_name', 'bank_account_number', 'bank_ifsc_code', 'accountant_id','renews_at', 'upi_id', 'upi_number', 'parking_charges', 'maintenance_amount_owner', 'service_charges', 'maintenance_amount_rented', 'registered_balance', 'updated_balance'];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'society_id');
    }
    
    public function president(): HasOne
    {
        return $this->hasOne(PresidentDetail::class);
    }

    public function vicePresident(): HasOne
    {
        return $this->hasOne(VicePresidentDetail::class);
    }

    public function secretary(): HasOne
    {
        return $this->hasOne(SecretaryDetail::class);
    }

    public function treasurer(): HasOne
    {
        return $this->hasOne(TeasurerDetail::class);
    }

    /*   public function accountant(): HasOne
      {
          return $this->hasOne(Accountant::class);
      } */

    public function accountant()
    {
        return $this->belongsTo(Accountant::class);
    }
}

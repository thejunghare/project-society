<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Societies extends Model
{
    use HasFactory;

    public function member(): HasMany
    {
        return $this->hasMany(Member::class);
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

    public function accountant(): HasOne
    {
        return $this->hasOne(Accountant::class);
    }
}

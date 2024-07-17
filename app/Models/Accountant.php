<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accountant extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];


    public function society() :BelongsTo {
        return $this->belongsTo(Societies::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use App\Casts\Encrypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSettings extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'value' => Encrypt::class
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}

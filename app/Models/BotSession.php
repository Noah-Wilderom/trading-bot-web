<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BotSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:H:i:s d-m-Y',
        'updated_at' => 'datetime:H:i:s d-m-Y',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function logs()
    {
        return $this->hasMany(BotLog::class, 'uuid', 'bot_uuid');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotLog extends Model
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

    public function session()
    {
        return $this->hasOne(BotSession::class, 'uuid', 'bot_uuid');
    }
}

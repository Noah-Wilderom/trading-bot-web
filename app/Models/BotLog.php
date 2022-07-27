<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function session()
    {
        return $this->hasOne(BotSession::class, 'uuid', 'bot_uuid');
    }
}

<?php

namespace App\Exports;

use App\Models\BotLog;
use App\Models\BotSession;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;



class BotLogsExport implements FromQuery, ShouldQueue
{
    use Exportable;

    /**
     * @param \App\Models\BotSessions
     */

    public function __construct(BotSession $bot)
    {
        $this->bot = $bot;
    }

    /**
    * @return \Illuminate\Support\FromQuery
    */
    public function query()
    {
        return BotLog::query()->where('bot_uuid', $this->bot->uuidd);
    }
}

<?php

namespace App\Exports;

use App\Models\BotLog;
use App\Models\BotSession;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BotLogsExport implements WithStyles, ShouldAutoSize, FromCollection, ShouldQueue
{
    use Exportable;

    /**
     * @param \App\Models\BotSessions
     */

    public function __construct(BotSession $bot)
    {
        $this->bot = $bot;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }


    public function collection()
    {
        $collection = new Collection();
        $collection->add(['ID', 'Bot UUID', 'Log', 'Created At', 'Updated At']);
        $collection->add(BotLog::where('bot_uuid', $this->bot->uuid)->get());
        return $collection;
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BotSession;
use App\Models\BotLog as BotLogsModel;

class BotLogs extends Component
{
    public $session;
    public $logs;

    public function mount($uuid)
    {
        $this->session = BotSession::where('uuid', $uuid)->first();

    }
    public function render()
    {
        $this->logs = BotLogsModel::where('bot_uuid', $this->session->uuid)->orderBy('created_at', 'DESC')->get();
        return view('livewire.bot-logs');
    }
}

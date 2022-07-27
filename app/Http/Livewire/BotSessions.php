<?php

namespace App\Http\Livewire;

use Spatie\Ssh\Ssh;
use Livewire\Component;
use App\Models\BotSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BotSessions extends Component
{
    public $botSessions;

    public $createSessionModal = false;

    public $newCoin;
    public $newName;

    public function createSession()
    {
        $this->createSessionModal = true;
    }

    public function closeSessionModal()
    {
        $this->createSessionModal = false;
    }

    public function createNewBotSession()
    {
        if($this->newCoin && $this->newName)
        {
            $bot = BotSession::create([
                'uuid' => Str::uuid(),
                'user_id' => Auth::user() ? Auth::user()->id : 1,
                'coin' => $this->newCoin,
                'data' => json_encode([
                    "name" => $this->newName, 
                    "user" => Auth::user(), 
                    "total_profit" => 0.0,
                    "online" => false
                ])
            ]);
            $this->botSessions = Auth::user()->botSessions;
            dd($bot);
        }
        
    }

    public function downloadLogs()
    {
        $ssh = Ssh::create('root', '5.181.134.239', 22)
            ->usePrivateKey(__DIR__ . '/ssh/id_rsa');

        $dir = Storage::makeDirectory(Auth::user()->email);

        if($dir)
        {
            $logs = $ssh->download('/home/noahdev/tradingbot/logs/*.log', Storage::path(Auth::user()->email));
        }

        foreach(Storage::files($dir) as $file)
        {
            Storage::download(Storage::path($file));
        }
            
    }

    public function updated($name, $value)
    {
        if($this->botSessions)
        {
            $user_sessions = Auth::user()->botSessions;
            if($user_sessions->count() > $this->botSessions->count())
            {
                $this->botSessions = $user_sessions;
            }
        }
    }

    public function render()
    {
        $this->botSessions = Auth::user()->botSessions;
        $ssh = Ssh::create('root', '5.181.134.239', 22)
            ->usePrivateKey(__DIR__ . '/ssh/id_rsa');

        $check = $ssh->execute('whoami')->isSuccessful();
        $coins = $ssh->execute(['cd /home/noahdev/tradingbot', 'python3 main.py --coins'])->getOutput();
        $version = $ssh->execute(['cd /home/noahdev/tradingbot', 'python3 main.py --version'])->getOutput();
                
        return view('livewire.bot-sessions', compact('check', 'version', 'coins'));
    }
}

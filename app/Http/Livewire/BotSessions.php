<?php

namespace App\Http\Livewire;

use Spatie\Ssh\Ssh;
use Livewire\Component;
use App\Models\BotSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Flasher\Prime\FlasherInterface;

class BotSessions extends Component
{
    public $botSessions;

    public $createSessionModal = false;

    public $newCoin;
    public $newName;

    private $ssh;

    public function boot()
    {
        $this->ssh = Ssh::create('root', '5.181.134.239', 22)
            ->usePrivateKey(__DIR__ . '/ssh/id_rsa')
            ->disablePasswordAuthentication();
    }

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
        toastr()->addSuccess("Logs are being downloaded please wait...");

        $dir = Storage::makeDirectory(Auth::user()->email);

        if($dir)
        {
            $logs = $this->ssh->download('/home/noahdev/tradingbot/logs/*.log', Storage::path(Auth::user()->email));
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
        $check = $this->ssh->execute('whoami')->isSuccessful();
        $coins = $this->ssh->execute(['cd /home/noahdev/tradingbot', 'python3 main.py --coins'])->getOutput();
        $version = $this->ssh->execute(['cd /home/noahdev/tradingbot', 'python3 main.py --version'])->getOutput();
                
        return view('livewire.bot-sessions', compact('check', 'version', 'coins'));
    }
}

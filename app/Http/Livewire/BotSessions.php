<?php

namespace App\Http\Livewire;

use Spatie\Ssh\Ssh;
use Livewire\Component;
use App\Models\BotSession;
use Illuminate\Support\Str;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DivineOmega\SSHConnection\SSHConnection;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BotSessions extends Component
{
    public $botSessions;

    public $createSessionModal = false;

    public $newCoin;
    public $newName;
    public $newSell;
    public $newBuy;

    private $ssh;

    public $isLoading = false;

    public function boot()
    {
        $dir = dirname(dirname(dirname(__DIR__)));
        // $dir = str_replace('\\', '/', $dir);
        // dd(dirname(dirname(dirname(__DIR__))), $dir);
        // $this->ssh = Ssh::create('root', '5.181.134.239', 22)
        //     ->usePrivateKey($dir . '/ssh/id_rsa')
        //     ->disablePasswordAuthentication()
        //     ->addExtraOption('-x -tt');
        $this->ssh = (new SSHConnection())
            ->to('5.181.134.239')
            ->onPort(22)
            ->as('root')
            ->withPrivateKey($dir . '/ssh/id_rsa')
            ->connect();
    }

    public function openCreateModal()
    {
        $this->createSessionModal = true;
    }

    public function closeCreateModal()
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
                    "interval" => 30,
                    "online" => false
                ])
            ]);
            $this->botSessions = Auth::user()->botSessions;
            $session = $this->ssh->run(
                "cd /home/noahdev/tradingbot && tmux new-session -d -s " . $bot->uuid . "'python3 main.py --market=" . $bot->coin . " --sell=" . strval($this->newSell) . " --buy=" . strval($this->newBuy) . " --uuid=" . $bot->uuid . "'"
            )->getOutput();
            if(!!$session)
            {
                toastr()->addSuccess("Bot is initializing and will be ready soon");
            } else {
                toastr()->adderror("Bot has failed");
                dd($session);
            }

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
        // dd($e = $this->ssh->run('whoami'), $e->getError());
        $this->botSessions = Auth::user()->botSessions;
        $check = !!$this->ssh->run('whoami')->getOutput();
        // dd($check, $this->ssh);
        $coins = $this->ssh->run('cd /home/noahdev/tradingbot && python3 main.py --coins')->getOutput();
        $version = $this->ssh->run('cd /home/noahdev/tradingbot && python3 main.py --version');
        $version = $version->getOutput();


        return view('livewire.bot-sessions', compact('check', 'version', 'coins'));
    }
}

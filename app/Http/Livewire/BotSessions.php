<?php

namespace App\Http\Livewire;

use Spatie\Ssh\Ssh;
use Livewire\Component;
use App\Models\BotSession;
use Illuminate\Support\Str;
use App\Models\UserSettings;
use App\Exports\BotLogsExport;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Barryvdh\Debugbar\Facades\Debugbar;
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
    public $newMax;

    private $ssh;
    private $public_key;
    private $secret_key;

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
        if($this->newCoin && $this->newName && $this->newSell && $this->newBuy && $this->newMax)
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

            $api_key = UserSettings::where('user_id', Auth::user()->id)->where('key', 'bitvavo_api_public_key')->first();
            $api_secret_key = UserSettings::where('user_id', Auth::user()->id)->where('key', 'bitvavo_api_secret_key')->first();

            $setting = UserSettings::where('user_id', Auth::user()->id)->where('key', 'demo_account')->first();
            if($setting)
            {
                if($setting->value)
                {
                    $cmd = "cd /home/noahdev/tradingbot && tmux new-session -d -s " . $bot->uuid . " 'python3 main.py --web --market=" . $bot->coin . " --sell=" . strval($this->newSell) . " --buy=" . strval($this->newBuy) . " --uuid=" . $bot->uuid . " --api_key=" . $api_key->value . " --api_secret_key=" . $api_secret_key->value . " --max_money=" . $this->newMax . " --demo_mode" . "'";
                } else {
                    $cmd = "cd /home/noahdev/tradingbot && tmux new-session -d -s " . $bot->uuid . " 'python3 main.py --web --market=" . $bot->coin . " --sell=" . strval($this->newSell) . " --buy=" . strval($this->newBuy) . " --uuid=" . $bot->uuid . " --api_key=" . $api_key->value . " --api_secret_key=" . $api_secret_key->value . " --max_money=" . $this->newMax . "'";
                }
            }

            $session = $this->ssh->run(
                $cmd
            )->getOutput();
            toastr()->addSuccess("Bot is intializing, bot will start soon.");
            dd($session, $cmd);
            $this->closeCreateModal();

        }

    }

    public function queueLogExport($bot_id)
    {
        $bot = BotSession::where('uuid', $bot_id)->first();
        // return $bot ?: toastr()->addError('Export has failed, please reload the page and try again.');

        (new BotLogsExport($bot))->store(Auth::user()->email . '/' . $bot->uuid . '.xlsx');
        // ->chain([
        //     Storage::download(Auth::user()->email . '/' . $bot->uuid . '.xlsx'),
        //     toastr()->addSuccess('Export has been started, download will be ready soon.')
        // ]);

        toastr()->addSuccess('Export has been started, download will be ready soon.');
        while(!Storage::disk('local')->exists(Auth::user()->email . '/' . $bot->uuid . '.xlsx')) {
            sleep(1);
        }

        return Storage::download(Auth::user()->email . '/' . $bot->uuid . '.xlsx');
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
        foreach(Auth::user()->settings as $setting)
        {
            if($setting->key == 'bitvavo_api_public_key')
            {

                $this->public_key = $setting->key;
            }
            if($setting->key == 'bitvavo_api_secret_key')
            {
                $this->secret_key = $setting->key;
            }
        }
        $check_bitvavo = ($this->public_key && $this->secret_key);
        $coins = $this->public_key && $this->secret_key ? $this->ssh->run('cd /home/noahdev/tradingbot && python3 main.py --coins')->getOutput() : [];
        $version = $this->ssh->run('cd /home/noahdev/tradingbot && python3 main.py --version');
        $version = $version->getOutput();

        foreach($this->botSessions as $session)
        {
            $tmux = $this->ssh->run('tmux ls')->getOutput();
            if (str_contains($tmux, $session->uuid))
            {
                Debugbar::info($session, $tmux);
            } else {
                // dd('Bot is dead?', $session, $tmux);
                Debugbar::info($session, $tmux);
                $session->data = json_decode($session->data);
                $session->data->online = false;
                $session->data = json_encode($session->data);
                $session->save();
            }
        }


        return view('livewire.bot-sessions', compact('check', 'version', 'coins', 'check_bitvavo'));
    }
}

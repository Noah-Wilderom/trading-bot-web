<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSettings as SettingsModel;

class UserSettings extends Component
{
    public $bitvavo_api_secret_key;
    public $bitvavo_api_public_key;

    public function render()
    {
        return view('livewire.user-settings');
    }

    public function saveSetting($key)
    {
        if($key == 'bitvavo_api_secret_key')
        {
            $setting = SettingsModel::where('user_id', Auth::user()->id)->where('key', 'bitvavo_api_secret_key')->first();
            if($setting)
            {
                $setting->value = $this->bitvavo_api_secret_key;
                $setting->save();
                toastr()->addSuccess('Setting saved successfully');
            } else {
                $setting = SettingsModel::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'bitvavo_api_secret_key',
                    'value' => $this->bitvavo_api_secret_key
                ]);
                toastr()->addSuccess('Setting saved successfully');
            }
        }

        if($key == 'bitvavo_api_public_key')
        {
            $setting = SettingsModel::where('user_id', Auth::user()->id)->where('key', 'bitvavo_api_public_key')->first();
            if($setting)
            {
                $setting->value = $this->bitvavo_api_public_key;
                $setting->save();
                toastr()->addSuccess('Setting saved successfully');
            } else {
                $setting = SettingsModel::create([
                    'user_id' => Auth::user()->id,
                    'key' => 'bitvavo_api_public_key',
                    'value' => $this->bitvavo_api_public_key
                ]);
                toastr()->addSuccess('Setting saved successfully');
            }
        }
    }
}

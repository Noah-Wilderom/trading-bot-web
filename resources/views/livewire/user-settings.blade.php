<div>
    <div class="w-full">
        <h2>Settings</h2>
        <div class="pt-8">
            <div class="pb-6">
                <label for="bitvavo_api_public_key" class="block">
                    <span class="block text-sm font-medium text-slate-700">Bitvavo API Public Key</span>
                    <input wire:model="bitvavo_api_public_key" type="text" id="bitvavo_api_public_key" />
                    <button wire:click="saveSetting('bitvavo_api_public_key')" class="">
                        Save
                    </button>
                </label>

            </div>
            <div class="pb-6">
                <label for="bitvavo_api_secret_key" class="block">
                    <span class="block text-sm font-medium text-slate-700">Bitvavo API Secret Key</span>
                    <input wire:model="bitvavo_api_secret_key" type="password" id="bitvavo_api_secret_key" />
                    <button wire:click="saveSetting('bitvavo_api_secret_key')" class="">
                        Save
                    </button>
                </label>
            </div>
            <div class="pb-6">
                <label for="demo_account" class="block">
                    <span class="block text-sm font-medium text-slate-700">Demo Account @if($demo_account)<span class="text-sm font-medium text-green-500">On</span>@endif</span>
                    <input wire:model="demo_account_input" type="checkbox" id="demo_account" />
                    <button wire:click="saveSetting('demo_account')" class="">
                        Save
                    </button>
                </label>
            </div>
        </div>
    </div>
</div>

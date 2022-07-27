<div class="w-full">
    <h2>Bot Sessions</h2>
    <div class="p-6">
        <div class="pb-3">
            SSH Status <span class="text-white" style="padding: 5px; font-weight: 700; {{ $check ? 'background-color: #00bf30' : 'background-color: #bf1900' }}">
                {{ $check ? 'Success' : 'Failed' }}
            </span>
        </div>

        <div class="pb-3">
            Version <span class="text-white" style="padding: 5px; font-weight: 700; {{ $version ? 'background-color: #003596' : 'background-color: #bf1900' }}">
                {{ $version ? $version : 'No SSH Connection' }}
            </span>
        </div>
    </div>

    <div class="mx-auto container bg-white  shadow rounded">
        <div class="flex flex-col lg:flex-row p-4 lg:p-8 justify-between items-start lg:items-stretch w-full">
            <div class="w-full lg:w-1/3 flex flex-col lg:flex-row items-start lg:items-center">
                <div class="flex items-center">
                    <button class="text-gray-600 p-2 border-transparent border bg-gray-100 hover:bg-gray-200 cursor-pointer rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="Edit Table" role="button">
                        <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg1dark.svg" alt="Edit">
                    </button>
                    <button class="text-gray-600 mx-2 p-2 border-transparent border bg-gray-100 hover:bg-gray-200 cursor-pointer rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="table settings" role="button">
                        <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg2dark.svg" alt="settings">
                    </button>
                    <button class="text-gray-600 mr-2 p-2 border-transparent border bg-gray-100 hover:bg-gray-200 cursor-pointer rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="Bookmark" role="button">
                        <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg3dark.svg" alt="Bookmark">
                    </button>
                    <button class="text-gray-600 mr-2 p-2 border-transparent border bg-gray-100 hover:bg-gray-200 cursor-pointer rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="copy table" role="button">
                        <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg4dark.svg" alt="">
                    </button>
                    <button class="text-red-500 p-2 border-transparent border bg-gray-100 hover:bg-gray-200 cursor-pointer rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="delete table" role="button">
                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg5.svg" alt="delete">
                    </button>
                </div>
            </div>
            <div class="w-full lg:w-2/3 flex flex-col lg:flex-row items-start lg:items-center justify-end">
                <div class="flex items-center lg:border-l lg:border-r border-gray-300 py-3 lg:py-0 lg:px-6">
                    <p class="text-base text-gray-600" id="page-view">Viewing 1 - 20 of 60</p>
                    <button class="text-gray-600 ml-2 border-transparent border cursor-pointer rounded focus:outline-none focus:ring-2 focus:ring-gray-500 " onclick="pageView(false)" aria-label="Goto previous page " role="button">
                        <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg6.svg" alt="">
                        <img class="dark:block hidden" src="../svgs/svg6dark.svg" alt="">
                    </button>
                    <button class="text-gray-600 border-transparent border rounded focus:outline-none focus:ring-2 focus:ring-gray-500 cursor-pointer" aria-label="goto next page" role="button" onclick="pageView(true)">
                        <img class="transform rotate-180 dark:block hidden" src="../svgs/svg6dark.svg" alt="">
                    </button>
                </div>
                <div class="lg:ml-6 flex items-center">
                    <button wire:click="downloadLogs" class="bg-gray-200 transition duration-150 ease-in-out focus:outline-none border border-transparent focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 hover:bg-gray-300 rounded text-indigo-700 px-5 h-8 flex items-center text-sm">
                        Download All Logs
                    </button>
                    <button data-modal-toggle="modal-create" aria-label="add table" class="text-white ml-4 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 border border-transparent bg-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 w-8 h-8 rounded flex items-center justify-center">
                       <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg7.svg" alt="plus">
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full overflow-x-scroll xl:overflow-x-hidden">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full h-16 border-gray-300 border-b py-8">
                        <th class="pl-8 text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">
                            <input placeholder="check box" type="checkbox" class="cursor-pointer relative w-5 h-5 border rounded border-gray-400 bg-white focus:outline-none focus:outline-none focus:ring-2  focus:ring-gray-400" onclick="checkAll(this)" />
                        </th>

                        <th role="columnheader" class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">UUID</th>
                        <th role="columnheader" class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Name</th>
                        <th role="columnheader" class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Total Profit</th>
                        <th role="columnheader" class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Coin</th>
                        <th role="columnheader" class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">Date</th>
                        <th class="text-gray-600 font-normal pr-6 text-left text-sm tracking-normal leading-4">
                            <div class="opacity-0 w-2 h-2 rounded-full bg-green-400"></div>
                        </th>
                        <td role="columnheader" class="text-gray-600 font-normal pr-8 text-left text-sm tracking-normal leading-4">More</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($botSessions as $botSession)

                    <tr class="h-24 border-gray-300 border-b">
                        <td class="pl-8 pr-6 text-left whitespace-no-wrap text-sm text-gray-800 dtracking-normal leading-4">
                            <input placeholder="check box" type="checkbox" class="cursor-pointer relative w-5 h-5 border rounded border-gray-400 bg-white focus:outline-none focus:outline-none focus:ring-2  focus:ring-gray-400" onclick="tableInteract(this)" />
                        </td>
                        <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">{{ $botSession->uuid }}</td>
                        <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">{{ json_decode($botSession->data)->name }}</td>
                        <td class="pr-6 whitespace-no-wrap">
                            <div class="flex items-center">
                                <p class="ml-2 text-gray-800 tracking-normal leading-4 text-sm">{{ json_decode($botSession->data)->total_profit ?? 'Fail' }}</p>
                            </div>
                        </td>
                        <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">{{ $botSession->coin }}</td>
                        <td class="text-sm pr-6 whitespace-no-wrap text-gray-800 tracking-normal leading-4">{{ $botSession->created_at->format('d-m-Y') }}</td>
                        <td class="pr-6">
                            <div class="w-2 h-2 rounded-full {{ json_decode($botSession->data)->online ?: 'bg-red-400' }}" style="{{ json_decode($botSession->data)->online ? 'background-color: #00bf30' : ''  }}"></div>
                        </td>
                        <td class="pr-8 relative">
                            <button class="text-red-500 p-2 border-transparent border bg-gray-100 hover:bg-gray-200 cursor-pointer rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="delete table" data-modal-toggle="modal-delete-{{ $botSession->uuid }}">
                                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/compact_table_with_actions_and_select-svg5.svg" alt="delete">
                            </button>
                        </td>
                    </tr>

                    <div id="modal-delete-{{ $botSession->uuid }}" aria-hidden="true" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                            <div class="relative bg-white rounded-lg shadow ">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="modal-delete-{{ $botSession->uuid }}">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    <span class="sr-only">Cancel</span>
                                </button>
                                <div class="p-6 text-center">
                                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete bot session?</h3>
                                    <button data-modal-toggle="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Confirm
                                    </button>
                                    <button data-modal-toggle="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">No, cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div id="modal-create" aria-hidden="true" tabindex="-1" class="w-full hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="w-full mx-auto content-center justify-center">
            <div tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="modal-create">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close</span>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900">Create new bot session</h3>
                                <div class="pb-3">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                                    <input wire:model="newName" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Name of process" required>
                                </div>
                                <div class="pb-3">
                                    <label for="buy" class="block mb-2 text-sm font-medium text-gray-900">Buy price</label>
                                    <input wire:model="newBuy" type="number" step=any name="buy" id="buy" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Buy value" required>
                                </div>
                                <div class="pb-3">
                                    <label for="sell" class="block mb-2 text-sm font-medium text-gray-900">Sell price</label>
                                    <input wire:model="newSell" type="number" step=any name="sell" id="sell" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Sell value" required>
                                </div>
                                <div>
                                    <select class="block mb-2 text-sm font-medium text-gray-900" wire:model="newCoin" required>
                                        <option value="">Select a coin...</option>
                                        @foreach(json_decode($coins) as $coin)
                                            @if($coin->status == 'trading')
                                                <option value="{{ $coin->market }}">{{ $coin->market }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex justify-between">
                                    {{-- Voor als er een extra optie bij moet komen --}}
                                </div>
                                <button wire:click="createNewBotSession" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Create Bot Session
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

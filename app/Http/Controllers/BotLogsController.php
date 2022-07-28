<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotLogsController extends Controller
{

    public function index(Request $request, $uuid)
    {
        return view('bot.logs', compact('uuid'));
    }
}

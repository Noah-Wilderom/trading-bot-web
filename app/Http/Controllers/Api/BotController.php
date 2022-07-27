<?php

namespace App\Http\Controllers\Api;

use App\Models\BotLog;
use App\Models\BotSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uuid)
    {
        $bot = BotSession::where('uuid', $uuid)->first();
        return response()->json(json_decode($bot->data), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $bot = BotSession::where('uuid', $uuid)->first();
        $bot->update(['data' => json_decode($request->get('log'))]);
        return response()->json(['message' => 'Success'], 200);
    }

    public function log(Request $request, $uuid)
    {
        $log = BotLog::create([
            'bot_uuid' => $uuid,
            'log' => $request->get('log')
        ]);
        return response()->json(['message' => 'Success'], 200);
    }
}

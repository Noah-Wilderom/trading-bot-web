<?php

namespace App\Http\Controllers;

use Spatie\Ssh\Ssh;
use App\Models\BotSession;
use Illuminate\Http\Request;

class BotSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ssh = Ssh::create('root', '5.181.134.239', 22)
                ->usePrivateKey(__DIR__ . '/ssh/id_rsa')
                ->execute('whoami');
        return dd($ssh, $ssh->isSuccessful(), $ssh->getOutput());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BotSession  $botSession
     * @return \Illuminate\Http\Response
     */
    public function show(BotSession $botSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BotSession  $botSession
     * @return \Illuminate\Http\Response
     */
    public function edit(BotSession $botSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BotSession  $botSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BotSession $botSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BotSession  $botSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(BotSession $botSession)
    {
        //
    }
}

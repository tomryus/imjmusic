<?php

namespace App\Http\Controllers;

use App\model\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('songs')) 
            {

                $song = $request->file('songs');
                $filename = str_replace(' ', '_', $song->getClientOriginalName());
                //$kos = explode('.', $song->getClientOriginalName());
                
                $song->move(public_path('music/'), $filename);
                
                $getID3 = new \getID3();
                $duration = $getID3->analyze(public_path('music/') . $filename)['playtime_string'];
                
                Song::create([
                    'name'      => $filename,
                    'filename'  => $filename,
                    'length'    => $duration
                ]);
       
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        $song->update([
            'name' => request('song_name')
        ]);

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        $song->delete();
        unlink(public_path('music/') . $song->filename);
        return redirect()->route('home');
    }
}

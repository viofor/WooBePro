<?php

namespace App\Http\Controllers;

use App\advanced;
use App\detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvancedController extends Controller
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
        
        $this->validate($request, [
            'user_id' => ['required', 'numeric'],
            'facebook' => 'url',
            'twitter' => 'url',
            'linkedin' => 'url',
            if ($user == '2') {                                     //if the user is a professional
                'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime',
            }
        ]);

        return advanced::create([
            'user_id' => Auth::user()->id,
            'facebook' => $request['facebook'],
            'twitter' => $request['twitter'],
            'linkedin' => $request['linkedin'],
            if ($user == '2') {                                     //if the user is a professional
                if ($request['video'] != null) {
                    'video' => $request['video'],
                }
            }
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\advanced  $advanced
     * @return \Illuminate\Http\Response
     */
    public function show(advanced $advanced)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\advanced  $advanced
     * @return \Illuminate\Http\Response
     */
    public function edit(advanced $advanced)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\advanced  $advanced
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, advanced $advanced)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\advanced  $advanced
     * @return \Illuminate\Http\Response
     */
    public function destroy(advanced $advanced)
    {
        //
    }
}

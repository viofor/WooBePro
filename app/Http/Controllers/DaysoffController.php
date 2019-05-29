<?php

namespace App\Http\Controllers;

use App\daysoff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaysoffController extends Controller
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
        $month = $request['month0'];                                         //loads the month input
        $day = $request['day0'];                                             //loads the day input
        $this->validate($request, [
            'user_id' => ['required', 'numeric'],
            'month' => ['required', 'numeric', 'between:1,12'],
            if ($month == '2) {                                            //if month is february
                'day' => ['required', 'numeric', 'between:1,29'],
            }elseif ($month == '1'||'3'||'5'||'7'||'8'||'10'||'12') {       //if month has 31 day
                'day' => ['required', 'numeric', 'between:1,31'],
            }else {                                                         //when month has 30 days
                'day' => ['required', 'numeric', 'between:1,30'],
            }
        ]);
        if ($month == 2) {
            if ($day > 29) {
                return redirect()->back()->with('error', 'February has a maximum of 29 days');
        }elseif ($month == '1'||'3'||'5'||'7'||'8'||'10'||'12') {
            return daysoff::create([
            'user_id' => Auth::user()->id,
            'day' => $request['day0'],
            'month' => $request['month0'],
        }else{
            if ($day > '30') {
                return redirect()->back()->with('error', 'This month has a maximum of 30 days');
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\daysoff  $daysoff
     * @return \Illuminate\Http\Response
     */
    public function show(daysoff $daysoff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\daysoff  $daysoff
     * @return \Illuminate\Http\Response
     */
    public function edit(daysoff $daysoff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\daysoff  $daysoff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, daysoff $daysoff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\daysoff  $daysoff
     * @return \Illuminate\Http\Response
     */
    public function destroy(daysoff $daysoff)
    {
        $dayoff = $daysoff['dayid'];            //the id of the day off
        daysoff::destroy($dayoff);              //destroys the register from database table
    }
}

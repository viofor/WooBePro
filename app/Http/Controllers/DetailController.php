<?php

namespace App\Http\Controllers;

use App\detail;
use App\countries;
use App\User;
use App\advanced;
use Illuminate\Http\Request;
use App\Http\Requests\DetailRequest;
use App\Http\Requests\DetailUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
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
    /*//////////////////////////////////////////////////////////////////////////////
    This method is called when a new user verifies the email address.
    This method is also called when a new user already verified the emial address
    but didn't fill yet some mandatory profile details as location, type of account (client or pro),
    resume, skills, etc.
    *///////////////////////////////////////////////////////////////////////////////
    public function create(DetailRequest $request)
    {
        $country_id = $request['country'];
        $countries = countries::find($country_id);
        $country = $countries['country'];
        if ($request['usertype'] == '2') {                  //if the user is a professional
            detail::create([
                'user_id' => Auth::user()->id,
                'usertype' => $request['usertype'],
                'country' => $country,
                'state' => $request['state'],
                'city' => $request['city'],
                'resume' => $request['resume'],
                'skill' => $request['skill'],
                'schedule' => $request['schedule'],
            ]);
        }else{
            detail::create([
                'user_id' => Auth::user()->id,
                'usertype' => $request['usertype'],
                'country' => $country,
                'state' => $request['state'],
                'city' => $request['city'],
                'resume' => null,
                'skill' => null,
                'schedule' => null,
            ]);
        }
        return redirect('/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {                                         
        $id = Auth::user()->id;                                       //id of user
        $user = User::where('id', $id)->get('advanced')[0]->advanced;      //finds out the type of user on database
        $detail = detail::where('user_id', $id)->get();
        $usertype = $detail[0]->usertype;
        if ($user == '0') {
            return redirect()->back();
        }else {
            $advanced_id = advanced::where('user_id', $id)->get();  //finds the user data in advanced table
            $advancedinfo = $advanced_id->toArray();
            if (empty($advancedinfo)) {     //Verifies if user already has records on advanceds table
                if ($usertype == '1') {     //If user is client
                    advanced::create([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                        'video' => null,
                    ]);
                }else {                     //If user is pro
                    advanced::create([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                        'video' => $request['video'],
                    ]);
                }
            }else{                          //When user already has records on advanceds table
                if ($usertype == '1') {     //If user is client
                    DB::table('advanceds')->where('user_id', $id)->update([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                        'video' => null,
                    ]);
                }else {                     //If user is pro
                    DB::table('advanceds')->where('user_id', $id)->update([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                        'video' => $request['video'],
                    ]);
                }
                
            }
            return redirect('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show()  //When user press "Home" button, this method checks if user already filled mandatory profile details
    {
        $user_id = Auth::user()->id;
        $verification = Auth::user()->email_verified_at;
        $user_detail = detail::where('user_id', $user_id)->get();   //Retrieve the user details
        $userdetailarray = $user_detail->toArray();
        if (empty($userdetailarray)) { //If user didn't fill details yet
            if ($verification == "") {
                return redirect('/email/verify');
            }else{
                return redirect('/welcome');
            }
        }else {
            return redirect('/home');                               //If user already filled details
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = Auth::user()->id;                          //Getting the user id
        $detail = detail::where('user_id', $id)->get();  //Getting the user data from details table
        $detail_country = $detail[0]->country;           //Getting the id of the country
        $country = countries::where('country', $detail_country)->get()[0]->id;  //Getting the name of the country
        $user_info = User::find($id);                   //Getting user data created during register
        return view('editProfile')->with(['detail' => $detail, 'country' => $country, 'user' => $user_info]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(DetailUpdateRequest $request, UserUpdateRequest $userdetail)
    {
        $id = Auth::user()->id;
        $detail = detail::where('user_id', $id)->get();
        $usertype = $detail[0]->usertype;               //Getting the type of user (client or pro)
        $detail_country = $request['country'];
        $country = countries::where('id', $detail_country)->get()[0]->country;
        if ($usertype == '1') {
            DB::table('details')->where('user_id', $id)->update(
                ['country' => $country,
                 'state' => $request['state'],
                 'city' => $request['city'],
                 'street' => $request['street'],]
            );
            DB::table('users')->where('id', $id)->update(
                ['name' => $userdetail['name'],
                 'lastname' => $userdetail['lastname'],
                 'phone' => $userdetail['phone'],]
            );
        }else {
            DB::table('details')->where('user_id', $id)->update(
                ['country' => $country,
                'state' => $request['state'],
                'city' => $request['city'],
                'street' => $request['street'],
                'schedule' => $request['schedule'],
                'resume' => $request['resume'],
                'skill' => $request['skill'],]
            );
            DB::table('users')->where('id', $id)->update(
                ['name' => $userdetail['name'],
                'lastname' => $userdetail['lastname'],
                'phone' => $userdetail['phone'],]
            );
        }
        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(detail $detail)
    {
        //
    }
}

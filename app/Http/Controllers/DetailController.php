<?php

namespace App\Http\Controllers;

use App\detail;
use App\review;
use App\countries;
use App\User;
use App\advanced;
use App\daysoff;
use Illuminate\Http\Request;
use App\Http\Requests\DetailRequest;
use App\Http\Requests\DetailUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\VideoRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(url('profile/accst'));
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
        $id = Auth::user()->id;
        $string = User::find($id);
        $datehour = $string['created_at'];
        $link = $datehour->format('siH') . "-" . $id . "-" . strrev($datehour->format('Ymd'));
        $country_id = $request['country'];
        $countries = countries::find($country_id);
        $country = $countries['country'];
        if ($request['usertype'] == '2') {                  //if the user is a professional
            detail::create([
                'user_id' => $id,
                'usertype' => $request['usertype'],
                'profile_address' => $link,
                'country' => $country,
                'state' => $request['state'],
                'city' => $request['city'],
                'resume' => $request['resume'],
                'skill' => $request['skill'],
                'schedule' => $request['schedule'],
            ]);
        }else{
            detail::create([
                'user_id' => $id,
                'usertype' => $request['usertype'],
                'profile_address' => $link,
                'country' => $country,
                'state' => $request['state'],
                'city' => $request['city'],
                'resume' => null,
                'skill' => null,
                'schedule' => null,
            ]);
        }
        review::create([
            'user_id' => $id, 
            'reviewer_id' => '0', 
            'stars' => '0', 
            'review' => 'review', 
            'review_response' => 'reviewresponse',
        ]);
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
                    ]);
                }else {                     //If user is pro
                    advanced::create([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                    ]);
                }
            }else{                          //When user already has records on advanceds table
                if ($usertype == '1') {     //If user is client
                    DB::table('advanceds')->where('user_id', $id)->update([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                    ]);
                }else {                     //If user is pro
                    DB::table('advanceds')->where('user_id', $id)->update([
                        'user_id' => $id,
                        'facebook' => $request['facebook'],
                        'twitter' => $request['twitter'],
                        'linkedin' => $request['linkedin'],
                    ]);
                }
                
            }
            return redirect()->back()->with('success', 'Your profile data has been saved!');
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
        $advuserprof = advanced::find($id);
        if (!empty($advuserprof)) {
            return view('editProfile')->with(['detail' => $detail, 'country' => $country, 'user' => $user_info, 'canvideo' => '1']);
        }else {
            return view('editProfile')->with(['detail' => $detail, 'country' => $country, 'user' => $user_info, 'canvideo' => '0']);
        }
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
        return redirect()->back()->with('success', 'Your profile data has been saved!');
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

    /**
     * Returns the view fir changing the account settings (password).
     *
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function accSettings(Request $request)
    {
        $id = Auth::user()->id;
        $calendar = daysoff::where('user_id', $id)->get()->all();
        return view('accSettings',compact('calendar'));
    }

    /**
     * Change the account settings (password).
     *
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function accSettingsUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $userpassword = $request['currentpassword'];
        $newpassword = $request['newpassword'];
        $confirmnewpass = $request['confirmnewpass'];
        $newpasshashed = Hash::make($newpassword);
        $newpasslen = strlen($newpassword);
        $currentpassword = Auth::user()->password;
        if (Hash::check($userpassword, $currentpassword)){
            if ($newpassword == $confirmnewpass) {
                if (Hash::check($newpassword, $currentpassword)) {
                    return redirect()->back()->with('error', 'Your new password cannot be the same as the current one');
                }elseif ($newpasslen >= 8){
                    DB::table('users')->where('id', $id)->update(['password' => $newpasshashed,]);
                    return redirect()->back()->with('success', 'Your password has been successfully changed!');
                }else{
                    return redirect()->back()->with('error', 'Your new password must have at least 8 characters');
                }
            }else{
                return redirect()->back()->with('error', 'Your new password must coincide with confirmation field');
            }
        }else{
            return redirect()->back()->with('error', 'Incorrect password');
        }
    }
    /**
     * Set a new user day off.
     *
     * @param  \App\detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function daysoff(Request $request)
    {
        $id = Auth::user()->id;
        $day = $request['day0'];
        $month = $request['month0'];
        if ($month == 'February') {
            if ($day >= 29) {
                return redirect()->back()->with('error', 'February has a maximum of 29 days');
            }
        }elseif ($month == 'April'||'Juny'||'September'||'November') {
            if ($day > 30) {
                return redirect()->back()->with('error', 'This month has a maximum of 30 days');
            }else{

                $checkuser = daysoff::where('user_id', $id)->get()->all();
                $count = count($checkuser);
                for ($i=0; $i < $count; $i++) { 
                    $monthcycle = $checkuser[$i]->month;
                    if ($monthcycle == $month) {
                        $daycycle = $checkuser[$i]->day;
                        if ($daycycle == $day) {
                            return redirect()->back()->with('error', 'The submitted date already exists');
                        }
                        else{
                            daysoff::create([
                            'user_id' => $id,
                            'day' => $day,
                            'month' => $month,]);
                            return redirect()->back()->with('success', 'Your day off has been successfully registered!');
                        }
                    }
                }
                daysoff::create([
                'user_id' => $id,
                'day' => $day,
                'month' => $month,]);
                return redirect()->back()->with('success', 'Your day off has been successfully registered!');
            }
        }
    }

    public function uploadVideo(Request $request){
        $id = Auth::user()->id;
        $file = $request['video'];
        $folder = "userid" . $id . "-" . "video";
        $mime = $request['video']->getClientMimeType();
        if ($mime == 'video/webm' || 'video/mp4') {
            $url = $request['currentvid'];
            $videoName = time()."user" . $id .'.'.request()->video->getClientOriginalExtension();
            $video_record = $folder . "/" . $videoName;
            Storage::putFileAs('public/'.$folder, $file, $videoName);
            DB::table('advanceds')->where('user_id', $id)->update(['video' => $video_record,]);
            Storage::disk('public')->delete($url);
            return redirect()->back()->with('success', 'Your video has been successfully uploaded!');
        }else {
            return redirect()->back()->with('error', 'Only mp4 and webm files allowed');
        }
    }

    //This function return the user profile
    public function userprofile(Request $request, $userlink){

        $userdetails = detail::where('profile_address',$userlink)->get()[0];
        $id = $userdetails->id;
        $userinfo = User::find($id);
        $query_advanced = $userinfo->advanced;
        $review = review::where('user_id',$id)->get();  //reviews
        if ($query_advanced == 1) {
            $advancedinfo = advanced::where('user_id', $id)->get();
            if (empty($advancedinfo[0])) {
                return view('layouts.userprofile', ['userdetails' => $userdetails, 'userinfo' => $userinfo, 'reviews' => $review]);
            }else{
                return view('layouts.userprofile', ['userdetails' => $userdetails,'userinfo' => $userinfo,'advancedinfo' => $advancedinfo, 'reviews' => $review]);
            }
            
        }else{
            return view('layouts.userprofile', ['userdetails' => $userdetails, 'userinfo' => $userinfo, 'reviews' => $review]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\review;
use App\detail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
            'user_id' => ['required', 'numeric'],           //user getting reviewed
            'reviewer_id' => ['required', 'numeric'],       //reviewer
            'stars' => ['required', 'numeric'],             //stars qualification
            'review' => ['required', 'alpha_num'],          //review
        ]);

        return review::create([
            'user_id' => Auth::user()->id,
            'reviewer_id' => $request['reviewer_id'],
            'stars' => $request['stars'],
            'review' => $request['review'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(review $review)   //This function retrieves the review the user wants to respond to
    {
        $rwid = $review['review_id'];       //review id retrieved from webpage
        $review = review::find($rwid);      //find the review on database
        return $review;                     //sends the info to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(review $review)
    {
        $this->validate($request, [
            'user_id' => ['required', 'numeric'],                   //the user who got reviewed
            'review_id' => ['required', 'numeric'],                 //the reviewer id                  
            'review_response' => ['required', 'alpha_num'],         //the response to review
        ]);

        return review::update([
            'review_response' => $request['review_response'],       //uploads the review response
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(review $review)
    {
        //
    }
}

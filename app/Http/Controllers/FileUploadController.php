<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FileUploadController extends Controller
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
    public function create(Request $request)
    {
        $id = Auth::user()->id;
        if ($request->ajax()) {
            $pr = detail::where('user_id', $id)->get();
            return response()->json(
                $pr->toArray()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $id = Auth::user()->id;
        $file = $request['picture'];
        $folder = "userid" . $id . "-" . "images";

        if (empty($file)) {
            return redirect()->back()->with('error', 'An image is required for this operation');
        }else {
            $imageName = time()."user" . $id .'.'.request()->picture->getClientOriginalExtension();
            $detail_record = $folder . '/' . $imageName;
            $url = $request['currentpic'];
            $currentpic = substr($url, 15);
            Storage::putFileAs('public/'.$folder, $file, $imageName);
            DB::table('details')->where('user_id', $id)->update(['picture' => $detail_record,]);
            Storage::disk('public')->delete($url);
            return redirect()->back();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

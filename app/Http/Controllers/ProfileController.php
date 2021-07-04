<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProfile;
use App\Http\Requests\StoreProfileAvatar;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.profiles.index');
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
        //
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
        return view('users.profiles.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProfile $request, $id)
    {


         if ($file = $request->file('avatar')) {
            if (auth()->user()->avatar_url) {
                 File::delete(public_path(auth()->user()->avatar_url));
             }

                      $fileName = auth()->user()->id.'_'.rand(111111,999999).$file->getClientOriginalName();
                      $filePath = 'users/build/images/profile/';
                      $file->move($filePath,$fileName);
                      auth()->user()->update(['avatar_url' => '/'.$filePath.$fileName]);
                  }         
        


        auth()->user()->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
                            ]);

        return redirect(route('profiles.index'));
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

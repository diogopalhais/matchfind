<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
      return view('user.profile');
    }

    public function profile_player($id)
    {
      $player= \App\User::find($id);
      return view('user.profile_player',compact('player'));
    }

    public function profile_edit()
    {
      return view('user.profile_edit');
    }

    public function requests()
    {
      return view('user.requests');
    }

    public function invites()
    {
      return view('user.invites');
    }

    public function markallasread()
    {
      \Auth::user()->unreadNotifications->markAsRead();
      return back();
    }

    public function profile_update(Request $request)
    {

      // return dd($request->all());

      $validator = \Validator::make($request->all(), [
          'name' => 'required',
      ]);

      if ($validator->fails()) {
         return back()
                     ->withErrors($validator)
                     ->withInput();
       }

       $user = \Auth::user();
       $user->name = $request->name;

       if($request->location){
         $user->location = $request->location;
       }

       if($request->sports){
         foreach ($request->sports as $sport) {
           $user->sports()->attach($sport);
         }
       }

       if($request->photo){
         $image = time().'.'.$request->photo->getClientOriginalExtension();
         $request->photo->move(public_path('images'), $image);
         $url='/images/'.$image;
         $user->photo =  $url;
       }

       $user->save();


      return redirect('/profile')->with('success','Success! You edited your profile successfully');
    }
}

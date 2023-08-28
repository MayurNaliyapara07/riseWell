<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Rules\MatchOldPassword;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class UserProfileController extends Controller
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

        $id = Auth::user()->id;
        $user = User::find($id);
        $password = $user->password;


        return view('user.user_profile')->with('user', $user)->with('action', 'UPDATE');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ID)
    {

        $UserProfile = \App\Models\User::find($ID);
        return view('user.edit-profile')->with(compact('UserProfile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ID)
    {
        $validatedData = $request->validate([
            'name' => 'required:users,name',
            'email' => 'unique:users,email,'.$ID
        ]);

        $user = \App\Models\User::find($ID);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            @unlink(public_path('uploads/' . $user->image));
            $filename = Storage::disk('public_uploads')->put('UserImage', $image);
            $user->image = $filename;
        }
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->save();
        $request->session()->flash('warning', 'Profile Change successfully');
        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




}

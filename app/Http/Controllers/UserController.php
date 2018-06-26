<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
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


    public function login(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        $user = User::where('email', $request['email'])->first();

        log::info($request);

        if(!Auth::attempt($credentials)) {
            log::info('Credentials error');
            return response('Credentials error',500);

        }
        else{
            log::info('credentials exists');

            return response()->json($user);

//            $privilegename = Privileges::pluck('name');
//
//            foreach ($privilegename as $key) {
//
//                if(User::find(Auth::user()->id)->checkPrivileges($key) == 1){
//
//                    Session::put($key, 1);
//
//                }
//
//                else{
//
//                    Session::put($key, 0);
//
//                }
//
//            }
//
//            Session::put('user_pass', Input::get('password'));
//
//            Auth::login($user);
//            return redirect('/');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        log::info($request);
        $validator = Validator::make($request->all(), [
            'email' => 'bail|unique:users',

        ]);
        if ($validator->fails()){
            return response("ERROR: User already exists!", 500);
        }else{
            $request['password'] = Hash::make($request['password']);
            $request['role_id'] = 2;
            $user = User::create($request->all());
            return response($user, 200);
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
        $user = User::find($id);
        dd($user->book);
        return response()->json($user);
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

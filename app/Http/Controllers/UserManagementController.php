<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;


class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderby('id', 'asc')->get();
        return view('usermanagement.index',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderby('id', 'asc')->get();
        return view('usermanagement.add',[
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_user = new User();
        $new_user->name = $request->name;
        $new_user->username  = $request->new_user_name;
        $new_user->password = Hash::make($request->password);
        if($new_user->save()){
            $new_user->assignRole($request->user_role);
            return response()->json(['status' => 1]);
        }
        return response()->json(['status' => 0]);
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
        $user = User::find($id);
        $user_role = DB::table('model_has_roles')->where('model_id',$id)->first();
        $roles = Role::all();
        // $user_role = Role::where('id',$user_role->role_id)->first();
        $user_role = null;
        return view('usermanagement.edit',compact('user','roles','user_role','user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->role);
        return redirect()->route('usermanagement.index')->with('feedback' ,'แก้ไขเรียบร้อยแล้ว');
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

    public function checkUser(Request $request)
    {
        $users = User::where('username', $request->user)->count();
        if($users > 0){
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }
}

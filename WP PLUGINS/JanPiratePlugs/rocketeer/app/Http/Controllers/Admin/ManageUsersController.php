<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Media;
use App\Classes\JaskoHelper;
use Validator;
use Auth;

class ManageUsersController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function manage(){
        $users              =   User::paginate(30);
        return view( 'admin.users.manage' )->with([
            'users'         =>  $users,
            'is_demo'       =>  Auth::user()->is_demo
        ]);
    }

    public function delete(Request $request){
        $output             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        Media::where( 'uid', $request->input('uid') )->update([
            'uid'           =>  Auth::user()->id
        ]);
        User::destroy( $request->input('uid') );

        $output['status']   =   2;
        return response()->json( $output );
    }

    public function edit_user_page($id){
        $user               =   User::find($id);

        if(!$user){
            return redirect()->route('adminManageUsers');
        }

        return view('admin.users.edit')->with([
            'edit_user'     =>  $user,
            'countries'     =>  JaskoHelper::get_countries()
        ]);
    }

    public function edit_user($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'display_name'      =>  'required|min:3|max:255',
            'location'          =>  'required',
            'gender'            =>  'required|integer',
            'about'             =>  'min:3|max:1000'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                       =   User::find($id);
        $user->username             =   e($request->input('username'));
        $user->display_name         =   e($request->input('display_name'));
        $user->location             =   e($request->input('location'));
        $user->gender               =   intval($request->input('gender'));
        $user->about                =   e($request->input('about'));
        $user->isMod                =   intval($request->input('is_mod'));
        $user->autoapprove          =   intval($request->input('autoapprove'));
        $user->email_confirmed      =   intval($request->input('email_confirmed'));
        $user->save();

        $output['status']           =   2;
        return response()->json($output);
    }
}

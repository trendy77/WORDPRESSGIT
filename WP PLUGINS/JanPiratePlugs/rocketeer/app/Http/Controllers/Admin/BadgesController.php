<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Badge;
use Auth;
use Validator;

class BadgesController extends Controller
{
    public function __construct(){
        $this->middleware('mod');
    }

    public function manage(){
        $badges                 =   Badge::all();
        return view( 'admin.badges.manage' )->with([
            'badges'            =>  $badges,
            'is_demo'           =>  Auth::user()->is_demo
        ]);
    }

    public function add(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'name'              =>  'required|min:1|max:255',
            'img'               =>  'required|image'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $img                    =   $request->file( 'img' );
        $name                   =   $img->getClientOriginalName();
        $destination            =   base_path() . '/public/uploads/badges/';
        $img->move( $destination, $name );

        // Create Badge
        $badge                  =   Badge::create([
            'title'             =>  $request->input('name'),
            'img'               =>  'badges/' . $name,
            'badge_desc'        =>  $request->input('desc'),
            'min_points'        =>  $request->input('min'),
        ]);

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function delete(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'bid'               => 'required|integer'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        Badge::destroy($request->input('bid'));

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function update(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'bid'               => 'required|integer',
            'name'              => 'required|min:1|max:255'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $badge                  =   Badge::find($request->input('bid'));
        $badge->title           =   $request->input('name');
        $badge->badge_desc      =   $request->input('desc');
        $badge->min_points      =   $request->input('min');
        $badge->save();

        $output['status']       =   2;
        return response()->json( $output );
    }
}

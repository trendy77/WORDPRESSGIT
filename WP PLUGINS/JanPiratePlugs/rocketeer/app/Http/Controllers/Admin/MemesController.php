<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Memes;
use Validator;
use Auth;

class MemesController extends Controller
{
    public function __construct(){
        $this->middleware('mod');
    }

    public function manage(){
        $memes                 =   Memes::all();
        return view( 'admin.memes.manage' )->with([
            'memes'             =>  $memes,
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
            'meme_img'          =>  'required|image'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $img                    =   $request->file( 'meme_img' );
        $name                   =   $img->getClientOriginalName();
        $destination            =   base_path() . '/public/uploads/memes/';
        $img->move( $destination, $name );

        // Create Meme
        $meme                   =   Memes::create([
            'meme_name'         =>  $request->input('name'),
            'upl_name'          =>  'memes/' . $name,
            'ext'               =>  $img->getClientOriginalExtension(),
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
            'mid'               => 'required|integer'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        Memes::destroy($request->input('mid'));

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function update(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'mid'               => 'required|integer',
            'name'              => 'required|min:1|max:255'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $meme                   =   Memes::find($request->input('mid'));
        $meme->meme_name        =   $request->input('name');
        $meme->save();

        $output['status']       =   2;
        return response()->json( $output );
    }
}

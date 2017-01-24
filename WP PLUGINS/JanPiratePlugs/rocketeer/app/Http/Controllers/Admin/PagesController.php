<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pages;
use Validator;
use Auth;

class PagesController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function manage(){
        $pages                 =   Pages::all();
        return view( 'admin.pages.manage' )->with([
            'pages'             =>  $pages,
            'is_demo'           =>  Auth::user()->is_demo
        ]);
    }

    public function add_page(){
        return view( 'admin.pages.add' );
    }

    public function add(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'title'             =>  'required|min:1|max:255',
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        // Create Page
        $page                   =   Pages::create([
            'title'             =>  $request->input('title'),
            'page_type'         =>  $request->input('page_type'),
            'slug_url'          =>  str_slug( $request->input('title'), '-' ),
            'contact_email'     =>  $request->input('contact_email'),
            'direct_url'        =>  $request->input('direct_url'),
            'page_content'      =>  $request->input('content'),
        ]);

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function update_page( $pid ){
        $page                   =   Pages::where('id', '=', $pid);

        if(!$page->exists()){
            return redirect( '/admin/pages' );
        }

        $page                   =   $page->first();

        return view( 'admin.pages.update' )->with( 'page', $page );
    }

    public function update(Request $request, $pid){
        $page                   =   Pages::where('id', '=', $pid);

        if(!$page->exists()){
            return redirect( '/admin/pages' );
        }

        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }


        $validator              =   Validator::make($request->all(), [
            'title'             =>  'required|min:1|max:255',
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page                   =   $page->first();
        $page->title            =   $request->input('title');
        $page->page_type        =   $request->input('page_type');
        $page->slug_url         =   str_slug( $request->input('title'), '-' );
        $page->contact_email    =   $request->input('contact_email');
        $page->direct_url       =   $request->input('direct_url');
        $page->page_content     =   $request->input('content');
        $page->save();

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function delete(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'pid'               => 'required|integer'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        Pages::destroy($request->input('pid'));

        $output['status']       =   2;
        return response()->json( $output );
    }
}

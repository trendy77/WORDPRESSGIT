<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categories;
use Validator;
use App\Classes\JaskoHelper;
use App\SiteSettings;
use Auth;

class CategoriesController extends Controller
{
    protected $settings;

    public function __construct(){
        $this->middleware('mod');
        $this->settings         =   SiteSettings::find(1);
    }

    public function manage(){
        $categories                 =   Categories::all();
        return view( 'admin.categories.manage' )->with([
            'categories'            =>  $categories,
            'is_demo'               =>  Auth::user()->is_demo
        ]);
    }

    public function add(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'name'              => 'required|min:1|max:255',
            'pos'               => 'required|integer',
            'color'             => 'required',
            'img'               => 'required|image'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $img                                        =   $request->file( 'img' );
        $name                                       =   $img->getClientOriginalName();
        $destination                                =   base_path() . '/public/uploads/';
        $img->move( $destination, $name );

        JaskoHelper::resize_image( $destination . $name, $destination . $name, 270, 105 );

        // Create Category
        $category               =   Categories::create([
            'name'              =>  $request->input('name'),
            'slug_url'          =>  str_slug( $request->input('name') ),
            'pos'               =>  $request->input('pos'),
            'bg_color'          =>  $request->input('color'),
            'cat_img'           =>  $img->getClientOriginalName()
        ]);

        if($this->settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $name );
        }

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function delete(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'cid'               => 'required|integer'
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        Categories::destroy($request->input('cid'));

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function update(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'cid'               => 'required|integer',
            'name'              => 'required|min:1|max:255',
            'pos'               => 'required|integer',
            'color'             => 'required',
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        $category               =   Categories::find($request->input('cid'));
        $category->name         =   $request->input('name');
        $category->slug_url     =   str_slug( $request->input('name') );
        $category->pos          =   $request->input('pos');
        $category->bg_color     =   $request->input('color');

        if($request->hasFile('img')){
            $img                                        =   $request->file( 'img' );
            $name                                       =   $img->getClientOriginalName();
            $destination                                =   base_path() . '/public/uploads/';
            $img->move( $destination, $name );
            $category->cat_img                          =   $img->getClientOriginalName();

            JaskoHelper::resize_image( $destination . $name, $destination . $name, 270, 105 );

            if($this->settings->aws_s3 == 2){
                JaskoHelper::aws_s3_upload( $name );
            }
        }

        $category->save();

        $output['status']       =   2;
        return response()->json( $output );
    }
}

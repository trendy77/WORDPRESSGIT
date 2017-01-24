<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SiteSettings;
use App\User;
use Auth;
use Storage;

class EmailController extends Controller
{
    protected $settings;

    public function __construct(){
        $this->middleware('admin');
        $this->settings                     =   SiteSettings::find(1);
    }

    public function export(){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $exported_users                     =   User::all();
        $exported_email_arr                 =   [];

        foreach( $exported_users as $euk => $euv ){
            array_push( $exported_email_arr, $euv->username . "," . $euv->email );
        }

        $exported_csv_txt                   =   implode( "\r\n", $exported_email_arr );

        Storage::put( "exported-emails.txt", $exported_csv_txt );

        $output['redirect_url']             =   route('adminDownloadExportedEmails');
        $output['status']                   =   2;
        return response()->json( $output );
    }

    public function download(){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $exported_file                      =   storage_path('app/exported-emails.txt');
        return response()->download($exported_file);
    }
}

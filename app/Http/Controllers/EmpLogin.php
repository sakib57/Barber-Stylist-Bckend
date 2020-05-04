<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class EmpLoginController extends Controller
{
    
    public function index(){
        dd(session('saloon_user_info'));
        // if(session('saloon_user_info')){
        //     return redirect('dashbord');
        // }
        // return view('welcome');
    }
}

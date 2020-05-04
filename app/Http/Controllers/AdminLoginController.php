<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class AdminLoginController extends Controller
{
    function __construct(){
        
    }
    public function index(){
        //dd(session('saloon_user_info'));
        // if(session('saloon_user_info')){
        //     return redirect('dashbord');
        // }
        return view('admin_login');
    }
    
    public function login_check(Request $request){
        $user = DB::table('admins')->where('email',$request->email)->where('password',$request->password)->first();
        //dd($user);
        if($user){
            $adminInfo = array(
                'id' => $user->id,
                'name' => $user->name,
                
            );
            $request->session()->put('saloon_admin_info',  $adminInfo);
            return redirect('/admin-dashboard');
        }else{
            return redirect('/admin');
        }
    }
}

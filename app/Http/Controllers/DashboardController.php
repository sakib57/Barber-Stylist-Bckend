<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function dashboard(){
        if(!session('saloon_user_info')){
            return redirect('/');
        }
        return view('pages.home');
    }
    public function index(Request $request){
        //dd($request);
        $user = DB::table('employees')->where('username',$request->username)->where('password',$request->password)->first();
        //dd($user);
        if($user){
            $userInfo = array(
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'designation' => $user->designation,
                'image' => $user->image,
                
            );
            $request->session()->put('saloon_user_info',  $userInfo);
            return view('pages.home');
        }else{
            return redirect('/');
        }
    }
    
    
    
    public function logout(Request $request){
        $request->session()->forget('saloon_user_info');
        //dd(session('saloon_user_info'));
        return redirect('/');
    }
}

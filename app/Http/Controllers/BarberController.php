<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    public function __construct(Request $request){
        
    }
    
    public function account(){
        $user_info = session('saloon_user_info'); 
        //dd($user_info);
        $data = DB::table('employees')->where('id',$user_info['id'])->first();
        //dd($data);
        return view('pages.account')->with('data',$data);
    }
    
    public function payment(){
        
    }
    
    public function contact(){
        return view('pages.contact');
    }
    
    public function contact_save(Request $request){
        //dd($request);
        $data = array(
            'subject' => $request->subject,
            'message' => $request->message
        );
        if(DB::table('contact')->insert($data)){
            return back();
        }
    }
    
    public function cng_pass(){
        return view('pages.cng_pass');
    }
    
    public function update_pass(Request $request){
        //$user_info = session('saloon_user_info'); 
        $data = DB::table('employees')->select('password')->where('id', $request->id)->first();
        if($data->password != $request->old_pass){
            
            return back()->withErrors(['Provided password did not match']);
        }else{
            if(DB::table('employees')->where('id',$request->id)->update(['password' => $request->new_pass])){
               return back()->with('success','Password updated successfully');
            }
        }
    }
}

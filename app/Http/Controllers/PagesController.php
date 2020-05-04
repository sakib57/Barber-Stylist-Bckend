<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct(Request $request){
        
    }
    
    public function index(){
        $user_info = session('saloon_user_info'); 
        //dd($user_info);
        $data = DB::table('terms')->where('emp_id',$user_info['id'])->first();
        //dd($data);
        return view('pages.terms')->with('data',$data);
    }
    
    public function save_terms(Request $request){
        $user_info = session('saloon_user_info'); 
        //dd($request);
        $data = array(
          'title' => $request->title,
          'message' => $request->message
        );
        if(DB::table('terms')->updateOrInsert(['emp_id' => $user_info['id']],$data)){
            return redirect('terms-condition');
        }
    }
}

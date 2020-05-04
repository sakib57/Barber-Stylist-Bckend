<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function index(){
    	$data = DB::table('users')->get();
    	return view('pages.manage_customer')->with('data',$data);
    }

    public function list(){
    	return Datatables::of(User::query()->get()) 
         ->editColumn('action', function(User $e) {
            return "<a href='".route('asd',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
          })
        ->escapeColumns([])
        ->make(true);
    }
}

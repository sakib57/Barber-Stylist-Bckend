<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Schedule;

class ScheduleController extends Controller
{
    public function index(){
        $user_info = session('saloon_user_info'); 
    	$data = DB::table('schedules')->where('emp_id',$user_info['id'])->first();
    	//dd($data);
    	return view('pages.add_schedule')->with('data',$data);
    }

    public function list(){
        return Datatables::of(Schedule::query()->get()) 
         ->editColumn('action', function(Schedule $e) {
            return "<a href='".route('asd',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
          })
        ->escapeColumns([])
        ->make(true);
    }

    public function add(){
    	return view('pages.add_schedule');
    }

    public function save(Request $request){
        $user_info = session('saloon_user_info'); 
	    $data = array(
	    	'mon_start_time' => $request->mon_start_time,
	    	'mon_end_time' => $request->mon_end_time,
	    	'tue_start_time' => $request->tue_start_time,
	    	'tue_end_time' => $request->tue_end_time,
	    	'wed_start_time' => $request->wed_start_time,
	    	'wed_end_time' => $request->wed_end_time,
	    	'thu_start_time' => $request->thu_start_time,
	    	'thu_end_time' => $request->thu_end_time,
	    	'fri_start_time' => $request->fri_start_time,
	    	'fri_end_time' => $request->fri_end_time,
	    	'sat_start_time' => $request->sat_start_time,
	    	'sat_end_time' => $request->sat_end_time
	    );
	    if(DB::table('schedules')->updateOrInsert(['emp_id' => $user_info['id']],$data)){
	    	return redirect('add-schedule');
	    }
    }

    
}

<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Booking;
class BookingController extends Controller
{
    public function index(){
        $current_date = date('Y-m-d h:m:i');
        $user_info = session('saloon_user_info'); 
    	$data = DB::table('bookings')
            ->join('employees', 'employees.id', '=', 'bookings.employee_id')
            ->join('users', 'users.id', '=', 'bookings.customer_id')
            ->where('bookings.employee_id',$user_info['id'])
            ->where('bookings.date_check','>',$current_date)
            ->select('users.first_name','users.last_name','users.last_name','bookings.*')
            ->get();
        //dd($data);
        //$data = [];
    	return view('pages.manage_booking')->with('data',$data);
    }
    
     public function list(){
        $current_date = date('Y-m-d h:m:i');
        $user_info = session('saloon_user_info'); 
        return Datatables::of(Booking::join('employees', 'employees.id', '=', 'bookings.employee_id')
            ->join('users', 'users.id', '=', 'bookings.customer_id')
            ->where('bookings.employee_id',$user_info['id'])
            ->where('bookings.date_check','>',$current_date)
            ->select('users.first_name','users.last_name','bookings.*')
            ->get())
        
        ->editColumn('total_price', function(Booking $e) {
            return '$'.$e->total_price;
          })
          ->editColumn('first_name', function(Booking $e) {
            return $e->first_name.' '.$e->last_name;
          })
          ->editColumn('is_confirmed', function(Booking $e) {
              if($e->is_confirmed == 0){
                  return '<span style="padding:5px;color:white;background-color:coral;border-radius:4px">Pending</span>';
              }else{
                  return '<span style="padding:5px;color:white;background-color:green;border-radius:4px">Confirmed</span>';
              }
            
          })
          ->editColumn('schedule_start', function(Booking $e) {
            $date=date_create($e->schedule_start);
            return  date_format($date,"h:i a");
          })
        ->editColumn('date', function(Booking $e) {
            $date=date_create($e->date);
            return  date_format($date,"d M, Y");
          })
         ->editColumn('action', function(Booking $e) {
            return "<a href='".route('asd',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
          })
        ->escapeColumns([])
        ->make(true);
    }
    
    
    public function previous_booking(){
        $current_date = date('Y-m-d h:m:i');
        $user_info = session('saloon_user_info'); 
    	$data = DB::table('bookings')
            ->join('employees', 'employees.id', '=', 'bookings.employee_id')
            ->join('users', 'users.id', '=', 'bookings.customer_id')
            ->where('bookings.employee_id',$user_info['id'])
            ->where('bookings.date_check','<',$current_date)
            ->select('users.first_name','users.last_name','users.last_name','bookings.*')
            ->get();
        
    	return view('pages.manage_prev_booking')->with('data',$data);
    }

    
    public function previous_list(){
        $current_date = date('Y-m-d h:m:i');
        $user_info = session('saloon_user_info'); 
        return Datatables::of(Booking::join('employees', 'employees.id', '=', 'bookings.employee_id')
            ->join('users', 'users.id', '=', 'bookings.customer_id')
            ->where('bookings.employee_id',$user_info['id'])
            ->where('bookings.date_check','<',$current_date)
            ->select('users.first_name','users.last_name','bookings.*')
            ->get())
        
        ->editColumn('total_price', function(Booking $e) {
            return '$'.$e->total_price;
          })
          ->editColumn('first_name', function(Booking $e) {
            return $e->first_name.' '.$e->last_name;
          })
          ->editColumn('is_confirmed', function(Booking $e) {
              if($e->is_confirmed == 0){
                  return '<span style="padding:5px;color:white;background-color:coral;border-radius:4px">Pending</span>';
              }else{
                  return '<span style="padding:5px;color:white;background-color:green;border-radius:4px">Confirmed</span>';
              }
            
          })
          ->editColumn('schedule_start', function(Booking $e) {
            $date=date_create($e->schedule_start);
            return  date_format($date,"h:m a");
          })
        ->editColumn('date', function(Booking $e) {
            $date=date_create($e->date);
            return  date_format($date,"d M, Y");
          })
         ->editColumn('action', function(Booking $e) {
            return "<a href='".route('asd',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
          })
        ->escapeColumns([])
        ->make(true);
    }

    public function accept(){
    	$booking_id = request()->segment(2);
    	DB::table('bookings')
            ->where('id',$booking_id)
            ->update(['status' => 1]);
    	return back();
    }
}

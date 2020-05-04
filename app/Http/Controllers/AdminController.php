<?php

namespace App\Http\Controllers;
use DB;
use Yajra\Datatables\Datatables;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class AdminController extends Controller
{
    function __construct(){
        
    }
    public function index(){
        //dd(session('saloon_user_info'));
        // if(session('saloon_user_info')){
        //     return redirect('dashbord');
        // }
        return view('pages.admin.home');
    }
    
    public function manage_barbers(){
        $data = DB::table('employees')->get();
    	return view('pages.admin.manage_employee')->with('data',$data);
    }
    
    public function manage_barbers_list(){
        	return Datatables::of(Employee::query()->get()) 
        ->editColumn('employee_name', function(Employee $e) {
          return $e->first_name.' '.$e->last_name;
        }) 
        ->editColumn('image', function(Employee $e) {
            //echo $e->image;
            if($e->image){
                return "<img src='".url('/').'/public/images/'.$e->image."' style='width:90px;height:90px;border-radius:5px'>";
            }else{
                return "<img src='".url('/').'/public/images/thumb_demo_user.png'."' style='width:90px;height:90px;border-radius:5px'>";
            }
            
          }) 
         ->editColumn('address', function(Employee $e) {
            return $e->addr1.' '.$e->addr2;
          })
        ->editColumn('action', function(Employee $e) {
            return "<a href='".route('barber_detail',['id'=>$e->id])."' class='btn btn-info'>Detail</a><button type='button' data-id='".$e->id."' class='btn btn-danger dlt'>Delete</button>";
          })
        ->escapeColumns([])
        ->make(true);
    }
    
    public function barber_detail(Request $request){
        $barber_id = $request->id;
        //dd($barber_id);
        $data = DB::table('employees')->where('id',$barber_id)->first();
        $schedule = DB::table('schedules')->where('emp_id',$barber_id)->first();
        
        $booking = DB::table('bookings')
            ->join('employees', 'employees.id', '=', 'bookings.employee_id')
            ->join('users', 'users.id', '=', 'bookings.customer_id')
            ->where('bookings.employee_id',$barber_id)
            ->select('bookings.schedule_start','bookings.schedule_end','users.first_name','users.last_name','bookings.id','employees.first_name','employees.last_name','employees.phone')
            ->get();
        //dd($booking);
        
        return view('pages.admin.barber_detail')->with('data',$data)->with('schedule',$schedule)->with('booking',$booking);
        
    }
    
    public function manage_users(){
        $data = DB::table('users')->get();
    	return view('pages.admin.manage_users')->with('data',$data);
    }
    
    public function manage_users_list(){
        //echo "asdasd";
        //die;
        	return Datatables::of(User::query()->get())
        ->editColumn('action', function(User $e) {
            //return "<a href='".route('delete_user',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
            return "<button type='button' data-id='".$e->id."' class='btn btn-danger dlt'>Delete</button>";
          })
          ->editColumn('name', function(User $e) {
            return $e->first_name.' '.$e->last_name;
          })
        ->escapeColumns([])
        ->make(true);
    }
    
    public function delete_user(Request $request){
        $id = $request->id;
        //return $id;
        if(DB::table('users')->where('id',$id)->delete()){
            return 'ok';
        }
    }
    
    public function delete_employee(Request $request){
        $id = $request->id;
        //return $id;
        if(DB::table('employees')->where('id',$id)->delete()){
            return 'ok';
        }
    }
    
    public function logout(Request $request){
        $request->session()->forget('saloon_admin_info');
        //dd(session('saloon_user_info'));
        return redirect('/admin');
    }
    
}

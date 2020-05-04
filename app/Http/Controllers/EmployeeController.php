<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Employee;
use Intervention\Image\ImageManagerStatic as Image;

class EmployeeController extends Controller
{
    public function index(){
    	$data = DB::table('employees')->get();
    	return view('pages.manage_employee')->with('data',$data);
    }

    public function list(){
    		return Datatables::of(Employee::query()->get()) 
        ->editColumn('employee_name', function(Employee $e) {
          return $e->first_name.' '.$e->last_name;
        }) 
        ->editColumn('image', function(Employee $e) {
            return "<img src='".url('/').'/public/images/'.$e->image."' style='width:100px;height:100px;'>";
          }) 
         ->editColumn('action', function(Employee $e) {
            return "<a href='".route('asd',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
          })
        ->escapeColumns([])
        ->make(true);
    }

    public function add(){
    	return view('pages.add_employee');
    }

    public function save(Request $request){
    	//dd($request);
    	$this->validate($request, [
	        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
	    ]);

    	if ($request->hasFile('image')) {
    		//dd('zdasda');
	        $image = $request->file('image');
	        $name = time().'.'.$image->getClientOriginalExtension();
	        $destinationPath = public_path('/images');
	        $image->move($destinationPath, $name);
	        
	        Image::make('public/images/'.$name)->resize(150, 150)->save('public/images/'.'thumb_'.$name);
	    }
	    $data = array(
	    	'first_name' => $request->first_name,
	    	'last_name' => $request->last_name,
	    	'designation' => $request->designation,
	    	'address' => $request->address,
	    	'phone' => $request->phone,
	    	'image' => $name
	    );

	    if(DB::table('employees')->insert($data)){
	    	return back();
	    }
    }
    
    public function update(Request $request){
        $user_info = session('saloon_user_info'); 
        //dd($request);
        $data = array(
	    	'first_name' => $request->first_name,
	    	'last_name' => $request->last_name,
	    	'email' => $request->email,
	    	'address' => $request->address,
	    	'location' => $request->location,
	    	'lat' => $request->lat,
	    	'lng' => $request->lng,
	    	'phone' => $request->phone
	    );
        if(DB::table('employees')->where('id',$user_info['id'])->update($data)){
            return redirect('barber-account');
        }
    }
}

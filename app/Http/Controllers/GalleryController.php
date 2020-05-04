<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class GalleryController extends Controller
{
    public function index(){
        $user_info = session('saloon_user_info');
    	$data = DB::table('gallery')->where('emp_id',$user_info['id'])->get();
    	return view('pages.manage_gallery')->with('data',$data);
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
    	return view('pages.add_gallery');
    }

    public function save(Request $request){
        $user_info = session('saloon_user_info');
    	//dd($request);
    	if ($request->hasFile('image')) {
	        $image = $request->file('image');
	       // dd($image);
	        $name = time().'.'.$image->getClientOriginalExtension();
	        $destinationPath = public_path('/images');
	        $image->move($destinationPath, $name);
	        
	        Image::make('public/images/'.$name)->resize(150, 150)->save('public/images/'.'thumb_'.$name);
	    }
	    $data = array(
	    	'emp_id' => $user_info['id'],
	    	'image' => $name
	    );

	    if(DB::table('gallery')->insert($data)){
	    	return back();
	    }
    }
}

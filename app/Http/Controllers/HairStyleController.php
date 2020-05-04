<?php

namespace App\Http\Controllers;
use DB;
use Yajra\Datatables\Datatables;
use App\Hairstyle;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;

class HairStyleController extends Controller
{
    public function index(){
        $user_info = session('saloon_user_info'); 
    	$data = DB::table('hairstyles')->where('emp_id',$user_info['id'])->get();
    	return view('pages.manage_hairstyle')->with('data',$data);
    }

    public function list(){
            $user_info = session('saloon_user_info');
    		return Datatables::of(Hairstyle::query()->where('emp_id',$user_info['id'])->get()) 
        // ->editColumn('employee_name', function(Hairstyle $e) {
        //   return $e->first_name.' '.$e->last_name;
        // }) 
        ->editColumn('image', function(Hairstyle $e) {
            return "<img src='".url('/').'/public/images/'.$e->image."' style='width:100px;height:100px;'>";
          }) 
         ->editColumn('action', function(Hairstyle $e) {
            return "<a href='".route('asd',['id'=>$e->id])."' class='btn btn-danger'>Delete</a>";
          })
        ->escapeColumns([])
        ->make(true);
    }

    public function add(){
    	return view('pages.add_hairstyle');
    }

    public function save(Request $request){
        $user_info = session('saloon_user_info'); 
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
	    	'style_name' => $request->style_name,
	    	'emp_id' => $user_info['id'],
	    	'price' => $request->price,
	    	'image' => $name
	    );

	    if(DB::table('hairstyles')->insert($data)){
	    	return back();
	    }
    }


}

<?php

namespace App\Http\Controllers;
use DB;
use Yajra\Datatables\Datatables;
use App\Service;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $user_info = session('saloon_user_info'); 
    	$data = DB::table('services')->where('emp_id',$user_info['id'])->get();
    	return view('pages.manage_service')->with('data',$data);
    }

    public function list(){
            $user_info = session('saloon_user_info');
    		return Datatables::of(Service::query()->where('emp_id',$user_info['id'])->get()) 
        ->editColumn('price', function(Service $e) {
          return '$'.$e->price;
        }) 
        ->editColumn('duration', function(Service $e) {
            switch($e->duration){
                case '15' :
                    return '15 Minutes';
                    break;
                case '30' :
                    return '30 Minutes';
                    break;
                case '45' :
                    return '45 Minutes';
                    break;
                case '60' :
                    return '1 Hour';
                    break;
                case '75' :
                    return '1 Hour 15 Minutes';
                    break;
                case '90' :
                    return '1 Hour 30 Minutes';
                    break;
                default:
                    return $e->duration;
            }
          }) 
         ->editColumn('action', function(Service $e) {
            return "<a href='".route('edit_service',['id'=>$e->id])."' class='btn btn-info'>Edit</a><button type='button' data-id='".$e->id."' class='btn btn-danger dlt'>Delete</button>";
          })
        ->escapeColumns([])
        ->make(true);
    }

    public function add(){
    	return view('pages.add_service');
    }

    public function save(Request $request){
        $user_info = session('saloon_user_info'); 
    	// dd($request);
        // 	$this->validate($request, [
	    //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
	    // ]);

        // 	if ($request->hasFile('image')) {
        // 		//dd('zdasda');
    	   //     $image = $request->file('image');
    	   //     $name = time().'.'.$image->getClientOriginalExtension();
    	   //     $destinationPath = public_path('/images');
    	   //     $image->move($destinationPath, $name);
    
    	   //     Image::make('public/images/'.$name)->resize(150, 150)->save('public/images/'.'thumb_'.$name);
    
    	        
    	   // }

	    $data = array(
	    	'service_name' => $request->service_name,
	    	'emp_id' => $user_info['id'],
	    	'price' => $request->price,
	    	'duration' => $request->duration
	    );
	    
	    //dd($data);

	    if(DB::table('services')->insert($data)){
	    	return back();
	    }
    }
    
    public function edit(Request $request){
        $id = $request->id;
        $data = DB::table('services')->where('id',$id)->first();
    	return view('pages.edit_service')->with('data',$data);
    }
    
    public function update(Request $request){
        //dd($request);
        $data = array(
            'service_name' => $request->service_name,
            'duration' => $request->duration,
            'price' => $request->price,
        );
        if(DB::table('services')->where('id', $request->id)->update($data)){
            return redirect('/manage-service');
        }
    }
    
    public function delete(Request $request){
        $id = $request->id;
        if(DB::table('services')->where('id',$id)->delete()){
            return 'ok';
        }
    }
    
    


}

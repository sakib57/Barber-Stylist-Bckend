<?php
//defined('BASEPATH') or exit('No direct script access allowed');

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Booking;
use App\Employee;
use App\User;
use App\Subscription_barber;
use Mail;
class API extends Controller
{

  private function cors() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
  }

    public function login(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $user = DB::table('employees')
                     ->where('username',$result->username)
                     ->where('password',$result->password)
                     ->first();
        $response = [
            'status'=> 404
        ];
        if($user){
            $response = [
                'status'=> 200,
                'type'=> 'barber',
                'data'=> $user
            ];
            
        }else{
            $client = DB::table('users')
                     ->where('username',$result->username)
                     ->where('password',$result->password)
                     ->first();
            if($client){
                $response = [
                    'status'=> 200,
                    'type'=> 'client',
                    'data'=> $client
                ];
            }
            
            
        }
        
         return response()->json($response);
        
    }
    
    public function client_register(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $email_exist = DB::table('users')
                     ->where('email',$result->email)
                     ->select('email')
                     ->first();
                     
        $user_exist = DB::table('users')
                     ->where('username',$result->username)
                     ->select('username')
                     ->first();
        if($email_exist || $user_exist){
            $response = ['status'=> 200, 'message' => 'user or email already exist'];
        }else{
            $data = array(
                'first_name' => $result->first_name,
                'last_name' => $result->last_name,
                'email' => $result->email,
                'password' => $result->password,
                'phone' => $result->phone,
                'username' => $result->username,
                'addr1' => $result->addr1,
                'lat' => $result->lat,
                'lng' => $result->lng,
                'addr2' => $result->addr2,
                'post_code' => $result->post_code,
                'city' => $result->city,
                'state' => $result->state,
                'country' => $result->country,
                'subscription' => $result->subscription,
            );
            if($id = DB::table('users')->insertGetId($data)){
                $response = [
                    'status'=> 301,
                    'fname' => $result->first_name,
                    'lname' => $result->last_name,
                    'id' => $id,
                ];
            }else{
                $response = [
                    'status'=> 500
                ];
            }
        }
        return response()->json($response);
    }
    
    public function barber_register(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $email_exist = DB::table('employees')
                     ->where('email',$result->email)
                     ->select('email')
                     ->first();
                     
        $user_exist = DB::table('employees')
                     ->where('username',$result->username)
                     ->select('username')
                     ->first();
                     
                     
        if($email_exist || $user_exist){
            $response = ['status'=> 200, 'message' => 'user or email already exist'];
        }else{
            $data = array(
                'first_name' => $result->first_name,
                'last_name' => $result->last_name,
                'email' => $result->email,
                'password' => $result->password,
                'phone' => $result->phone,
                'username' => $result->username,
                'shop_name' => $result->shop_name,
                'addr1' => $result->addr1,
                'lat' => $result->lat,
                'lng' => $result->lng,
                'addr2' => $result->addr2,
                'post_code' => $result->post_code,
                'city' => $result->city,
                'state' => $result->state,
                'country' => $result->country,
                'license' => $result->license,
                'is_stylist' => $result->isStylist,
                'website' => $result->website,
                'subscription' => $result->subscription
            );
            if($id = DB::table('employees')->insertGetId($data)){
                $schedule = array(
                    'emp_id' => $id,
                  'sun_open' => $result->sunOpen,
                  'sun_start_time' => $result->sunSt,
                  'sun_end_time' => $result->sunEn,
                  'mon_open' => $result->monOpen,
                  'mon_start_time' => $result->monSt,
                  'mon_end_time' => $result->monEn,
                  'tue_open' => $result->tueOpen,
                  'tue_start_time' => $result->tueSt,
                  'tue_end_time' => $result->tueEn,
                  'wed_open' => $result->wedOpen,
                  'wed_start_time' => $result->wedSt,
                  'wed_end_time' => $result->wedEn,
                  'thu_open' => $result->thuOpen,
                  'thu_start_time' => $result->thuSt,
                  'thu_end_time' => $result->thuEn,
                  'fri_open' => $result->friOpen,
                  'fri_start_time' => $result->friSt,
                  'fri_end_time' => $result->friEn,
                  'sat_open' => $result->satOpen,
                  'sat_start_time' => $result->satSt,
                  'sat_end_time' => $result->satEn,
                );
                
                DB::table('schedules')->insert($schedule);
                $response = [
                    'status'=> 301,
                    'fname' => $result->first_name,
                    'lname' => $result->last_name,
                    'id' => $id,
                ];
            }else{
                $response = [
                    'status'=> 500
                ];
            }
        }
        return response()->json($response);
    }
    
    
    public function saloon_register(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $email_exist = DB::table('employees')
                     ->where('email',$result->email)
                     ->select('email')
                     ->first();
                     
        $user_exist = DB::table('employees')
                     ->where('username',$result->username)
                     ->select('username')
                     ->first();
                     
                     
        if($email_exist || $user_exist){
            $response = ['status'=> 200, 'message' => 'user or email already exist'];
        }else{
            $data = array(
                'first_name' => $result->first_name,
                'last_name' => $result->last_name,
                'email' => $result->email,
                'password' => $result->password,
                'phone' => $result->phone,
                'username' => $result->username,
                'shop_name' => $result->shop_name,
                'addr1' => $result->addr1,
                'lat' => $result->lat,
                'lng' => $result->lng,
                'addr2' => $result->addr2,
                'post_code' => $result->post_code,
                'city' => $result->city,
                'state' => $result->state,
                'country' => $result->country,
                'license' => $result->license,
                'is_stylist' => $result->isStylist,
                'is_saloon' => 1,
                'website' => $result->website,
                'subscription' => $result->subscription
            );
            
            if($id = DB::table('employees')->insertGetId($data)){
                $schedule = array(
                    'emp_id' => $id,
                  'sun_open' => $result->sunOpen,
                  'sun_start_time' => $result->sunSt,
                  'sun_end_time' => $result->sunEn,
                  'mon_open' => $result->monOpen,
                  'mon_start_time' => $result->monSt,
                  'mon_end_time' => $result->monEn,
                  'tue_open' => $result->tueOpen,
                  'tue_start_time' => $result->tueSt,
                  'tue_end_time' => $result->tueEn,
                  'wed_open' => $result->wedOpen,
                  'wed_start_time' => $result->wedSt,
                  'wed_end_time' => $result->wedEn,
                  'thu_open' => $result->thuOpen,
                  'thu_start_time' => $result->thuSt,
                  'thu_end_time' => $result->thuEn,
                  'fri_open' => $result->friOpen,
                  'fri_start_time' => $result->friSt,
                  'fri_end_time' => $result->friEn,
                  'sat_open' => $result->satOpen,
                  'sat_start_time' => $result->satSt,
                  'sat_end_time' => $result->satEn,
                );
                
                DB::table('schedules')->insert($schedule);
                $response = [
                    'status'=> 301,
                    'fname' => $result->first_name,
                    'lname' => $result->last_name,
                    'id' => $id,
                ];
            }else{
                $response = [
                    'status'=> 500
                ];
            }
        }
        return response()->json($response);
    }
    
    
    public function get_client_profile(){
        $this->cors();
        $client_id = request()->segment(2);
        $info = DB::table('users')
                ->join('countries','countries.id','=','users.country')
                ->join('states','states.id','=','users.state')
                ->select('users.*','countries.name as c_name','states.name as s_name')
                ->where('users.id',$client_id)->first();
        if($info){
            $response = [
                'status'=> 200,
                'info' => $info,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function update_client_profile(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $id = $result->id;
        if($result->image != ''){
            
            $raw_img = str_replace("data:image/jpeg;base64,","",$result->image);
            $img = base64_decode($raw_img);
            $filename = time().".jpg";
            $path = "public/images/".$filename;
            file_put_contents($path, $img);
            Image::make('public/images/'.$filename)->resize(150, 150)->save('public/images/'.'thumb_'.$filename);
            
            //return response()->json($result->prev_image);
            if($result->prev_image != ''){
                unlink('public/images/'.$result->prev_image);
                unlink('public/images/thumb_'.$result->prev_image);
            }
            
            if($result->country != '' && $result->state != ''){
                $dd = array(
                    'first_name' => $result->fname,
                    'last_name' => $result->lname,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'image' => $filename,
                    'post_code' => $result->post_code,
                    'city' => $result->city,
                    'state' => $result->state,
                    'addr1' => $result->addr1,
                    'addr2' => $result->addr2,
                    'country' => $result->country
                );
            }else{
                $dd = array(
                    'first_name' => $result->fname,
                    'last_name' => $result->lname,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'image' => $filename,
                    'post_code' => $result->post_code,
                    'city' => $result->city,
                    'addr1' => $result->addr1,
                    'addr2' => $result->addr2
                );
            }
            
            
        }else{
            if($result->country != '' && $result->state != ''){
                $dd = array(
                    'first_name' => $result->fname,
                    'last_name' => $result->lname,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'post_code' => $result->post_code,
                    'city' => $result->city,
                    'state' => $result->state,
                    'addr1' => $result->addr1,
                    'addr2' => $result->addr2,
                    'country' => $result->country
                );
            }else{
                $dd = array(
                    'first_name' => $result->fname,
                    'last_name' => $result->lname,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'post_code' => $result->post_code,
                    'city' => $result->city,
                    'addr1' => $result->addr1,
                    'addr2' => $result->addr2
                );
            }
            
        }
        DB::table('users')->where('id',$id)->update($dd);
        $response = [
            'status' => 200,
            'data' => $dd
        ];
        
        
        return response()->json($response);
    }
    // For Barber
    public function get_my_homepage_info(Request $request){
        $this->cors();
        $barber_id = request()->segment(2);
        $offset = $request->offset;
        $info = DB::table('employees')->where('id',$barber_id)->first();
        $service = DB::table('services')->where('emp_id',$barber_id)->get();
        $gallery = DB::table('gallery')->where('emp_id',$barber_id)->skip(4*$offset)->take(4)->get();
        
        $bookings = DB::table('bookings')
                ->join('users', 'users.id', '=', 'bookings.customer_id')
                ->select('users.first_name','users.first_name', 'bookings.*')
                ->where('bookings.employee_id',$barber_id)->get();
        $reviews = DB::table('reviews')
                ->join('employees', 'employees.id', '=', 'reviews.emp_id')
                ->join('users', 'users.id', '=', 'reviews.client_id')
                ->select('users.first_name','users.last_name','users.image', 'reviews.*')
                ->where('reviews.emp_id',$barber_id)
                ->get();
        $schedule = DB::table('schedules')->where('emp_id',$barber_id)->first();
        
        if($service || $gallery || $bookings || $reviews || $schedule){
            $response = [
                'status'=> 200,
                'info' => $info,
                'service' => $service,
                'gallery' => $gallery,
                'bookings' => $bookings,
                'reviews' => $reviews,
                'schedule' => $schedule,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_all_services(){
        $this->cors();
        $barber_id = request()->segment(2);
        $service = DB::table('services')->where('emp_id',$barber_id)->get();
        
        if($service){
            $response = [
                'status'=> 200,
                'service' => $service,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    //==================-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    public function get_edit_location_info(){
        $this->cors();
        $barber_id = request()->segment(2);
        
        $info = DB::table('employees')->where('id', $barber_id)->first();
        $schedule = DB::table('schedules')->where('emp_id',$barber_id)->first();
        
        if($info || $schedule){
            $response = [
                'status'=> 200,
                'info' => $info,
                'schedule' => $schedule,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    public function create_services(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $res = array(
            'service_name' => $result->service_name,
            'duration' => $result->duration,
            'price' => $result->price,
            'description' => $result->description,
            'emp_id' => $result->emp_id,
        );
        if(DB::table('services')->insert($res)){
            $response = [
                'status'=> 200,
                'data' => $result,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
        
    }
    
    public function update_services(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $id = $result->id;
        $dd = array(
            'service_name' => $result->service_name,
            'duration' => $result->duration,
            'price' => $result->price,
            'description' => $result->description,
            'emp_id' => $result->emp_id,
        );
        if(DB::table('services')->where('id', $id)->update($dd)){
            $response = [
                'status'=> 200,
                'data' => $result,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
        
    }
    
    public function delete_service(){
        $this->cors();
        $service_id = request()->segment(2);
        
        if(DB::table('services')->where('id', $service_id)->delete()){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    
    
    public function save_gallery(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        
        
        $raw_img = str_replace("data:image/jpeg;base64,","",$result->image);
        $img = base64_decode($raw_img);
        $filename = time().".jpg";
        $path = "public/images/".$filename;
        file_put_contents($path, $img);
        Image::make('public/images/'.$filename)->resize(150, 150)->save('public/images/'.'thumb_'.$filename);
        $data = array(
            'emp_id' => $result->emp_id,
            'image' => $filename
        );
        if($i = DB::table('gallery')->insertGetId($data)){
            $d = array(
                'id' => $i,
                'emp_id' => $result->emp_id,
                'image' => $filename
            );
            $response = [
                'status'=> 200,
                'data' => $d,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
        
    }
    
    
    
    public function update_profile(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        //return response()->json($result);
        $email_exist = DB::table('employees')->where('email',$result->email)->where('id','<>',$result->id)->first();
        if($email_exist){
            $response = [
                'status'=> 200
            ];
        }else{
            if(isset($result->image)){
                $raw_img = str_replace("data:image/jpeg;base64,","",$result->image);
                $img = base64_decode($raw_img);
                $filename = time().".jpg";
                $path = "public/images/".$filename;
                file_put_contents($path, $img);
                Image::make('public/images/'.$filename)->resize(150, 150)->save('public/images/'.'thumb_'.$filename);
                
                Image::make('public/images/'.$filename)->resize(400, 400)->save('public/images/'.'thumb2_'.$filename);
                
                if($result->prev_image != ''){
                    unlink('public/images/'.$result->prev_image);
                    unlink('public/images/thumb_'.$result->prev_image);
                    unlink('public/images/thumb2_'.$result->prev_image);
                }
                
                
                if($result->country != '' && $result->state != ''){
                    $data = array(
                        'first_name' => $result->fname,
                        'last_name' => $result->lname,
                        'email' => $result->email,
                        'phone' => $result->phone,
                        'shop_name' => $result->sname,
                        'addr1' => $result->addr1,
                        'addr2' => $result->addr2,
                        'post_code' => $result->post_code,
                        'city' => $result->city,
                        'state' => $result->state,
                        'country' => $result->country,
                        'website' => $result->webaddress,
                        'license' => $result->slnumber,
                        'image' => $filename,
                    );
                }else{
                    $data = array(
                        'first_name' => $result->fname,
                        'last_name' => $result->lname,
                        'email' => $result->email,
                        'phone' => $result->phone,
                        'shop_name' => $result->sname,
                        'addr1' => $result->addr1,
                        'addr2' => $result->addr2,
                        'post_code' => $result->post_code,
                        'city' => $result->city,
                        'website' => $result->webaddress,
                        'license' => $result->slnumber,
                        'image' => $filename,
                    );
                }
                
                
                $schedule = array(
                  'sun_open' => $result->sunOpen,
                  'sun_start_time' => $result->sunSt,
                  'sun_end_time' => $result->sunEn,
                  'mon_open' => $result->monOpen,
                  'mon_start_time' => $result->monSt,
                  'mon_end_time' => $result->monEn,
                  'tue_open' => $result->tueOpen,
                  'tue_start_time' => $result->tueSt,
                  'tue_end_time' => $result->tueEn,
                  'wed_open' => $result->wedOpen,
                  'wed_start_time' => $result->wedSt,
                  'wed_end_time' => $result->wedEn,
                  'thu_open' => $result->thuOpen,
                  'thu_start_time' => $result->thuSt,
                  'thu_end_time' => $result->thuEn,
                  'fri_open' => $result->friOpen,
                  'fri_start_time' => $result->friSt,
                  'fri_end_time' => $result->friEn,
                  'sat_open' => $result->satOpen,
                  'sat_start_time' => $result->satSt,
                  'sat_end_time' => $result->satEn,
                );
            }else{
                if($result->country != '' && $result->state != ''){
                    $data = array(
                        'first_name' => $result->fname,
                        'last_name' => $result->lname,
                        'email' => $result->email,
                        'phone' => $result->phone,
                        'shop_name' => $result->sname,
                        'addr1' => $result->addr1,
                        'addr2' => $result->addr2,
                        'post_code' => $result->post_code,
                        'city' => $result->city,
                        'state' => $result->state,
                        'country' => $result->country,
                        'website' => $result->webaddress,
                        'license' => $result->slnumber,
                    );
                }else{
                    $data = array(
                        'first_name' => $result->fname,
                        'last_name' => $result->lname,
                        'email' => $result->email,
                        'phone' => $result->phone,
                        'shop_name' => $result->sname,
                        'addr1' => $result->addr1,
                        'addr2' => $result->addr2,
                        'post_code' => $result->post_code,
                        'city' => $result->city,
                        'website' => $result->webaddress,
                        'license' => $result->slnumber,
                    );
                }
                
                
                $schedule = array(
                  'sun_open' => $result->sunOpen,
                  'sun_start_time' => $result->sunSt,
                  'sun_end_time' => $result->sunEn,
                  'mon_open' => $result->monOpen,
                  'mon_start_time' => $result->monSt,
                  'mon_end_time' => $result->monEn,
                  'tue_open' => $result->tueOpen,
                  'tue_start_time' => $result->tueSt,
                  'tue_end_time' => $result->tueEn,
                  'wed_open' => $result->wedOpen,
                  'wed_start_time' => $result->wedSt,
                  'wed_end_time' => $result->wedEn,
                  'thu_open' => $result->thuOpen,
                  'thu_start_time' => $result->thuSt,
                  'thu_end_time' => $result->thuEn,
                  'fri_open' => $result->friOpen,
                  'fri_start_time' => $result->friSt,
                  'fri_end_time' => $result->friEn,
                  'sat_open' => $result->satOpen,
                  'sat_start_time' => $result->satSt,
                  'sat_end_time' => $result->satEn,
                );
            }
            
            DB::table('employees')->where('id', $result->id)->update($data);
            //$schedule_updated = DB::table('schedules')->where('emp_id',$result->id)->update($result->id);
            $schedule_updated = DB::table('schedules')->where('emp_id',$result->id)->update($schedule);
            $response = [
                'status'=> 301,
                'data' => $data,
            ];
        
        }
        
        
        return response()->json($response);
    }
    
    public function get_barber_info(){
        $this->cors();
        $barber_id = request()->segment(2);
        $info = DB::table('employees')->where('id',$barber_id)->first();
        if($info){
            $response = [
                'status'=> 200,
                'info' => $info,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function change_barber_pass(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        
        $pass_check = DB::table('employees')->where('password',$result->oldPass)->select('password')->first();
        
        if($pass_check){
            
            if(DB::table('employees')->where('id', $result->id)->update(['password' => $result->newPass])){
                $response = [
                    'status'=> 200
                ];
            }else{
                $response = [
                    'status'=> 400
                ];
            }
        }else{
            $response = [
                'status'=> 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function get_barber_booking(Request $request){
        $this->cors();
        $barber_id = request()->segment(2);
        $date = $request->date;
        $current_date = date("Y-m-d h:i:s");
        //DB::enableQueryLog();
        $data = DB::table('bookings')
        ->join('users', 'users.id', '=', 'bookings.customer_id')
        ->where('bookings.employee_id',$barber_id)
        ->where('bookings.is_confirmed',0)
        ->where('bookings.barber_confirmed',0)
        ->where('bookings.date_check','>',$current_date)
        ->where('bookings.date','>', $date)
        ->select('bookings.*','users.first_name','users.last_name')->get();
     
        
     //   DB::enableQueryLog();
        $confirmed = DB::table('bookings')
        ->join('users', 'users.id', '=', 'bookings.customer_id')
        ->where('bookings.employee_id',$barber_id)
        ->where('bookings.is_confirmed',0)
        ->where('bookings.barber_confirmed',1)
        ->where('bookings.date_check','>',$current_date)
        ->where('bookings.date','<=', $date)
        ->select('bookings.*','users.first_name','users.last_name')->get();
         //  $query = DB::getQueryLog();
       // $lastQuery = end($query);
       // print_r($lastQuery);
        $complete = DB::table('bookings')
        ->join('users', 'users.id', '=', 'bookings.customer_id')
        ->where('bookings.employee_id',$barber_id)
        ->where('bookings.is_confirmed',1)
        ->where('bookings.barber_confirmed',1)
        ->where('bookings.date_check','>',$current_date)
        ->where('bookings.date','<=', $date)
        ->select('bookings.*','users.first_name','users.last_name')->get();     
        $cancel = DB::table('bookings')
        ->join('users', 'users.id', '=', 'bookings.customer_id')
        ->where('bookings.employee_id',$barber_id)
        ->where('bookings.is_confirmed',0)
        ->where('bookings.barber_confirmed',0)
        ->where('bookings.date_check','<',$current_date)
        ->where('bookings.date','<', $date)
        ->select('bookings.*','users.first_name','users.last_name')->get();       
                
                
                
                            
                            
        if($data || $confirmed){
            $response = [
                'status'=> 200,
                'data' => $data,
                'confirmed' => $confirmed,
                'complete' => $complete,
                'canceled'=>$cancel
                
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function barber_booking_confirm(Request $request){
        $this->cors();
         echo $bookingId = $request->bookingId;
         DB::table('bookings')->where('id',$bookingId)->update(['barber_confirmed' => 1]);
            $response = [ 'status'=> 200];
       
        return response()->json($response);
    }
    
    public function barber_booking_cancel(Request $request){
        $this->cors();
        $bookingId = $request->bookingId;
        if(DB::table('bookings')->where('id',$bookingId)->update(['barber_confirmed' => 2])){
            $response = [
                'status'=> 200
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    // ==========================================================================================
    // For Clients
    public function get_my_homeinfo(Request $request){
        $this->cors();
        $stylist_offset = $request->stylist_offset;
        $client_id = request()->segment(2);
        $stylists = DB::table('fav_barbers')
                ->join('employees', 'employees.id', '=', 'fav_barbers.emp_id')
                ->select('employees.*')
                ->where('fav_barbers.client_id',$client_id)
                ->skip(4*$stylist_offset)->take(4)
                ->get();
        
        $gallery = DB::table('fav_styles')
                        ->select('gallery.*')
                        ->join('gallery','fav_styles.style_id','=','gallery.id')
                        ->where('client_id',$client_id)
                        ->skip(4*$stylist_offset)->take(4)
                        ->get();
        
        
        
        
        if($stylists || $gallery){
            $response = [
                'status'=> 200,
                'stylist' => $stylists,
                'gallery' => $gallery,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_offset_wise_stylist(Request $request){
        $this->cors();
        $stylist_offset = $request->stylist_offset;
        $client_id = request()->segment(2);
        $stylists = DB::table('fav_barbers')
                ->join('employees', 'employees.id', '=', 'fav_barbers.emp_id')
                ->select('employees.*')
                ->where('fav_barbers.client_id',$client_id)
                ->skip(4*$stylist_offset)->take(4)
                ->get();
        if($stylists){
            $response = [
                'status'=> 200,
                'stylist' => $stylists
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_offset_wise_styles(Request $request){
        $this->cors();
        $offset = $request->styles_offset;
        $client_id = request()->segment(2);
        
        
        $gallery = DB::table('fav_styles')
                        ->select('gallery.*','fav_styles.id as fav_id')
                        ->join('gallery','fav_styles.style_id','=','gallery.id')
                        ->where('client_id',$client_id)
                        ->skip(4*$offset)
                        ->take(4)
                        ->get();
                
                
        if($gallery){
            $response = [
                'status'=> 200,
                'gallery' => $gallery
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_barber_profile(){
        $this->cors();
        $barber_id = request()->segment(2);
        $client_id = request()->segment(3);
        $info = DB::table('employees')
                ->join('schedules', 'employees.id', '=', 'schedules.emp_id')
                ->select('employees.*','schedules.*')
                ->where('employees.id',$barber_id)
                ->first();
                
        $services = DB::table('services')
                ->where('emp_id',$barber_id)
                ->get();
                
        $reviews = DB::table('reviews')
                ->join('users', 'users.id', '=', 'reviews.client_id')
                ->where('reviews.emp_id',$barber_id)
                ->select('reviews.star','reviews.message','reviews.created_at','users.first_name','users.last_name','users.image')
                ->get();
        $barbers = DB::table('employees')
                ->join('saloon_wise_barber','employees.id','saloon_wise_barber.barber_id')
                ->select('employees.*')
                ->where('saloon_wise_barber.saloon_id',$barber_id)
                ->take(4)
                ->get();
                
        $favs = DB::table('fav_barbers')->where('client_id',$client_id)->get();
        
        $gallery = DB::table('gallery')->leftJoin('fav_styles','gallery.id', '=', 'fav_styles.style_id')
                                        ->select('gallery.*','fav_styles.id as fav_id')
                                        ->where('emp_id',$barber_id)->orderBy('id', 'asc')->take(4)->get();
                
        if($info || $services || $reviews || $favs || $gallery){
            $response = [
                'status'=> 200,
                'info' => $info,
                'service' => $services,
                'reviews' => $reviews,
                'favs' => $favs,
                'gallery' => $gallery,
                'barbers' => $barbers
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_booking_info_id(){
           $this->cors();
            $barber_id = request()->segment(2);
             $info = DB::table('employees')
                ->join('schedules', 'employees.id', '=', 'schedules.emp_id')
                ->select('employees.*','schedules.*')
                ->where('employees.id',$barber_id)
                ->first();
                $services = DB::table('services')
                ->where('emp_id',$barber_id)
                ->get();  
        if($info){
            $response = [
                'status'=> 200,
                'info' => $info,
                 'service' => $services,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_booking_info(){
        $this->cors();
            $barber_id = request()->segment(2);
        $client_id = request()->segment(3);
        
        $info = DB::table('employees')
                ->join('schedules', 'employees.id', '=', 'schedules.emp_id')
                ->select('employees.*','schedules.*')
                ->where('employees.id',$barber_id)
                ->first();
        
        $services = DB::table('services')
                ->where('emp_id',$barber_id)
                ->get();
                
        //$gallery = DB::table('gallery')->where('emp_id',$barber_id)->take(4)->get();
        $gallery = DB::table('fav_styles')
                        ->select('gallery.*','fav_styles.id as fav_id')
                        ->join('gallery','fav_styles.style_id','=','gallery.id')
                        ->where('client_id',$client_id)
                        ->take(4)
                        ->get();
                
        if($info || $services || $gallery){
            $response = [
                'status'=> 200,
                'info' => $info,
                'service' => $services,
                'gallery' => $gallery,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
        
        
    }
    
    public function add_review(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        
        //$review = DB::table('employees')->where('id',$result->emp_id)->select('review_count','star')->first();
        //return response()->json($review);
        $data = array(
            'client_id' => $result->client_id,
            'emp_id' => $result->emp_id,
            'star' => $result->star,
            'star' => $result->star,
            'message' => $result->message,
            'booking_id' => $result->booking_id,
        );
        if(DB::table('reviews')->insert($data) && DB::table('bookings')->where('id', $result->booking_id)->update(['is_reviewed' => 1])){
            $response = [
                'status'=> 200,
                'data' => $result,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_my_favs(Request $request){
        $this->cors();
        $client_id = request()->segment(2);
        $offset = $request->offset;
        
        $stylists = DB::table('fav_barbers')
                ->join('employees', 'employees.id', '=', 'fav_barbers.emp_id')
                ->select('employees.*','fav_barbers.id as item_id')
                ->where('fav_barbers.client_id',$client_id)
                ->skip(4*$offset)
                ->take(4)
                ->get();
        
        // $gallery = DB::table('client_gallery')
        //         ->where('client_id',$client_id)
        //         ->skip(4*$offset)
        //         ->take(4)
        //         ->get();
                
        $gallery = DB::table('fav_styles')
                        ->select('gallery.*','fav_styles.id as fav_id')
                        ->join('gallery','fav_styles.style_id','=','gallery.id')
                        ->where('client_id',$client_id)
                        ->skip(4*$offset)
                        ->take(4)
                        ->get();
                
        if($stylists){
            $response = [
                'status'=> 200,
                'data' => $stylists,
                'gallery' => $gallery,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_my_all_fav_stylist(){
        $this->cors();
        $client_id = request()->segment(2);
        
        $stylists = DB::table('fav_barbers')
                ->join('employees', 'employees.id', '=', 'fav_barbers.emp_id')
                ->select('employees.*','fav_barbers.id as item_id')
                ->where('fav_barbers.client_id',$client_id)
                ->get();
        if($stylists){
            $response = [
                'status'=> 200,
                'data' => $stylists,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_my_all_fav_styles(){
        $this->cors();
        $client_id = request()->segment(2);
        
        $styles = DB::table('fav_styles')
                ->join('gallery', 'gallery.id', '=', 'fav_styles.style_id')
                ->select('gallery.*','fav_styles.id as fav_id')
                ->where('fav_styles.client_id',$client_id)
                ->get();
        if($styles){
            $response = [
                'status'=> 200,
                'data' => $styles,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function remove_my_favs(){
        $this->cors();
        $id = request()->segment(2);
        
        
        if(DB::table('fav_barbers')->where('id',$id)->delete()){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function remove_clients_gallery(){
        $this->cors();
        $id = request()->segment(2);
        
        
        if(DB::table('fav_styles')->where('id',$id)->delete()){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function remove_barbers_gallery(){
        $this->cors();
        $id = request()->segment(2);
        
        
        if(DB::table('gallery')->where('id',$id)->delete()){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
    
    public function update_barber_info(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        $emp_id = $result->emp_id;
        $info = array(
            'shop_name' => $result->shop_name,
            'addr1' => $result->addr1,
            'addr2' => $result->addr2,
            'city' => $result->city,
            'state' => $result->state,
            'post_code' => $result->post_code,
            'country' => $result->country,
        );
        
        $schedule = array(
            'sun_open' => $result->sunOpen,
            'sun_start_time' => $result->sunSt,
            'sun_end_time' => $result->sunEn,
            'mon_open' => $result->monOpen,
            'mon_start_time' => $result->monSt,
            'mon_end_time' => $result->monEn,
            'tue_open' => $result->tueOpen,
            'tue_start_time' => $result->tueSt,
            'tue_end_time' => $result->tueEn,
            'wed_open' => $result->wedOpen,
            'wed_start_time' => $result->wedSt,
            'wed_end_time' => $result->wedEn,
            'thu_open' => $result->thuOpen,
            'thu_start_time' => $result->thuSt,
            'thu_end_time' => $result->thuEn,
            'fri_open' => $result->friOpen,
            'fri_start_time' => $result->friSt,
            'fri_end_time' => $result->friEn,
            'sat_open' => $result->satOpen,
            'sat_start_time' => $result->satSt,
            'sat_end_time' => $result->satEn,
        );
        
        $info_updated = DB::table('employees')->where('id',$emp_id)->update($info);
        $schedule_updated = DB::table('schedules')->where('emp_id',$emp_id)->update($schedule);
        if($info_updated || $schedule_updated){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500,
            ];
        }
        return response()->json($response);
    }
    
    public function make_fav(){
        $this->cors();
        $barber_id = request()->segment(2);
        $client_id = request()->segment(3);
        $data = array(
            'client_id' => $client_id,
            'emp_id' => $barber_id
        );
        if(DB::table('fav_barbers')->insert($data)){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500,
            ];
        }
        return response()->json($response);
    }
    
    public function rmv_fav(){
        $this->cors();
        $barber_id = request()->segment(2);
        $client_id = request()->segment(3);
        if(DB::table('fav_barbers')->where('client_id',$client_id)->where('emp_id',$barber_id)->delete()){
            $response = [
                'status'=> 200,
            ];
        }else{
            $response = [
                'status'=> 500,
            ];
        }
        return response()->json($response);
    }
    
    public function find_barber(Request $request){
        $this->cors();
        $barber = $request->get('barber');
        $stylist = $request->get('stylist');
        $salon = $request->get('salon');
        $zip = $request->get('zip');
        
        $cond='';
        
        if($barber == 'true' && isset($zip) && $zip !='' ){
          $cond .= '(is_stylist = 0 AND post_code='.$zip.')';
        }elseif($barber == 'true' && !isset($zip)){
         $cond .= '(is_stylist = 0)';   
        }
        
        if($cond == ''){
       
        if($stylist == 'true' && isset($zip) && $zip !='' ){
        $cond .= '(is_stylist = 1 AND post_code='.$zip.')';
        }elseif($stylist == 'true' && !isset($zip)){
        $cond .= 'OR (is_stylist = 1)';   
        }
            
        }else{
        if($stylist == 'true' && isset($zip) && $zip !='' ){
        $cond .= 'OR (is_stylist = 1 AND post_code='.$zip.')';
        }elseif($stylist == 'true' && !isset($zip)){
        $cond .= 'OR (is_stylist = 1)';   
        }     
        }
        if($cond == ''){
           
        if($salon == 'true' && isset($zip) && $zip !='' ){
        $cond .= '(is_saloon=1 AND post_code='.$zip.') OR (is_saloon=2 AND post_code='.$zip.')';
        }elseif($salon == 'true' && !isset($zip)){
        $cond .= '(is_saloon=1)  OR (is_saloon=2)';   
        }
            
        }else{
            
        if($salon == 'true' && isset($zip) && $zip !='' ){
        $cond .= 'OR (is_saloon=1 AND post_code='.$zip.') OR (is_saloon=2 AND post_code='.$zip.')';
        }elseif($salon == 'true' && !isset($zip)){
        $cond .= 'OR (is_saloon=1) OR (is_saloon=2) ';   
        }     
        }  
            
       // echo  $cond;die();
      //  $all = Employee::where($cond)->get();
        
             // $all = DB::table('employees')
             //  ->select(DB::raw('SELECT * FROM `employees` where '.$cond))
             //        ->get();
            $results = DB::select( DB::raw("SELECT * FROM `employees` where ".$cond) );
              if(count($results) > 0){
              $response = array(
                  'status' => 200,
                 'data' => $results
              );
          }else{
               $response = array(
                     'status' => 500
                );
            }
  
        
        
    //   if($barber == true){
    //   $cond .= 'is_stylist = 0';
    // }
        
        
        //$all = Employee::all()->toArray();
        
        //echo '<pre>';
        //print_r($request->all());
        //die();
        
        
        
        // if($barber != 'null' && $stylist == 'null' && $zip == 'null'){
        //     $data = DB::table('employees')->where('is_stylist','0')->get();
        //     if(count($data) > 0){
        //         $response = array(
        //             'status' => 200,
        //             'data' => $data
        //         );
        //     }else{
        //         $response = array(
        //             'status' => 500
        //         );
        //     }
            
        // }else if($barber != 'null' && $stylist == 'null' && $zip != 'null'){
        //     $data = DB::table('employees')->where('is_stylist','0')->where('post_code',$zip)->get();
        //     if(count($data) > 0){
        //         $response = array(
        //             'status' => 200,
        //             'data' => $data
        //         );
        //     }else{
        //         $response = array(
        //             'status' => 500
        //         );
        //     }
        // }else if($barber == 'null' && $stylist != 'null' && $zip == 'null'){
        //     $data = DB::table('employees')->where('is_stylist','1')->get();
        //     if(count($data) > 0){
        //         $response = array(
        //             'status' => 200,
        //             'data' => $data
        //         );
        //     }else{
        //         $response = array(
        //             'status' => 500
        //         );
        //     }
        // }
        // else if($barber == 'null' && $stylist != 'null' && $zip != 'null'){
        //     $data = DB::table('employees')->where('is_stylist','1')->where('post_code',$zip)->get();
        //     if(count($data) >0 ){
        //         $response = array(
        //             'status' => 200,
        //             'data' => $data
        //         );
        //     }else{
        //         $response = array(
        //             'status' => 500
        //         );
        //     }
        // }else if($barber != 'null' && $stylist != 'null' && $zip == 'null'){
        //     $data = DB::table('employees')->get();
        //     if(count($data) >0){
        //         $response = array(
        //             'status' => 200,
        //             'data' => $data
        //         );
        //     }else{
        //         $response = array(
        //             'status' => 500
        //         );
        //     }
        // }else{
        //     $data = DB::table('employees')->where('post_code',$zip)->get();
        //     if(count($data) >0){
        //         $response = array(
        //             'status' => 200,
        //             'data' => $data
        //         );
        //     }else{
        //         $response = array(
        //             'status' => 500
        //         );
        //     }
        // }
        
        return response()->json($response);
    }
    
    public function make_fav_style(){
        $this->cors();
        $style_id = request()->segment(2);
        $client_id = request()->segment(3);
        
        $data = array(
            'client_id' => $client_id,
            'style_id' => $style_id,
        );
        if($fav_id = DB::table('fav_styles')->insertGetId($data)){
            $response = array(
                'status' => 200,
                'fav_id' => $fav_id
            );
        }else{
            $response = array(
                'status' => 500
            );
        }
        return response()->json($response);
    }
    
    public function rmv_fav_style(){
        $this->cors();
        $fav_id = request()->segment(2);
        if(DB::table('fav_styles')->where('id',$fav_id)->delete()){
            $response = array(
                'status' => 200
            );
        }else{
            $response = array(
                'status' => 500
            );
        }
        return response()->json($fav_id);
    }
    
    public function get_booking_schedule(Request $request){
        $this->cors();
        $date =  date("Y-m-d", strtotime($request->date)); 
        $barber_id = $request->barber_id;
        $day = $request->day;
        $diff = $request->diff;
        // $date =  '2020-02-12'; 
        // $barber_id = 5;
        // $day = 3;
        switch($day){
            case 0:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('sun_start_time as start_time','sun_end_time as end_time')->first();
                break;
            case 1:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('mon_start_time as start_time','mon_end_time as end_time')->first();
                break;
            case 2:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('tue_start_time as start_time','tue_end_time as end_time')->first();
                break;
            case 3:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('wed_start_time as start_time','wed_end_time as end_time')->first();
                break;
            case 4:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('thu_start_time as start_time','thu_end_time as end_time')->first();
                break;
            case 5:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('fri_start_time as start_time','fri_end_time as end_time')->first();
                break;
            case 6:
                $schedule = DB::table('schedules')->where('emp_id',$barber_id)->select('sat_start_time as start_time','sat_end_time as end_time')->first();
                break;
        }
        
        $bookings = DB::table('bookings')->where('employee_id',$barber_id)->where('date',$date)->get();
        
        date_default_timezone_set("Asia/Dhaka");
        $st = date(strtotime($schedule->start_time));
        $en = date(strtotime($schedule->end_time));
        
        $ar = [];
        $i = $st;
        $j = $i;
        
        while($i < $en){
            $object = new\stdClass();
            $object->is_booked = 'no';
            $object->s_time = date('H:i', $i);
            $object->e_time = date('H:i',$j + strtotime("+".$diff, strtotime($j)) - strtotime("1 minute", strtotime($j)));
            array_push($ar,$object);
            $i += strtotime("+".$diff, strtotime($i));
            $j += strtotime("+".$diff, strtotime($j));
        }
        
        //$rr = $this->modify_slot($ar,$bookings,0);
        
        
            for($i = 0; $i < count($ar); $i++){
                for($j = 0; $j < count($bookings); $j++){
                    //echo date('H:i', strtotime($bookings[$j]->schedule_start)).' '.$ar[$i]->s_time.' '.$ar[$i]->e_time.' '.date('H:i', strtotime($bookings[$j]->schedule_end)).'<br>';
                    // if(date('H:i', strtotime($bookings[$j]->schedule_start)) >= $ar[$i]->s_time && date('H:i', strtotime($bookings[$j]->schedule_start)) <= $ar[$i]->e_time){
                    //     $ar[$i]->is_booked = 'yes';
                    // }else if(date('H:i', strtotime($bookings[$j]->schedule_start)) <= $ar[$i]->s_time && date('H:i', strtotime($bookings[$j]->schedule_end)) >= $ar[$i]->s_time && date('H:i', strtotime($bookings[$j]->schedule_end)) <= $ar[$i]->e_time){
                    //     $ar[$i]->is_booked = 'yes';
                    // }else if(date('H:i', strtotime($bookings[$j]->schedule_end)) >= $ar[$i]->s_time && date('H:i', strtotime($bookings[$j]->schedule_end)) <= $ar[$i]->e_time){
                    //     $ar[$i]->is_booked = 'yes';
                    // }
                    
                    
                    // if($ar[$i]->s_time >= date('H:i', strtotime($bookings[$j]->schedule_start)) && $ar[$i]->e_time <= date('H:i', strtotime($bookings[$j]->schedule_end))){
                    //     $ar[$i]->is_booked = 'yes';
                    // }
                    
                    
                    // if($ar[$i]->s_time >= date('H:i', strtotime($bookings[$j]->schedule_start)) && $ar[$i]->s_time <= date('H:i', strtotime($bookings[$j]->schedule_end))){
                    //     $ar[$i]->is_booked = 'yes';
                    // }else if($ar[$i]->e_time >= date('H:i', strtotime($bookings[$j]->schedule_start)) && $ar[$i]->e_time <= date('H:i', strtotime($bookings[$j]->schedule_end))){
                    //     $ar[$i]->is_booked = 'yes';
                    // }
                    
                    
                    
                    
                    if($ar[$i]->s_time >= date('H:i', strtotime($bookings[$j]->schedule_start)) && $ar[$i]->s_time <= date('H:i', strtotime($bookings[$j]->schedule_end))){
                        $ar[$i]->is_booked = 'yes';
                    }else if($ar[$i]->e_time >= date('H:i', strtotime($bookings[$j]->schedule_start)) && $ar[$i]->e_time <= date('H:i', strtotime($bookings[$j]->schedule_end))){
                        $ar[$i]->is_booked = 'yes';
                    }else if($ar[$i]->s_time <= date('H:i', strtotime($bookings[$j]->schedule_start)) && $ar[$i]->e_time >= date('H:i', strtotime($bookings[$j]->schedule_end))){
                        $ar[$i]->is_booked = 'yes';
                    }
                }
            }
            
            
            $response = [
                'status' => 200,
                'slots' => $ar
            ];
        
            return response()->json($response);
    }
    
    public function make_booking(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        
        $services = $result->services;
        
        $data = array(
            'customer_id' => $result->client_id,
            'employee_id' => $result->emp_id,
            'schedule_start' => $result->start_time,
            'schedule_end' => $result->end_time,
            'total_price' => $result->total_price,
            'date' => $result->date,
            'barber_confirmed'=>$result->barber_confirmed,
            'date_check' => $result->date_check,
        );
        
        $id = DB::table('bookings')->insertGetId($data);
        for($i = 0; $i < count($services); $i++){
            $res = DB::table('services')->where('id',$services[$i])->first();
            $dd = array(
                'booking_id' => $id,
                'service_name' => $res->service_name,
                'duration' => $res->duration,
                'price' => $res->price,
                'description' => $res->description,
            );
            DB::table('booking_details')->insert($dd);
        }
        if($id){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
    }
    
    
    public function get_my_booking(Request $request){
        $this->cors();
        $id = $request->id;
        $current_date = date("Y-m-d h:i:s");
        
        $upcomming = DB::table('bookings')
                     //->select(DB::raw("concat(date,'',substr(schedule_start,11,8)) AS XYZ"),'id')
                     ->where('customer_id', $id)
                     ->where('is_confirmed', 0)
                     ->where('date_check', '>', $current_date)
                     ->get();
        $past = DB::table('bookings')
                     //->select(DB::raw("concat(date,'',substr(schedule_start,11,8)) AS XYZ"),'id')
                     ->where('customer_id', $id)
                     ->where('is_confirmed', 1)
                     ->where('is_reviewed', 0)
                     ->where('date_check', '<', $current_date)
                     ->get();
        
        for($i = 0; $i < count($upcomming); $i++){
            $upcomming[$i]->services = DB::table('booking_details')->where('booking_id',$upcomming[$i]->id)->get();
            $upcomming[$i]->barber_info = DB::table('employees')->where('id',$upcomming[$i]->employee_id)->first();
        }
        
        for($i = 0; $i < count($past); $i++){
            $past[$i]->services = DB::table('booking_details')->where('booking_id',$past[$i]->id)->get();
            $past[$i]->barber_info = DB::table('employees')->where('id',$past[$i]->employee_id)->first();
        }
        
        if($past || $upcomming){
            $response = [
                'status' => 200,
                'upcoming' => $upcomming,
                'past' => $past,
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        
        return response()->json($response);
        
    }
    
    public function confirm_booking(Request $request){
        $this->cors();
        $booking_id = $request->booking_id;
        $stts = DB::table('bookings')->where('id', $booking_id)->update(['is_confirmed' => 1]);
        
        if($stts){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
    }
    
    public function cancel_booking(Request $request){
        $this->cors();
        $booking_id = $request->booking_id;
        $stts = DB::table('bookings')->where('id', $booking_id)->delete();
        
        if($stts){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
    }
    
    public function forget_user(Request $request){
        $this->cors();
        
        $user_email = DB::table('users')->where('email',$request->email)->select('email','username')->first();
        $user_username = DB::table('users')->where('username',$request->email)->select('email','username')->first();
        
        $barber_email = DB::table('employees')->where('email',$request->email)->select('email','username')->first();
        $barber_username = DB::table('employees')->where('username',$request->email)->select('email','username')->first();
        
        $msg = 'Your password reset code is: ';
        
        if($user_email || $user_username){
            if($user_email){
                $rand_num = rand(1000,9999);
                if(DB::table('users')->where('username',$user_email->username)->update(['pass_reset_code' => $rand_num])){
                    mail($user_email->email,"Password Reset",$msg.$rand_num);
                    $response = [
                        'status' => 200,
                        'info' => $user_email,
                        'code' => $rand_num,
                        'type' => 'client'
                    ];
                }else{
                    $response = [
                        'status' => 500
                    ];
                }
                
                
            }
            if($user_username){
                $rand_num = rand(1000,9999);
                if(DB::table('users')->where('username',$user_username->username)->update(['pass_reset_code' => $rand_num])){
                    mail($user_username->email,"Password Reset",$msg.$rand_num);
                    $response = [
                        'status' => 200,
                        'info' => $user_username,
                        'code' => $rand_num,
                        'type' => 'client'
                    ];
                }else{
                    $response = [
                        'status' => 500
                    ];
                }
                
                
            }
            
        }else if($barber_email || $barber_username){
            if($barber_email){
                $rand_num = rand(1000,9999);
                if(DB::table('employees')->where('username',$barber_email->username)->update(['pass_reset_code' => $rand_num])){
                    mail($barber_email->email,"Password Reset",$msg.$rand_num);
                    $response = [
                        'status' => 200,
                        'info' => $barber_email,
                        'code' => $rand_num,
                        'type' => 'barber'
                    ];
                }else{
                    $response = [
                        'status' => 500
                    ];
                }
                
                
            }
            
            if($barber_username){
                $rand_num = rand(1000,9999);
                if(DB::table('employees')->where('username',$barber_username->username)->update(['pass_reset_code' => $rand_num])){
                    mail($barber_username->email,"Password Reset",$msg.$rand_num);
                    $response = [
                        'status' => 200,
                        'info' => $barber_username,
                        'code' => $rand_num,
                        'type' => 'barber'
                    ];
                }else{
                    $response = [
                        'status' => 500
                    ];
                }
                
                
            }
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
    }
    
    public function check_user_reset_code(Request $request){
        $this->cors();
        
        if($request->type == 'client'){
            $res = DB::table('users')->where('username',$request->username)->where('pass_reset_code',$request->code)->first();
            if($res){
                $response = [
                    'status' => 200
                ];
            }else{
                $response = [
                    'status' => 500
                ];
            }
        }else{
            $res = DB::table('employees')->where('username',$request->username)->where('pass_reset_code',$request->code)->first();
            if($res){
                $response = [
                    'status' => 200
                ];
            }else{
                $response = [
                    'status' => 500
                ];
            }
        }
        
        return response()->json($response);
    }
    
    public function reset_forgotten_password(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        
        if($result->type == 'client'){
            $pass_check = DB::table('users')->where('username',$result->username)
                                            ->where('password',$result->password)->first();
            if($pass_check){
                $response = [
                    'status' => 200
                ];
            }else{
                if(DB::table('users')->where('username', $result->username)->update(['password' => $result->password])){
                $response = [
                    'status' => 200
                ];
                }else{
                    $response = [
                        'status' => 500
                    ];
                }
            }
            
        }
        
        if($result->type == 'barber'){
            $pass_check = DB::table('employees')->where('username',$result->username)
                                            ->where('password',$result->password)->first();
            if($pass_check){
                $response = [
                    'status' => 200
                ];
            }else{
                if(DB::table('employees')->where('username', $result->username)->update(['password' => $result->password])){
                $response = [
                    'status' => 200
                ];
                }else{
                    $response = [
                        'status' => 500
                    ];
                }
            }
        }
        return response()->json($response);
    }
    
    
    //========================  Countries =========================
    public function get_countries(){
        $this->cors();
        $res = DB::table('countries')->get();
        if($res){
            $response = [
                'status' => 200,
                'countries' => $res
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
    }
    
    public function get_states(Request $request){
        $this->cors();
        $res = DB::table('states')->where('country_id',$request->countryId)->get();
        if($res){
            $response = [
                'status' => 200,
                'states' => $res
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
        
    }
    
    public function get_place(Request $request){
        $this->cors();
        $name = $request->name;
        //$response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".$name."&components=country%3AAUS&key=AIzaSyCWVwtYsL7a8pxq5V2xigxvgtDG25KOwM4"), true);
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".$name."&key=AIzaSyCWVwtYsL7a8pxq5V2xigxvgtDG25KOwM4"), true);
        for($i=0;$i<count($response['predictions']);$i++){
            $place_id = $response['predictions'][$i]['place_id'];
            $description = $response['predictions'][$i]['description'];
            $response1 = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=".$place_id."&fields=name,geometry&key=AIzaSyCWVwtYsL7a8pxq5V2xigxvgtDG25KOwM4"), true);
            $place = array(
                'place_id'=> $place_id,
                 'latitude'=> $response1['result']['geometry']['location']['lat'],
                'longitude'=> $response1['result']['geometry']['location']['lng'],
                'description'=> $description
            );
            $places[] = $place;
        }
        if(empty($response['predictions'])){
            $response = array();
        }
        else{
            $response = $places;
        }
        return response()->json($response);
    }
    
    public function get_barber_with_location(Request $request){
        $this->cors();
        $lat = $request->lat;
        $lng = $request->lng;
        
        // $barbers = DB::table('employees')
        //     ->selectRaw('*,6371 * acos(cos(radians(?)) * cos(radians(lat)) 
        //                   * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat))) as distance',[$lat,$lng,$lat])
            
        //     ->havingRaw('distance <= 1')
        //     ->get();
        $ss = DB::statement("drop view if exists empl");
        $view = DB::statement("CREATE VIEW empl AS SELECT *, (6371 * acos(cos(radians(".$lat.")) * cos(radians(lat)) 
                           * cos(radians(lng) - radians(".$lng.")) + sin(radians(".$lat.")) * sin(radians(lat)))) AS distance FROM employees");
        
        $barbers = DB::table('empl')
                    ->where('distance','<=',2)
                    ->get();



        if($barbers){
            $response = [
                'status' => 200,
                'data' => $barbers
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function search_barber_with_name(Request $request){
        $this->cors();
        $name = $request->name;
        $userId = $request->userId;
        
        $result = DB::table('employees')
                    ->leftJoin('fav_barbers', 'fav_barbers.emp_id', '=', 'employees.id')
                    ->select('employees.*','fav_barbers.client_id','fav_barbers.emp_id','fav_barbers.id as fav_id')
                    ->where('first_name', 'like', '%'.$name.'%')
                    ->orWhere('last_name', 'like', '%'.$name.'%')
                    ->get();
        if($result){
            $response = [
                'status' => 200,
                'data' => $result
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
            
            
        return response()->json($response);
    }
    
    public function edit_service(){
        $this->cors();
        $barber_id = request()->segment(2);
        
        $result = DB::table('services')->where('id',$barber_id)->first();
        
        if($result){
            $response = [
                'status' => 200,
                'data' => $result
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function get_offset_gallery(Request $request){
        $this->cors();
        $barber_id = request()->segment(2);
        $offset = $request->offset;
        
        $gallery = DB::table('gallery')->where('emp_id',$barber_id)->skip(4*$offset)->take(4)->get();
        
        
        if($gallery){
            $response = [
                'status' => 200,
                'gallery' => $gallery
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function get_saloon_wise_barber(){
        $this->cors();
        $saloon_id = request()->segment(2);
        
        $barbers = DB::table('saloon_wise_barber')
                    ->join('employees','employees.id','=','saloon_wise_barber.barber_id')
                    ->select('employees.*','saloon_wise_barber.id as fav_id')
                    ->where('saloon_wise_barber.saloon_id',$saloon_id)->get();
        
        
        if($barbers){
            $response = [
                'status' => 200,
                'barbers' => $barbers
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function get_remove_barber(){
        $this->cors();
        $id = request()->segment(2);
        
        
        if(DB::table('saloon_wise_barber')->where('id',$id)->delete()){
            $response = [
                'status' => 200,
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function get_salon_profile(){
        $this->cors();
        $id = request()->segment(2);
        
        $res = DB::table('employees')
                ->join('countries','countries.id','=','employees.country')
                ->join('states','states.id','=','employees.state')
                ->select('employees.*','countries.name as c_name','states.name as s_name')
                ->where('employees.id',$id)->first();
                
        $schedule = DB::table('schedules')->where('emp_id',$id)->first();
        
        if($res){
            $response = [
                'status' => 200,
                'data' => $res,
                'schedule' => $schedule
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }  
        
        return response()->json($response);
    }
    
    public function invite_with_email(){
            $this->cors();
            $data = file_get_contents("php://input");
            $result = json_decode($data);
            $from ="info@apptest.com";
            $salonInfo = Employee::where('id',$result->salonId)->get()->toArray();  
            $message = '<html><body  bgcolor="#ed508b"  style="backgorund:#ed508b;width:100%;text-align:center; padding:50px; 10px">';
            $message .= '<div style="backgorund-color:#ed508b;text-align:center;"><img src="http://aptest.therssoftware.com/Saloon/assets/logo.png" width="150px">';
            $message .= '<h1 style="color:#ed508b;">JOIN US <br> '.$salonInfo[0]['shop_name'].'</h1>';
            $message .= '<p style="backgorund:#ed508b;color:#ed508b;font-size:18px;">To Join with us please click the link <a href="http://aptest.therssoftware.com/Saloon/">JOIN</a></p>';
            $message .= '<p style="color:#ed508b;font-size:18px;">Thank You.</p>';
            $message .= '</div></body></html>';
      
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
           
            
 
    
        if(mail($result->email,"Password Reset",$message,$headers)){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        
        return response()->json($response);
    }
    
    public function get_offset_wise_work(Request $request){
        $this->cors();
        $barber_id = $request->barberId;
        $offset = $request->offset;
        $gallery = DB::table('gallery')
                        ->where('emp_id',$barber_id)
                        ->orderBy('id', 'asc')
                        ->skip(4*$offset)->take(4)
                        ->get();
                        
        if($gallery){
            $response = [
                'status' => 200,
                'gallery' => $gallery
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    public function add_payment(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
        
        $id = $result->id;
        
        $data = array(
          'name' => $result->name,  
          'user_id' => $result->user_id,  
          'card_no' => $result->card_no,  
          'expire_date' => date('Y-m-d',strtotime($result->expire_date)),  
          'cvc' => $result->cvc,  
          'zip' => $result->zip,  
        );
        
        if($id > 0){
            $succ = DB::table('payment_method')->where('id', $id)->update($data);
        }else{
            $succ = DB::table('payment_method')->insert($data);
        }
        
        if($succ){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
        return response()->json($response);
    }
    
    
    public function get_payment(Request $request){
        $this->cors();
        $id = $request->id;
        
        $data = DB::table('payment_method')->where('user_id',$id)->first();
        
        if($data){
            $response = [
                'status' => 200,
                'data' => $data
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        
         return response()->json($response);
        
    }
    
    public function get_settings(){
        $this->cors();
        $data = DB::table('settings')->first();
        if(!empty($data)){
            $response = [
                'status' => 200,
                'data' => $data
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
      
        return response()->json($response);
    }
    
    //NEW API 
    

        public function searchUserByEmailOrPhn(Request $request){
        $this->cors();
        $user = User::where('email',$request->un)->get()->toArray();
        if(empty($user)){
        $user = User::where('phone',$request->un)->get()->toArray();
        }
      
       if(!empty($user)){
            $response = [
                'status' => 200,
                'data' => $user
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
      
        return response()->json($response);
    }
    
    public function subscribe_barber(){
        $this->cors();
        $data = file_get_contents("php://input");
        $result = json_decode($data);
    
        //$device_exist = DB::table('subscription_barber')->where('barber_id',$result->barber_id)->where('device_id',$result->device_id)->first();
      $device = Subscription_barber:: where(['barber_id'=>$result->barber_id,'device_id'=>$result->device_id])->get()->toArray();  
        
        if(empty($device)){
            $vers = new Subscription_barber;
            $vers->barber_id = $result->barber_id;
            $vers->device_id = $result->device_id;
            if($vers->save()){
                echo 123123;
            }else{
              echo 342423;   
            }
            
        }else{
          echo 6666;     
            
        }
        
        
        
       // echo '<pre>';
      // print_r($device);
        die();
        
        
        if($device_exist != null){
            $data = array(
                'barber_id' => $result->barber_id,
                'device_id' => $result->device_id
            );
            if(DB::table('subscription_barber')->insert($data)){
                $response = [
                    'status' => 200
                ];
            }else{
                $response = [
                    'status' => 500
                ];
            }
        }else{
            if(DB::table('subscription_barber')->where('barber_id', 1)->update(['device_id' => $result->device_id])){
                $response = [
                    'status' => 200
                ];
            }else{
                $response = [
                    'status' => 500
                ];
            }
        }
        
        return response()->json($response);
    }
    
    public function barber_get_wishlist(Request $request){
        $this->cors();
        $current_date = date("Y-m-d h:i:s"); // new
        $bookings = DB::table('bookings')
                ->join('users', 'users.id', '=', 'bookings.customer_id')
                ->select('users.first_name','users.last_name','users.addr1','users.addr2', 'bookings.*')
                ->where('bookings.employee_id',$request->barberId)
                ->where('date_check','>', $current_date) // new
                ->where('bookings.is_confirmed',1) // new
                ->where('bookings.barber_confirmed',0)->get();
        // new
        $past = DB::table('bookings')
                ->join('users', 'users.id', '=', 'bookings.customer_id')
                ->select('users.first_name','users.last_name','users.addr1','users.addr2', 'bookings.*')
                ->where('bookings.employee_id',$request->barberId)
                ->where('date_check','<', $current_date)->get();

                
        for($i = 0; $i < count($bookings); $i++){
            $bookings[$i]->services = DB::table('booking_details')->where('booking_id',$bookings[$i]->id)->get();
        }

        for($i = 0; $i < count($past); $i++){
            $past[$i]->services = DB::table('booking_details')->where('booking_id',$past[$i]->id)->get();
        }
        
        
        if($bookings || $past){
            $response = [
                'status' => 200,
                'bokings' => $bookings,
                'past' => $past
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }
        return response()->json($response);
    }

    //====================== Work in 30-03-2020 ============================

    public function waitlist_confirm(Request $request){
        $this->cors();
        $booking_id = $request->id;

        if(DB::table('bookings')->where('id',$booking_id)->update(['barber_confirmed' => 1])){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }

        return response()->json($response);
    }
    public function waitlist_cancel(Request $request){
        $this->cors();
        $booking_id = $request->id;

        if(DB::table('bookings')->where('id',$booking_id)->update(['barber_confirmed' => 2])){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }

        return response()->json($response);
    }
    public function waitlist_complete(Request $request){
        $this->cors();
        $booking_id = $request->id;

        if(DB::table('bookings')->where('id',$booking_id)->update(['barber_confirmed' => 3])){
            $response = [
                'status' => 200
            ];
        }else{
            $response = [
                'status' => 500
            ];
        }

        return response()->json($response);
    }


    public function salon_and_offset_wise_barber(Request $request){
        $this->cors();
        $offset = $request->offset;
        $salon_id = $request->salonId;
        $barbers = DB::table('saloon_wise_barber')
                ->join('employees', 'employees.id', '=', 'saloon_wise_barber.barber_id')
                ->select('employees.*')
                ->where('saloon_wise_barber.saloon_id',$salon_id)
                ->skip(4*$offset)->take(4)
                ->get();
        if($barbers){
            $response = [
                'status'=> 200,
                'barbers' => $barbers
            ];
        }else{
            $response = [
                'status'=> 500
            ];
        }
        return response()->json($response);
    }
}




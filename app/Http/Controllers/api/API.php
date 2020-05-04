<?php
//defined('BASEPATH') or exit('No direct script access allowed');

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
class API extends Controller
{
 public function getdata(){
     echo 4556;die();
 }



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
                     ->where('email',$result->email)
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
                     ->where('email',$result->email)
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

}

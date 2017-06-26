<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Input;
use Validator;
use Mail;
use DB;
use URL;
use verfifyUser;

class CustomAuth extends Controller
{
    public function register(){

      $data = array(
        'display' => Input::get('name')." ".Input::get('last_name'),
        'name' => empty(Input::get('name')) ? " " : Input::get('name'),
        'last_name' => empty(Input::get('last_name')) ? " " : Input::get('last_name'),
        'email' => Input::get('email'),
        'order_limit' => (Input::get('role') == 'customer') ? 5 : 500,
        'password' => bcrypt(Input::get('password')),
        'device_token' => Input::get('device_token'),
        'device_type' => Input::get('device_type'),
        'auth_token' => NULL,
        'role'=>Input::get('role'),
        'lat' => 0,
        'long' => 0,
        'verification_token' => md5(uniqid(rand(), true)),
        );

      $validator = Validator::make(Input::all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'=>'required',
            'device_token' => 'required',
            'device_type' => 'required',
        ]);

      if( $validator->fails() ){

        return json_encode($validator->errors(),JSON_NUMERIC_CHECK);

      }else{

        User::create([
            'display' => $data['name']." ".$data['last_name'],
            'name' => empty($data['name']) ? " " : $data['name'],
            'last_name' => empty($data['last_name']) ? " " : $data['last_name'],
            'email' => $data['email'],
            'order_limit' => ($data['role'] == 'customer') ? 5 : 500,
            'password' => $data['password'],
            'device_token' => $data['device_token'],
            'device_type' => $data['device_type'],
            'auth_token' => NULL,
            'roles'=>$data['role'],
            'image' => URL::to('/images/new-user-image-default.png'),
            'lat' => 0,
            'long' => 0,
            'partner_status' => ($data['role'] == 'partner') ? "free" : "-",
            'verified'=> 0,
            'verification_token' => $data['verification_token'],
        ]);


        Mail::send('emails.emailVerification', $data, function($message) {
         $message->to(Input::get('email'),'')->subject
            ('Confirm Email to Register');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
        });

        return json_encode(array("status" => "success","message" => "Registred Successfully"));

      }

    }

  public function login(){

    $email = Input::get("email");
    
    $password = Input::get("password");

    $device_type = Input::get("device_type");

    $device_token = Input::get("device_token");

    $role = Input::get("role");

    $remember = Input::get("remember");

    if( Auth::attempt([ "email" => $email,"password" => $password,"verified" => 1,"roles" => $role],$remember) ){

      $user = User::where('email', '=', $email)->first();

      $user->auth_token = md5(uniqid(rand(), true));

      $user->device_type = $device_type;

      $user->lat = 0;

      $user->long = 0;

      $user->device_token = $device_token;

      $user->save();

      if($user->roles == "customer"){

      $delivery_charges_per_km = DB::select("SELECT value FROM settings WHERE name = ?",['delivery_charges_per_km']);
      $minimum_delivery_charges = DB::select("SELECT value FROM settings WHERE name = ?",['minimum_delivery_charges']);

      $user['delivery_charges_per_km'] = $delivery_charges_per_km[0]->value;
      $user['minimum_delivery_charges'] = $minimum_delivery_charges[0]->value;

      }elseif( $user->roles == "partner" ){

        $total_amount = 0;

        foreach( $user->partnerOrder as $order ){

          $total_amount = $total_amount + $order->total;

        }

        $can_accept = $user->order_limit - $total_amount;

        $user['limit_left'] = $can_accept;

      }

      return json_encode($user,JSON_NUMERIC_CHECK);

    }else{

      if( Auth::attempt(["email" => $email,"password" => $password,"verified" => 0,"roles" => $role]) ){

        return json_encode(array("status"=>"fail","message" => "Your Account is not activated kindly verify your email"));

      }

      return json_encode(array("status"=>"fail","message" => "Invalid Credentials"));

    }

  }
  
  public function forgotPassword(){

    $email = Input::get("email");

    $user = User::where('email', '=', $email)->first();

    if( count($user) > 0 ){

      $data['code'] = mt_rand(1000, 9999);

      Mail::send('emails.resetPassword', $data, function($message) {
         $message->to(Input::get("email"),'')->subject
            ('Reset Password Code');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
      });

      DB::insert('insert into password_resets (email, token) values (?, ?)', [$email, $data['code']]);

      return json_encode(array("Status" => "success","message" => "Password reset code sent to your mail successfully"));

    }
    else{

      return json_encode(array("status" => "fail","message" => "No User Found"));

    }

  }

  public function resetPassword(){

    $data = array(
      'token' => Input::get('code'),
      'email' => Input::get('email'),
      'password' => Input::get('password'),
      'password_confirmation' => Input::get('password_confirmation'),
      );

    $validator = Validator::make($data,[

      'token' => 'required|string',
      'email' => 'required|email|string|max:255',
      'password' => 'required|confirmed|min:6',

      ]);

    if( $validator->fails() ){

      return json_encode($validator->errors(),JSON_NUMERIC_CHECK);

    }else{

      $user = User::where('email', '=', $data['email'])->first();

      $token = DB::table('password_resets')
      ->select('token')
      ->where('token',$data['token'])
      ->get();

      if( count($user) == 0 ){

        return json_encode(array('status' => 'fail', 'message' => 'No User Found'));
        
      }elseif( count($token) == 0  ){

        return json_encode(array('status' => 'fail', 'message' => 'Invalid Code'));

      }
      else{

        $user->password = bcrypt($data['password']);

        $user->save();

        DB::delete("delete from password_resets where token = ?",[$data['token']]);

        return json_encode(array("status" => "success","message" => "Password Reseted Successfully"));
      }

    }

  }
  
}

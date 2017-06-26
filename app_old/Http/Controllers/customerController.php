<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\Menu;

use View;
use Input;
use Validator;
use Redirect;
use Hash;
use Session;
use URL;
use Mail;

class customerController extends Controller
{
    public function index(){
    	$users = User::where("roles","=","customer")
      ->paginate(15);
    	return View::make("adminpanel.customerList")->with('users',$users);
    }

    public function store(){
    	if(Input::get('email') == "" or input::get('password') == "" or  input::get('name') == "" ){
           echo "<font color='red'>Please fill required values</font>";
           die;
    	}

    	$user_obj = User::where('email','=',Input::get('email'))->get();
    	if(count($user_obj) > 0){
           echo "<font color='red'>Please check email already exist</font>";
           die;
    	}
        
	    $user = new User;
	    $password = bcrypt(Input::get('password'));
      $verification_token = md5(uniqid(rand(), true));

	    $user->display = Input::get('display');
	    $user->name = Input::get('name');
	    $user->last_name = Input::get('last_name');
	    $user->email = Input::get('email');
	    $user->phone = Input::get('phone');
	    $user->password = $password;
	    $user->order_limit = Input::get('order_limit');
	    $user->balance = Input::get('balance');
	    $user->status = Input::get('status');
      $user->roles = 'customer';
      $user->image = URL::to('/images/new-user-image-default.png');
      $user->verified = 0;
      $user->verification_token = $verification_token;
	    $user->created_at = date('Y-m-d h:i:s');
	    $user->updated_at = date('Y-m-d h:i:s');
	    $user->save();

      $data = ['verification_token' => $verification_token,'name' => Input::get('name')];

      Mail::send('emails.emailVerification', $data, function($message) {
         $message->to(Input::get('email'),'')->subject
            ('Confirm Email to Register');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
      });
	    
	    return 1;
	}
	#end of the function

	public function show( $id ){
	    $user = User::find( $id );

	    if($user->count() == 0){

	    	return Redirect::to('/customers');

	    }

	    return View::make('adminpanel.customerDetail')
	    ->with('user',$user);
    }
    #end of the function

    public function update( $user_id ){
    	if(Input::get('email') == "" or  input::get('name') == "" ){
           echo "<font color='red'>Please fill required values</font>";
           die;
    	}

    	/*$user_obj = User::where('email','=',Input::get('email'))->get();
    	if(count($user_obj) > 0){
           echo "<font color='red'>Please check email already exist</font>";
           die;
    	}*/


      $user = User::find( $user_id );
	    $password = bcrypt(Input::get('password'));
	    $user->display = Input::get('display');
	    $user->name = empty(Input::get('name')) ? " " : Input::get('name') ;
	    $user->last_name = empty(Input::get('last_name')) ? " " : Input::get('last_name') ;
	    $user->email = Input::get('email');
	    $user->phone = Input::get('phone');
	    $user->password = $password;
	    $user->order_limit = Input::get('order_limit');
	    $user->balance = Input::get('balance');
	    $user->status = Input::get('status');
	    $user->updated_at = date('Y-m-d h:i:s');
	    $user->save();

	    echo 1;
    }
    #end of the function

    public function destroy($id){

    	$user = User::find($id);

    	$user->orderList()->delete();

    	$user->order()->delete();

    	$user->delete();

    	// return json_encode(array("status"=>"success","message"=>"User Deleted Successfully"));

      Session::flash("message","Customer Deleted Successfully");

    }

    public function updateUser(){

    $user = User::find( Input::get('user_id') );
	
    if( count($user) == 0 ){

	return json_encode(array("status"=>"fail","message"=>"No Customer Found"));

    }

    $rules = [
    "user_id"=>"required",
    ];

    //sprint_r(Input::all());die;

    $validator = Validator::make(Input::all(),$rules);

    if($validator->fails()){

      return json_encode(array('status' => 'fail', 'errors'=>$validator->errors()));

    }
    else{
	
      if(!empty(Input::get('first_name'))){

      $user->name = Input::get('first_name');
	
      }

      if(!empty(Input::get('last_name'))){
      
      $user->last_name = Input::get('last_name');
      
      }

      if(!empty(Input::get('display_name'))){
      
      $user->display = Input::get('display_name');
      
      }
      
      if(!empty(Input::get('phone'))){

      $user->phone = Input::get('phone');

      }
      
      if(Input::hasFile('image')){

      $fileName = Input::file('image')->getClientOriginalName();

      Input::file('image')->move("images",$fileName);
      
      $user->image = URL::to("/images/$fileName");

      }

      $user->save();

      return json_encode(array("status"=>"success","message"=>"Customer Updated Successfully","details"=>$user));
    }
  }

  public function updateUserCoordinates( Request $request ){

    $user = User::find($request->user_id);

    $user->lat = $request->lat;

    $user->long = $request->long;

    $user->save();

    return json_encode(array('status' => 'success', 'message'=>'User Coordinates Updated Successfully')) ;

  }

  public function getUserCoordinates( Request $request ){

    $user = User::where("id","=",$request->user_id)->first(["lat","long"]);

    return json_encode(array("status" => "success","details" => $user));

  }

  public function customerDetails( Request $request ){

    $user = User::find($request->user_id);

    if( $user->roles == 'customer' ){

        $details = [

        'balance' => $user->balance,
        'order_limit' => $user->order_limit,
        'last_order' => ($user->order->last()->status == 'closed' ) ? $user->order->last()->total : "0",
        'order_count' => $user->order->count(),
        ];

    }
    else{

      $details = [

        'cash_in_hand' => $user->cash_in_hand,
        'order_limit' => $user->order_limit,
        'last_order' => ($user->partnerOrder->last()->status == 'closed' ) ? $user->partnerOrder->last()->total : "0",
        'order_count' => $user->partnerOrder->count(),
        ];

    }

    return json_encode(array('status' => 'success', 'details' => $details));

  }

  public function verifyEmail( $token ){

    $user = User::where('verification_token','=',$token)->first();

    if(count($user) == 0){

      return "OOPSSSS...!!!! Nothing to verify :(";

    }

      Mail::send('emails.thankyouEmail',[], function($message) use($user) {
    
           $message->to($user->email,'')->subject('Account Activated');
           //$message->from('khallaf@3webbox.com','Khallaf');
           $message->from('info@3webbox.com','Cirrb');
        });
      User::where('verification_token','=',$token)->update([

      'verification_token' => " ",
      'verified' => 1,

      ]);

    return "Thank you Your account Activated Successfully";

  }
  public function updatePassword( $user_id ){

    $user = User::find($user_id);

    return View::make("adminpanel.change-password")->with('user',$user);

  }
  public function resetPassword( $user_id ){

    $validator = Validator::make(Input::all(),[

      "password" => "required|confirmed"

      ]);
    if( $validator->fails() ){

      return Redirect::to("change-password/$user_id")->withErrors($validator);

    }

    $user = User::find( $user_id );

    echo $user->password."  ".Input::get('password')."  ".bcrypt(Input::get('password'));

    $user->password = bcrypt(Input::get('password'));

    $user->save();
    
    Session::flash('message','Password Reset Successfully');

    return Redirect::to("change-password/$user_id");

  }
  public function updateDeviceToken( Request $request ){

    $user = User::find( $request->user_id );

    $user->device_token = $request->device_token;

    $user->save();

    return json_encode(array('status' => 'success','message' => 'Token Updated Successfully' ));

  }
}
#end of the class

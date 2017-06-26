<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Models\Coupon;

use View;
use Input;
use Validator;
use Redirect;
use Hash;
use Session;
use URL;
use Mail;

class CouponController extends Controller
{
    public function index(){
    	$coupons = Coupon::all();
    	return View::make("adminpanel.couponList")->with('coupons',$coupons);
    }

    public function store(){

	    $coupon = new Coupon;
	    $coupon->code = Input::get('code');
	    $coupon->type = Input::get('type');
	    $coupon->start_date = Input::get('start_date');
	    $coupon->end_date = Input::get('end_date');
	    $coupon->value = Input::get('value');
	    $coupon->created_at = date('Y-m-d h:i:s');
	    $coupon->updated_at = date('Y-m-d h:i:s');
	    $coupon->save();
	    return 1;
	  }
	  #end of the function

	public function show( $id ){
	    $coupon = Coupon::find( $id );
	    if($coupon->count() == 0){
	    	return Redirect::to('/coupon');
	    }
	    return View::make('adminpanel.couponDetail')
	    ->with('coupon',$coupon);
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

	    //echo 1;
      Session::flash("message","Customer Updapted Successfully");
	    return Redirect::to("customers/$user_id");
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

    public function updateUser( Request $request ){

      $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }

    $user = User::find( Input::get('user_id') );
	
    if( count($user) == 0 ){

	    return json_encode(array("status"=>"fail","message"=>"No User Found"));

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

      return json_encode(array("status"=>"success","message"=>"Customer Updated Successfully","details"=>$user),JSON_NUMERIC_CHECK);
    }
  }

  /*public function updateUserCoordinates( Request $request ){

    $user = User::find($request->user_id);

    if( count($user) == 0 ){

	    return json_encode(array("status"=>"fail","message"=>"No User Found"));

    }

    $user->lat = $request->lat;

    $user->long = $request->long;

    $user->save();

    return json_encode(array('status' => 'success', 'message'=>'User Coordinates Updated Successfully')) ;

  }*/

  public function userCoordsUpdate( Request $request ){
  
    $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }

    $user = User::find( $request->user_id );

    $user->lat = $request->lat;
    
    $user->long = $request->long;

    $user->save();

    http_response_code(200);

    return json_encode(array("status"=>"success","message"=>"User Coordinates Updated Successfully"));
    
  }

  public function getUserCoordinates( Request $request ){

    $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }

    $user = User::where("id","=",$request->user_id)->first(["lat","long"]);

    if( count($user) == 0 ){

	    return json_encode(array("status"=>"fail","message"=>"No User Found"));

    }

    return json_encode(array("status" => "success","details" => $user),JSON_NUMERIC_CHECK);

  }

  public function customerDetails( Request $request ){

    $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }

    $user = User::find($request->user_id);

    if( count($user) == 0 ){

	    return json_encode(array("status"=>"fail","message"=>"No User Found"));

    }

    if( $user->roles == 'customer' ){
        //echo  $user->order->count() . '@' .$user->order->last()->status;die;  
        $details = [

        'balance' => $user->balance,
        'order_limit' => $user->order_limit,
        'last_order' => ( $user->completed_order->count() != 0 && $user->completed_order->last()->status == 'closed' ) ? ($user->completed_order->last()->total + $user->completed_order->last()->remain_balance) : 0,
        'order_count' => $user->order->count(),
        ];

    }
    else{
      $details = [
	
        'cash_in_hand' => $user->cash_in_hand,
        'order_limit' => $user->order_limit,
        'last_order' => ( $user->partnerOrder->count() != 0  && $user->partnerOrder->last()->status == 'closed' ) ? $user->partnerOrder->last()->total : 0,
        'order_count' => $user->partnerOrder->count(),
        ];

    }

    return json_encode(array('status' => 'success', 'details' => $details),JSON_NUMERIC_CHECK);

  }

  public function verifyEmail( $token ){

    $user = User::where('verification_token','=',$token)->first();

    if(count($user) == 0){

      return "OOPSSSS...!!!! Nothing to verify :(";

    }

      Mail::send('emails.thankyouEmail',[], function($message) use($user) {
    
           $message->to($user->email,'')->subject('Account Activated');
           //$message->from('khallaf@3webbox.com','Khallaf');
           $message->from('info@cirrb.com','Cirrb');
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

    $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }

    $user = User::find( $request->user_id );
  
    if( count($user) == 0 ){
    
      return json_encode(["status"=>"success","message"=>"No User Found"]);

    }

    $user->device_token = $request->device_token;

    $user->save();

    return json_encode(array('status' => 'success','message' => 'Token Updated Successfully' ));

  }
	
public function websiteCreate(){
    
    return View::make("adminpanel.customerSingup");  

  }

  public function websiteStore(){

      $data = [
      
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'phone'=>'numeric'

      ];

      
      $validator = Validator::make(Input::all(),$data);
      
      if( $validator->fails() ){
  
        return Redirect::to("/customer-signup")
        ->withErrors($validator)
        ->withInput(Input::except('password'));
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
	    $user->order_limit = 5;
	    $user->balance = 0;
      $user->device_type = "";
      $user->device_token = "";
      $user->lat = 0;
      $user->long = 0;
      $user->status = 1;
      $user->partner_status = "-";
      $user->cash_in_hand = 0;
      $user->roles = 'customer';
    
      if(Input::hasFile('image')){

        $fileName = Input::file('image')->getClientOriginalName();

        Input::file('image')->move("images",$fileName);
        
        $user->image = URL::to("/images/$fileName");

      }else{

        $user->image = URL::to('/images/new-user-image-default.png');        
    
      }

      $user->verified = 0;
      $user->verification_token = $verification_token;
	    $user->created_at = date('Y-m-d h:i:s');
	    $user->updated_at = date('Y-m-d h:i:s');
	    $user->save();

      $data = ['verification_token' => $verification_token,'name' => Input::get('name')];

      Mail::send('emails.emailVerification', $data, function($message) {
         $message->to(Input::get('email'),'')->subject
            ('Email for someting');
        
         /*$swiftMessage = $message->getSwiftMessage();

          $headers = $swiftMessage->getHeaders();
          $headers->addTextHeader('MIME-version', '1.0');
          $headers->addTextHeader('Content-type', 'text/html');
          $headers->addTextHeader('Content-type','charset= iso-8859-1\n');*/
         
         $message->from('info@cirrb.com','Cirrb');
      });
	    
      Session::flash("message","Confirmation Mail is sent to your email, Please check to activate your account");

	    return Redirect::to("/customer-signup");
	}
	#end of the function

    public function updatePartnerStatus( Request $request ){
  
      $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }
  
       $partner = User::where("id","=",$request->partner_id)->where("roles","=","partner");
    
       if( $partner->count() == 0 ){
        
        return json_encode(['status'=>'fail','message'=>'No Partner Found !']);

       }

      $partner->update(["partner_status"=>$request->partner_status]);

      return json_encode(['status'=>'success','message'=>'Partner Status Updated Successfully']);

    }

}
#end of the class

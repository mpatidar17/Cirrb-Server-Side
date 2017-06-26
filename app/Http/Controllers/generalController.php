<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use View;
use Session;
use Redirect;

class generalController extends Controller
{

/*
  
  * Show Notifications Form
  *
  * @params $id
  *
  
  */

  public function notificationForm( $id ){

    $user = User::find( $id );    

    return View::make('adminpanel/notification-form')->with('user',$user);

  }

  /*
  
  * Triggers Custom Notifications
  *
  * @params $id
  *
  
  */

	public function customNotifications( Request $request ){

		$user = User::find( $request->user_id );

    $user->notification = $user->notification + 1;

    $user->save();

    $this->pushNotification( $user->device_token, $request->message, $user->roles,$user->notification );

    Session::flash("message","Notification Sent Successfully");
  
    if($user->roles == 'customer'){
      return Redirect::to("/customers");
    }
    elseif($user->roles == 'partner'){
      return Redirect::to("/partners");
    }
    elseif($user->roles == 'admin'){
      return Redirect::to("/admins");
    }
  

    

	}

  public function pushNotification( $deviceToken,$message,$triggerTo,$badge ){

    $production = false; 
    // Put your device token here (without spaces):

    $deviceToken = $deviceToken;
    
    if( strlen($deviceToken) != 64 ){
      return false;
    }
    
    //die($deviceToken);
    // Put your private key's passphrase here:
    $passphrase = '123';
    // Put your alert message here:
    $message = $message;
    
    $ctx = stream_context_create();
 
    if ($production) {
        
       stream_context_set_option($ctx, 'ssl', 'local_cert', ( $triggerTo == 'customer' ) ? 'public/others/cirrbAppDevelopment.pem' : 'public/others/cirrbAgentDevelopment.pem') ;
    
   }else{

    $pem =  ( $triggerTo == 'customer' ) ? 'public/others/cirrbAppDevelopment.pem' : 'public/others/cirrbAgentDevelopment.pem';
      
      //  echo $deviceToken."<br>".$message;die;

       stream_context_set_option($ctx, 'ssl', 'local_cert',$pem);
    }   
 
    //stream_context_set_option($ctx, 'ssl', 'local_cert', 'imwithyou_pem.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    
    // Open a connection to the APNS server
    
if ($production) {
       $gateway = 'ssl://gateway.push.apple.com:2195';
    } else { 
       $gateway = 'ssl://gateway.sandbox.push.apple.com:2195';
    } 
    $fp = stream_socket_client($gateway , $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);       
    //$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);       


    if (!$fp){
      $response['error'] = "Unable to send notification";
      exit();
    } 
    // Create the payload body
    $body['aps'] = array(
      'alert' => array(
            'body' => $message,
        'action-loc-key' => 'Cirrb',
        ),
        'badge' => $badge,
      'sound' => 'oven.caf',
      'content-available' => 1,
      'details'=>array('name'=>'hussain'),
      );
    // Encode the payload as JSON
    $payload = json_encode($body);
    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    // Send it to the server
    $r = fwrite($fp, $msg, strlen($msg));

    /*if (!$result){
      $response['error'] = "Message not deliver";
    }
    else{
      $response['success'] = 'Message successfully delivered';
    }*/
    // Close the connection to the server
    fclose($fp);
 }
 #end of the fucnton
    
  public function DetailsOnMap(){

    return View::make("adminpanel.user-info");
      
  }

  public function setInfoMap(){
  
     //$users = User::get(['lat','long','name','email','roles']);

     $users = User::where(function( $query ){

      $query->where('auth_token','!=','')
      ->where('roles','=','customer');

     })
     ->orWhere(function( $query ){
      
      $query->where('status','=','1')
      ->where('roles','=','partner');

     })
     ->get(['lat','long','name','email','roles','partner_status']);

    return json_encode($users);
  
  }

  public function updateNotificationCounter( Request $request ){

    $user = User::find($request->user_id);

    if( count($user) == 0 ){

      return json_encode(['status'=>'success','message'=>'No User Found']);

    }

    $user->notification = 0;

    $user->save();

    return json_encode(['status'=>'success','message'=>'Users Notifications Updated']);

  }

  public function bulkNotifications(){

    return View::make("adminpanel.bulk-notifications");

  }

  public function sendBulkNotifications( Request $request ){

    //print_r($request->filter);die;

    if( $request->customer ){

      $customers = User::where("roles","=","customer")->get();

      foreach ($customers as $customer) {

        $customerNotification = $customer->notification + 1; 

        $customer->notification = $customerNotification;

        $customer->save();
          
        $this->pushNotification($customer->device_token,$request->message,'customer',$customer->notification);

      }

    }

    if( $request->partner ){

      

        $partners = User::where("roles","=","partner")
        ->where(function( $query ) use ($request) {
          
          $query->where("partner_status","=",$request->free)
          ->orWhere("partner_status","=",$request->busy);

        })
        ->get();

      foreach ($partners as $partner) {
         
        $partnerNotification = $partner->notification + 1; 

        $partner->notification = $partnerNotification;

        $partner->save();

        $this->pushNotification($partner->device_token,$request->message,'partner',$partner->notification);

      }

    }
    return Redirect::to("/bulk-notifications");

  }

}

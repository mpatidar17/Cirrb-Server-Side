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

    $this->pushNotification( $user->device_token, $request->message, $user->roles );

    Session::flash("message","Notification Sent Successfully");

    return Redirect::to("/customers");

	}

  public function pushNotification( $deviceToken,$message,$triggerTo ){

    $production = false; 
    // Put your device token here (without spaces):

    $deviceToken = $deviceToken;
    //die($deviceToken);
    // Put your private key's passphrase here:
    $passphrase = '123';
    // Put your alert message here:
    $message = $message;
    
    $ctx = stream_context_create();
 
    if ($production) {
        
       stream_context_set_option($ctx, 'ssl', 'local_cert', ( $triggerTo == 'customer' ) ? 'others/cirrbAppDevelopment.pem' : 'others/cirrbAgentDevelopment.pem') ;
    
   }else{

    $pem =  ( $triggerTo == 'customer' ) ? 'others/cirrbAppDevelopment.pem' : 'others/cirrbAgentDevelopment.pem';
      
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
        'action-loc-key' => 'I am with you',
        ),
        'badge' => 2,
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
    
}

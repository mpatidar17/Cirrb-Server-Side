<?php

//mail("hussainyuvasoft185@gmail.com","Hiii","Hi Hussain","From: Cirrb<info@cirrb.com>");

$conn = mysqli_connect("localhost","root","cirrb123456","api_main") or die('Unable to connect to database');

$sql = "SELECT orders.created_at,users.device_token,orders.id,users.email FROM users JOIN orders ON orders.user_id=users.id WHERE orders.status='open'";

$result = mysqli_query($conn,$sql) or die('Query Not executed');

$mailmsg = "Sorry No Agent available for you order right now, Please try again later";
$mailHeaders = "From: Cirrb<info@cirrb.com>";

$rowcount=mysqli_num_rows($result);

while( $row = mysqli_fetch_assoc( $result ) ){
	print_r($row);
	$datetime1 = new DateTime($row["created_at"]);
        print_r($datetime1);
	$datetime2 = new DateTime('now'); 
        print_r($datetime2); 
	$interval = $datetime1->diff($datetime2);
	print_r($interval); 

        $minutes = $interval->i;
        $minutes = $minutes + (($interval->days)*24*60) + ($interval->h * 60);
	
	if( $minutes > 3 ){
		//mail('hussainyuvasoft185@gmail.com',"debugger",$minutes);
		$sql = "UPDATE orders SET status='incomplete' WHERE id=".$row['id'];
		$sql = mysqli_query($conn,$sql);

	echo "*****************".$row["email"];

	//print_r($row);

	mail($row["email"],"Order Incomplete",$mailmsg,$mailHeaders);

    # Notification Code Starts

	$triggerTo = 'customer';

      $production = false; 
      // Put your device token here (without spaces):

      $deviceToken = $row['device_token'];
      //die($deviceToken);
      // Put your private key's passphrase here:
      $passphrase = '123';
      // Put your alert message here:
      $message = "Sorry No Agent available for you order right now, Please try again later";
      
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
          'badge' => 1,
        'sound' => 'oven.caf',
        'content-available' => 1,
        'details'=>array('name'=>'hussain'),
        );
      // Encode the payload as JSON
      $payload = json_encode($body,JSON_NUMERIC_CHECK);
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

    # Notification Code Ends
		
	}
}

?>

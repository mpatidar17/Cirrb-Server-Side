<?php
//mail("hussainyuvasoft185@gmail.com","Hiii","Hi Hussain","From: Cirrb<info@cirrb.com>");

$conn = mysqli_connect("localhost","root","cirrb123456","api_main") or die('Unable to connect to database');

echo $sql = "SELECT * FROM partner_response  WHERE response='hold'";
echo "<br>";
$result = mysqli_query($conn,$sql) or die('Query Not executed');

$rowcount=mysqli_num_rows($result);

while( $row = mysqli_fetch_assoc( $result ) ){
  print_r($row);echo "<br>";
  $datetime1 = new DateTime($row["created_at"]);
  print_r($datetime1);echo "<br>";
  $datetime2 = new DateTime('now'); 
  print_r($datetime2); echo "<br>";
  $interval = $datetime1->diff($datetime2);
  print_r($interval); echo "<br>";

  $minutes = $interval->i;
  $minutes = $minutes + (($interval->days)*24*60) + ($interval->h * 60);

  echo $seconds = $minutes * 60 ;
  echo "<br>";
  if( $seconds > 15 ){
    $partner_id = $row['partner_id'] ;
    $order_id = $row['order_id'];
    $approval = 'deny';

    echo $url = 'http://api.cirrb.com/api/partnerDenyResponse/?partner_id='.$partner_id.'&order_id='.$order_id.'&approval='.$approval ;
    echo "<br>";
    $headers = array(
    'Accept: application/json',
    'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTREDIR, 3);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $return = curl_exec ($ch);
    curl_close ($ch);

    echo $return;echo "<br>";

    /*echo $sql = "UPDATE partner_response SET response='not respond' WHERE id=".$row['id'];
    $sql = mysqli_query($conn,$sql);*/
    echo "<br>---------------<br>";
  } //end of the if condition
}//end of the while

?>

<?php
$conn = mysqli_connect("localhost","cirrb3we_cirrbLa","laravel5.4","cirrb3we_cirrbLaravel") or die('database not connected');

$sql = "SELECT * FROM users JOIN orders ON orders.user_id=users.id WHERE orders.status='open'";

$result = mysqli_query($conn,$sql) or die('Query Not executed');

$msg = "Your Order is Dismissed";

$rowcount=mysqli_num_rows($result);

while( $row = mysqli_fetch_assoc( $result ) ){

	$datetime1 = new DateTime($row["created_at"]);
        print_r($datetime1);
	$datetime2 = new DateTime('now'); 
        print_r($datetime2); 
	$interval = $datetime1->diff($datetime2);
	print_r($interval); 

        $minutes = $interval->i;
        $minutes = $minutes + (($interval->days)*24*60) + ($interval->h * 60);

	if( $minutes > 5 ){
	
		$sql = "UPDATE orders SET status='incomplete' WHERE id=".$row['id'];
		 
		$sql = mysqli_query($conn,$sql);
		 
		mail($row["email"],"Order Diss-miss",$msg);
		
	}
}

?>
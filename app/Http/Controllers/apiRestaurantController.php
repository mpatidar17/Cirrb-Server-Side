<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\Menu;

use App\Models\Order;
use App\Models\OrderList;
use App\Models\PartnerResponse;
use Mail;
use URL;
use Auth;

class apiRestaurantController extends Controller
{

  public function __construct( Request $request ){
    
    $authToken = $request->header('Authorization');

    // echo User::where("auth_token","=",$authToken)->count();die;

    if( $authToken == '' or User::where("auth_token","=",$authToken)->count() == 0 ){
      
      echo  json_encode(["status"=>"fail","message"=>"Invalid token"]);
      die;
    }
   

  }

    /*
    * API to set an Order
    *
    * @params (Request) $request
    *
    */

    public function setOrderNew( Request $request ){

      $status = 'open' ;

      $user = User::find($request->user_id);

      if( count($user) == 0 ){
    
        return json_encode(array("status"=>"fail","message"=>"No User Found !"));

      }

      ###
      $restaurant_id_array = explode(',',$request->resturent_id);

      $restaurant_id = $restaurant_id_array[0];

      $branch_id_array = explode(',',$request->branch_id);

      $branch_id = $branch_id_array[0];

      $menu_array = explode(',',$request->id);

      foreach( $menu_array as $Item ){

        $menuItem = Menu::find($Item);

        if( count($menuItem) == 0 ){
          return json_encode(array('status' => 'fail', 'message'=>'No Menu Item Found'));
        }

      }

      $limit_count = $user->order_limit;

      $order_items_of_user = Order::where('user_id','=',$user->id)
      ->where(function ( $query ){
        $query->where('status','=','open')
        ->orWhere('status','=','process');
      })
      ->get();
      
      //echo count($order_items_of_user);die;

      if(  $limit_count > count($order_items_of_user) or 
           ( $limit_count == 0 and count($order_items_of_user) == 0 )  
      ){

        

        $order = new Order;
        $order->user_id = $user->id;
        
        # Order Restaurant Info
        $orderRestaurant = Restaurant::find( $restaurant_id );
        if( count($orderRestaurant) == 0 ){
          
          return json_encode(array("status" => "fail","message" => "No Restaurant Found !"));

        }
        $order->restaurant_id = $restaurant_id;
        $order->restaurant_name = $orderRestaurant->name;
        $order->restaurant_description = $orderRestaurant->description;
        $order->restaurant_phone = $orderRestaurant->phone;
        $order->restaurant_email = $orderRestaurant->email;
        $order->restaurant_image = $orderRestaurant->image;
        $order->restaurant_approved = $orderRestaurant->approved;
        $order->restaurant_approved_on = $orderRestaurant->approved_on;
        $order->restaurant_created_at = $orderRestaurant->created_at;

        # Order Branch Info
        $orderBranch = Branch::find( $branch_id );
        if( count($orderBranch) == 0 ){
          
          return json_encode(array("status" => "fail","message" => "No Branch Found !"));

        }
        $order->branch_id = $branch_id;
        $order->branch_restaurant_id = $orderBranch->restaurant_id;
        $order->branch_name = $orderBranch->name;
        $order->branch_lat = $orderBranch->bl_lat;
        $order->branch_long = $orderBranch->bl_long;
        $order->branch_created_at = $orderBranch->created_at;

        $order->status = $status;
        $order->sub_total = $request->sub_total ;
        $order->delivery_fees = $request->delivery_fees ;
        $order->total = $request->total ;
        $order->remain_balance = 0;
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();

        $order_id = $order->id ; 

        ###
        $quantity_array = explode(',',$request->quantity);
        

        # Notification code Starts

        $partners = User::where("roles","=","partner")
        ->where("partner_status","=","free")
				->where("status","=","1")
        ->get();

        $nearestTmp = 99999999;
        $nearestPartnerID = 0;

        foreach ($partners as $partner) {
         
        $lat1 = $order->branch->bl_lat;
        $lon1 = $order->branch->bl_long;
        $user_dist = $request->distance;

        $lat2 = $partner->lat;
        $lon2 = $partner->long;

        // $unit = "K";

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        // $unit = strtoupper($unit);

        $distance = ($miles * 1.609344);

        if( $nearestTmp > $distance ){

          $nearestTmp = $distance;

          $nearestPartnerID = $partner->id;

        }

        }

        // $partner = User::find($nearestPartnerID);
        // $partner->approve = "hold";
        // $partner->save();

        # Notification code Ends

        foreach($menu_array as $key=>$item){

              $menu = Menu::find($item);

              if( count($menu) == 0 ){
                return json_encode(array('status' => 'fail', 'message'=>'No Menu Item Found'));
              }

              $menu = json_encode($menu);

              $menu = json_decode($menu);

              $order_list = new OrderList;
              $order_list->order_id = $order_id;
              $order_list->quantity = $quantity_array[$key];

              # Order Menu Info
              $orderMenu = Menu::find($item);
              $order_list->menu_id = $item;
              $order_list->per_menu_cost = $orderMenu->price;
              $order_list->menu_image = $orderMenu->image;
              $order_list->menu_created_at = $orderMenu->created_at;

              $order_list->name = $menu->name;
              $order_list->cost = $menu->price * $quantity_array[$key];
              $order_list->description = $menu->description;
              $order_list->created_at = date('Y-m-d H:i:s');
              $order_list->updated_at = date('Y-m-d H:i:s');
              $order_list->save();
        }

        //Push Notification trigger here
        if( !empty($nearestPartnerID) ){

          $message = "New Order Received";

          //,"details" => array("order_id"=>$order->id,"customer_id" => $user->id);
  
          $partnerNotification = User::find($nearestPartnerID);

          $partnerNotification->notification = $partnerNotification->notification + 1;
          $partnerNotification->save();

          $this->pushNotification( $partnerNotification->device_token,$message,"partner",$partnerNotification->notification );
          
          $partnerResponse = new PartnerResponse;

          $partnerResponse->order_id = $order_id;

          $partnerResponse->partner_id = $nearestPartnerID;

          $partnerResponse->response = "hold";

          $partnerResponse->save();

        }

        //Push Notification ends

        return json_encode(array('status' => 'success', 'message' => 'Order created successfully'));

      }else{
        return json_encode(array('status' => 'fail', 'message' => 'Order limit exceed'));
      }

    }
    #end of the function
    ########## 

    /*
    * API to get Orders of a User
    *
    * @params (Request) $request
    *
    */

    public function getOrder( Request $request ){

      $user_id = $request->user_id;

      $is_user = User::find( $user_id );

      if( count($is_user) == 0 ){
        return json_encode(array("status"=>"fail","message"=>"No User Found"));
      }
      elseif($is_user->roles != 'customer'){
        return json_encode(array("status"=>"fail","message"=>"No User Found"));
      }

      $orders = Order::where('user_id','=',$user_id)
                ->where(function ( $query ){
                  $query->where('status','=','open')
                  ->orWhere('status','=','process');
                })
                ->orderby('id','desc')
                ->get();

      foreach($orders as $item){

        $restaurant =  array(

        'id' => $item->restaurant_id,
        'name' => $item->restaurant_name,
        'description' => $item->restaurant_description,
        'phone' => $item->restaurant_phone,
        'email' => $item->restaurant_email,
        'image' => $item->restaurant_image,
        'approved' => $item->restaurant_approved,
        'approved_on' => $item->restaurant_approved_on,
        'created_at' => $item->restaurant_created_at,        

        );

        $item->restaurant = $restaurant ;

        $branch =  array(

          "id" => $item->branch_id,
          "restaurant_id"=> $item->branch_restaurant_id,
          "name"=> $item->branch_name,
          "bl_lat"=> $item->branch_bl_lat,
          "bl_long"=> $item->branch_bl_long,
          "created_at"=> $item->branch_created_at,

          );

        $item->branch = $branch ;

        $order_list =  OrderList::where('order_id','=',$item->id)->get();
        $item->order_list = $order_list ;
        
        $partner =  User::where('id','=',$item->partner_id)->get();
        $item->partner = $partner;
        
      }

      $list['response'] = [ 'status' => 'success', 'orders' =>  $orders ];  

      return json_encode($list['response'],JSON_NUMERIC_CHECK);

      //print_r($orders);

    }
    #end of the function

    /*
    * API to set get all Orders
    *
    * @params (Request) $request
    *
    */
    public function getAllOrder( Request $request ){

      $user_id = $request->user_id;
    
      $is_user = User::find( $user_id );

      if( count($is_user) == 0 ){
        return json_encode(array("status"=>"fail","message"=>"No User Found"));
      }
      elseif($is_user->roles != 'customer'){
        return json_encode(array("status"=>"fail","message"=>"No User Found"));
      }

      $orders = Order::where('user_id','=',$user_id)
                // ->where('status','=','open')
                ->orderby('id','desc')->get();

      foreach($orders as $item){

        $restaurant =  Restaurant::where('id','=',$item->restaurant_id)->get();
        $item->restaurant = $restaurant ;

        $branch =  Branch::where('id','=',$item->branch_id)->get();
        $item->branch = $branch ;

        $order_list =  OrderList::where('order_id','=',$item->id)->get();
        $item->order_list = $order_list ;
      
        $partner =  User::where('id','=',$item->partner_id)->get();
        $item->partner = $partner;

      }
      
      

      $list['response'] = [ 'status' => 'success', 'orders' =>  $orders ];  

      return json_encode($list['response'],JSON_NUMERIC_CHECK);

      //print_r($orders);

    }
    #end of the function  

    /*public function setOrder( Request $request ){

      $status = 'open' ;
    
      if(count($request->order_item) > 0){
        $restaurant_id = $request->order_item[0]['restaurant_id'];
        $branch_id = $request->order_item[0]['branch_id'];
      }else{
        return json_encode(array('status' => 'fail', 'message' => 'Please add menu items'));
      }

      $limit_count = $loggedin[0]->order_limit ; 

      $order_items_of_user = Order::where('user_id','=',$loggedin[0]->id)->get();
      

      if(  $limit_count > count($order_items_of_user) or 
           ( $limit_count == 0 and count($order_items_of_user) == 0 )  
      ){

        $order = new Order;
        $order->user_id = $loggedin[0]->id;
        $order->restaurant_id = $restaurant_id;
        $order->branch_id = $branch_id ;
        $order->status = $status;
        $order->sub_total = $request->sub_total ;
        $order->delivery_fees = $request->delivery_fees ;
        $order->total = $request->total ;
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();

        $order_id = $order->id ; 

        foreach($request->order_item as $item){
              $order_list = new OrderList;
              $order_list->order_id = $order_id;
              $order_list->quantity = $item['quantity'];
              $order_list->menu_id = $item['id'] ;
              $order_list->created_at = date('Y-m-d H:i:s');
              $order_list->updated_at = date('Y-m-d H:i:s');
              $order_list->save();
        }



        return json_encode(array('status' => 'success', 'message' => 'Order created successfully'));

      }else{
        return json_encode(array('status' => 'fail', 'message' => 'Order limit exceed'));
      }

    }*/
    #end of the function

    /*
    * API to get Branches according to distance of the User
    *
    * @params (Request) $request
    *
    */

    public function getRestaurants( Request $request ){

    $branches = Branch::all();

    if( $branches->count() == 0 ){
	
	return json_encode(array( "status"=>"fail","message"=>"No Restaurant found !" ));

    }

    $list = array('main' => array());

    foreach($branches as $branch){

       $lat1 = $request->lat;
       $lon1 = $request->long;
       $user_dist = $request->distance;

       $lat2 = $branch->bl_lat;
       $lon2 = $branch->bl_long;

       $unit = "K";

       $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

       $distance = ($miles * 1.609344);

       if( $distance <= $user_dist ){

        $restaurant = Restaurant::find($branch->restaurant_id);

        $branch['distance'] = round($distance);

        $list['main'][] = array( 'restaurant' => $restaurant, 'branch' => $branch );
       }
    }

    $list['response'] = [ 'status' => 'success', 'details' => $list['main'] ];  

    return json_encode($list['response'],JSON_NUMERIC_CHECK);

  }

  /*
  * API to get Menus of a Restaurant
  *
  * @params (Request) $request
  *
  */

  public function getMenus( Request $request ){

    $restaurant_id = $request->restaurant_id;

	  if( count(Restaurant::find( $restaurant_id )) == 0 ){
		    
      return json_encode(array("status"=>"fail","message"=>"No Restaurant Found !"));

	  }

    $menus = Restaurant::find( $restaurant_id )->menus;

    foreach ($menus as $key => $menu) {
      $menu['quantity'] = 0;
    }

    $menu_list = array('status' => 'success','details' => $menus );

    return json_encode($menu_list,JSON_NUMERIC_CHECK);
  }

  /*
  * API to process the Response from the Partner Accept / Deny accordingly
  *
  * @params (Request) $request
  *
  */  

  public function partnerApprovalResponse( Request $request ){

    if( $request->approval == "accept" ){
      
      $is_partner = User::where("id","=",$request->partner_id)->where('roles',"=","partner");
       //echo $is_partner->first()->partner_status;die;
      if( $is_partner->count() == 0 ){
        
          return json_encode(array("status" => "fail","message" =>"Partner Not Found"));      

      }elseif( $is_partner->first()->partner_status == "busy" ){
  
          return json_encode(array("status" => "fail","message" =>"Complete your Previous Order First"));    
      
      }


      $partner_response = PartnerResponse::where("order_id","=",$request->order_id)
      ->where("partner_id","=",$request->partner_id);

      $partner_response->update(['response' => 'accept']);

      if($partner_response->count() == 0 ){

        return json_encode(array("status" => "fail","message" => "You can't Accpet this order right now"));

      }

      elseif( $partner_response->first()->response == "deny" ){

        return json_encode(array("status" => "fail","message" => "You can't Accpet this order now"));

      }

      $totalAmount = Order::where("partner_id","=",$request->partner_id)
      ->where("status","=","process")
      ->sum('total');

      $partner = User::find( $request->partner_id );

      $order = Order::find($request->order_id);

      $cashInHand = $partner->order_limit - $totalAmount;

      if($cashInHand < $order->total ){

        return array('status' => 'fail', 'message' => 'Order Accept Limit Exceed');
      
      }


      $order_payable =  $order->total - $order->user->balance ;
      if($order_payable < 0) $order_payable = 0 ;	

      $partners = User::where('roles',"=","partner")
      ->update([ "approve" => "" ]);

      $partner->partner_status = "busy";

      $partner->save();

      $order->partner_id = $request->partner_id;

      $order->status = "process";

      $order->order_payable = $order_payable ;//$order->total - $order->user->balance; 

      $order->save();

      $order->user;

      $order->branch;

      $order->restaurant;

      $order->order_list;

      $order->user;
  
      $message = "Order Accepted";

      //,"details" => array("order_id"=>$order->id,"partner_id"=>$order->partner)

      //echo $order->user->device_token;die;
      
      $partnerNotification = User::find( $order->user->id );

      $partnerNotification->notification = $partnerNotification->notification + 1;

      $partnerNotification->save();      

      $this->pushNotification( $order->user->device_token,$message,"customer",$partnerNotification->notification);

      //$order->partner;

      //$restaurant = $order->branch-

      return json_encode(array("status" => "success","details" => array("order"=>$order)),JSON_NUMERIC_CHECK);

    }
    else{

        # Notification Code Starts

        $partner_response = PartnerResponse::where("order_id","=",$request->order_id)
        ->where("partner_id","=",$request->partner_id);
        //->update(["response"=>"deny"]);

        $partner_response->update(["response"=>"deny"]);

        //echo $partner_response->first()->partner_id;die;

        // $partner_response->response = "deny";
        // $partner_response->save();

        $partners = User::where("roles","=","partner")
        ->where("partner_status","=","free")
				->where("status","=","1")
        ->get();

        $nearestTmp = 5000;
        $nearestPartnerID = 0;

        $order = Order::find($request->order_id);

        //echo $partners[0]->order->id;die;
        //echo $partners[0]->partnerResponse->response;die;



        foreach ($partners as $partner) {

       // echo $partner->partnerResponse->count();die;

        if( $partner_response->first()->partner_id == $partner->id ){

          continue;

        }

        $lat1 = $order->branch->bl_lat;
        $lon1 = $order->branch->bl_long;
        $user_dist = $request->distance;

        $lat2 = $partner->lat;
        $lon2 = $partner->long;


        // $unit = "K";

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        // $unit = strtoupper($unit);

        $distance = ($miles * 1.609344);

        if( $nearestTmp > $distance ){

          $nearestTmp = $distance;

          $nearestPartnerID = $partner->id;

          $deviceToken = $partner->device_token;

        }

        }

        //$partner = User::find($nearestPartnerID);
        //$partner->approve = "hold";
        //$partner->save();

        if( !empty($nearestPartnerID) ){

          $message = "New Order Received";

          //,"details" => array("order_id"=>$order->id,"customer_id"=>$order->user->id)

          $partnerNotification = User::find($nearestPartnerID);

          $partnerNotification->notification = $partnerNotification->notification + 1;
          $partnerNotification->save();

          $this->pushNotification( $deviceToken,$message,"partner",$partnerNotification->notification);

          $partnerResponse = new PartnerResponse;
        
          $partnerResponse->order_id = $order->id;
  
          $partnerResponse->partner_id = $nearestPartnerID;
  
          $partnerResponse->response = "hold";
  
          $partnerResponse->save();
        }

       return json_encode(array('status' => 'success', 'message' => 'Order Denial Successful'));

        # Notification Code Ends


    }

  }

  /*
  * API to get nearest Order
  *
  * @params (Request) $request
  *
  */

  public function nearestOrder( Request $request ){

    $orders = Order::where("status","=","open")->get();

    $ispartner = User::where( "id","=",$request->partner_id )->where("roles","=","partner")->count();

    if( $ispartner == 0 ){
	
			return json_encode(array('status' => 'fail', 'message' => 'No Partner Found !'));

    }

    if( count($orders) == 0){

       return json_encode(array('status' => 'success', 'details' => array()));  

    }

    foreach( $orders as $order ){

		   $isDenied = PartnerResponse::where("partner_id","=",$request->partner_id)->where("order_id","=",$order->id)->where("response","=","deny")->count();

      		    $isOrderExists = PartnerResponse::where("partner_id","=",$request->partner_id)->where("order_id","=",$order->id)->where("response","=","hold")->count();

		   if( $isDenied > 0 ){
		
			continue;

		    }
		    elseif( $isOrderExists > 0 ){

		      return json_encode(array('status' => 'success', 'details' => $order),JSON_NUMERIC_CHECK);

		    }
    	
		
    }//end of the for loop

    return json_encode(array('status' => 'success', 'details' => array())); 

  }

  /*
  * API for Payment
  *
  * @params (Request) $request
  *
  */

  public function orderPayment( Request $request ){

    $order = Order::find( $request->order_id );

    $is_ordered = Order::where("partner_id","=",$request->partner_id)->where("id","=",$request->order_id )->count();

    if($is_ordered == 0){
      
       return json_encode(["status"=>"fail","message"=>"No Such Order Created"]);

    }

    if( $order->status == "closed" ){

      return json_encode(["status"=>"fail","message"=>"Payment already Done"]);

    }

    $customer = User::find( $order->user->id );

    $partner = User::find( $order->partner->id );

    $oldCustomerBal = $customer->balance;

    $customerBal = $customer->balance + $request->amount - $order->total;

    $customer->balance = $customerBal;

    $customer->save();

    //$partner->partner_status = "free";

    $remainBal = $customerBal;

    $orderCommissionAmount = ($order->delivery_fees * $partner->commission) / 100;

    $partner->commission_amount = $partner->commission_amount + $orderCommissionAmount;

    $partner->cash_in_hand =  $partner->cash_in_hand + (($request->amount + $oldCustomerBal ) - $order->sub_total - $orderCommissionAmount);

    $partner->save();

    $order->status = "closed";

    $order->remain_balance = $remainBal;

    $order->save();

    $message = "Your Order#".$order->id." is Succssfully Completed";

    //echo $order->user->device_token;die;

    $partnerNotification = User::find($order->user->id);

    $partnerNotification->notification = $partnerNotification->notification + 1;

    $partnerNotification->save();

    $this->pushNotification( $order->user->device_token,$message,"customer",$partnerNotification->notification);

    Mail::send('emails.paymentSuccess',[], function($message) use($order) {
         $message->to($order->user->email,'')->subject
            ('Payment Successful');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@cirrb.com','Cirrb');
      });

    return json_encode(array('status' => 'success', 'message' => 'Payment Successfully Done'));

  }
  
  public function cancelOrder( Request $request ){
  
    $order = Order::find($request->order_id);
    
    $is_ordered = Order::where("id","=",$request->order_id)->where("user_id","=",$request->user_id)->count();

    if($is_ordered == 0){
      
       return json_encode(["status"=>"fail","message"=>"No Such Order Created"]);

    }

    $order->status = "cancel";
    
    $order->save();
    
   return json_encode(["status"=>"success","message"=>"Order Cancelled Successfully"]);
  
  }
  public function testPushOld(){

    //die()

	//echo strlen("a8e5f57cfd907e1931870c4ede03a33bb395d0a273ac6c08104c565e0bd71688");die;
	$deviceToken = "o8e5f57cfd907e1931870c4ede03a33bb395d0a273ac6c08104c565e0bd71";
	echo pack('H*', $deviceToken);die;
    $user = User::find(2);

    $production = true;

    // Put your device token here (without spaces):

      $deviceToken = $user->device_token;
      //die($deviceToken);
      // Put your private key's passphrase here:
      $passphrase = '123';
      // Put your alert message here:
      $message = "Hi this is a test notification";
      
      $ctx = stream_context_create();
   
       if ($production) {
         stream_context_set_option($ctx, 'ssl', 'local_cert', URL::to('/others/cirrbAppProduction.pem'));
      }else{
         stream_context_set_option($ctx, 'ssl', 'local_cert', URL::to('/others/cirrbAppCustomerDevelopment.pem'));
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
        'content-available' => 1
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
  $response['success'] = 'Message successfully delivered';
  // }else{
  // $response['error'] = "Please enter correct ids";
   }

   public function pushNotification( $deviceToken,$message,$triggerTo,$badge ){
    	   
            $production = false; 
            // Put your device token here (without spaces):
	
            $deviceToken = $deviceToken;
		if(strlen($deviceToken) != 64){
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
   }
   #end of the fucnton

	/*
    * API to get Orders of a User
    *
    * @params (Request) $request
    *
    */

    public function getPartnerOrder( Request $request ){

      $user_id = $request->user_id;

      $is_user = User::find( $user_id );

      if( count($is_user) == 0 ){
        return json_encode(array("status"=>"fail","message"=>"No User Found"));
      }
      elseif($is_user->roles != 'partner'){
        return json_encode(array("status"=>"fail","message"=>"No User Found"));
      }

      $orders = Order::where('partner_id','=',$user_id)
                ->orderby('id','desc')
                ->get();

      foreach($orders as $item){

        $restaurant =  array(

        'id' => $item->restaurant_id,
        'name' => $item->restaurant_name,
        'description' => $item->restaurant_description,
        'phone' => $item->restaurant_phone,
        'email' => $item->restaurant_email,
        'image' => $item->restaurant_image,
        'approved' => $item->restaurant_approved,
        'approved_on' => $item->restaurant_approved_on,
        'created_at' => $item->restaurant_created_at,        

        );

        $item->restaurant = $restaurant ;

        $branch =  array(

          "id" => $item->branch_id,
          "restaurant_id"=> $item->branch_restaurant_id,
          "name"=> $item->branch_name,
          "bl_lat"=> $item->branch_bl_lat,
          "bl_long"=> $item->branch_bl_long,
          "created_at"=> $item->branch_created_at,

          );

        $item->branch = $branch ;

        $order_list =  OrderList::where('order_id','=',$item->id)->get();
        $item->order_list = $order_list ;
        
        $partner =  User::where('id','=',$item->user_id)->get();
        $item->user = $partner;
        
      }

      $list['response'] = [ 'status' => 'success', 'orders' =>  $orders ];  

      return json_encode($list['response'],JSON_NUMERIC_CHECK);

      //print_r($orders);

    }
    #end of the function

}

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

class apiRestaurantController extends Controller
{
    
    /*
    * API to set an Order
    *
    * @params (Request) $request
    *
    */

    public function setOrderNew( Request $request ){

      $status = 'open' ;

      $user = User::find($request->user_id);

      ###
      $restaurant_id_array = explode(',',$request->resturent_id);
      $restaurant_id = $restaurant_id_array[0];
      $branch_id_array = explode(',',$request->branch_id);
      $branch_id = $branch_id_array[0];

      $limit_count = $user->order_limit ; 

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
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();

        $order_id = $order->id ; 

        ###
        $quantity_array = explode(',',$request->quantity);
        $menu_array = explode(',',$request->id);

        # Notification code Starts

        $partners = User::where("roles","=","partner")
        ->where("partner_status","=","free")
        ->get();

        $nearestTmp = 5000;
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

        $partnerResponse = new PartnerResponse;

        $partnerResponse->order_id = $order_id;

        $partnerResponse->partner_id = $nearestPartnerID;

        $partnerResponse->response = "hold";

        $partnerResponse->save();

        # Notification code Ends

        foreach($menu_array as $key=>$item){

              $menu = Menu::find($item);

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

        // array("");

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

      return json_encode($list['response']);

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

      }
      
      

      $list['response'] = [ 'status' => 'success', 'orders' =>  $orders ];  

      return json_encode($list['response']);

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

    return json_encode($list['response']);

  }

  /*
  * API to get Menus of a Restaurant
  *
  * @params (Request) $request
  *
  */

  public function getMenus( Request $request ){

    $restaurant_id = $request->restaurant_id;

    $menus = Restaurant::find( $restaurant_id )->menus;

    foreach ($menus as $key => $menu) {
      $menu['quantity'] = 0;
    }

    $menu_list = array('status' => 'success','details' => $menus );

    return json_encode($menu_list);
  }

  /*
  * API to process the Response from the Partner Accept / Deny accordingly
  *
  * @params (Request) $request
  *
  */  

  public function partnerApprovalResponse( Request $request ){

    if( $request->approval == "accept" ){

      $totalAmount = Order::where("partner_id","=",$request->partner_id)
      ->where("status","=","process")
      ->sum('total');

      $partner = User::find( $request->partner_id );

      $order = Order::find($request->order_id);

      $cashInHand = $partner->order_limit - $totalAmount;

      if($cashInHand < $order->total ){

        return array('status' => 'fail', 'message' => 'Order Accept Limit Exceed');
      
      }

      $partners = User::where('roles',"=","partner")
      ->update([ "approve" => "" ]);

      $partner->partner_status = "busy";

      $partner->save();

      $order->partner_id = $request->partner_id;

      $order->status = "process";

      $order->save();

      $order->user;

      $order->branch;

      $order->restaurant;

      $order->order_list;
      
      //$order->partner;

      //$restaurant = $order->branch-

      return json_encode(array("status" => "success","details" => array("order"=>$order,)));

    }
    else{

        # Notification Code Starts

        $partner_response = PartnerResponse::where("order_id","=",$request->order_id)
        ->where("partner_id","=",$request->partner_id)
        ->update(["response"=>"deny"]);

        // $partner_response->response = "deny";
        // $partner_response->save();

        $partners = User::where("roles","=","partner")
        ->where("partner_status","=","free")
        ->get();

        $nearestTmp = 5000;
        $nearestPartnerID = 0;

        $order = Order::find($request->order_id);

        //echo $partners[0]->order->id;die;
        //echo $partners[0]->partnerResponse->response;die;



        foreach ($partners as $partner) {

       // echo $partner->partnerResponse->count();die;

        if( count($partner->partnerResponse) != 0 && $partner->partnerResponse->response == "deny" ){

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

        }

        }

        //$partner = User::find($nearestPartnerID);
        //$partner->approve = "hold";
        //$partner->save();

        if( !empty($nearestPartnerID) ){
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

    $order = Order::where("status","=","open")->first();

    if( count($order) == 0){

    return json_encode(array('status' => 'success', 'details' => array()));  

    }

    return json_encode(array('status' => 'success', 'details' => $order));

  }

  /*
  * API for Payment
  *
  * @params (Request) $request
  *
  */

  public function orderPayment( Request $request ){

    $order = Order::find( $request->order_id );

    if( $order->status == "closed" ){

      return json_encode(["status"=>"fail","message"=>"Payment already Done"]);

    }

    $customer = User::find( $order->user->id );

    $partner = User::find( $order->partner->id );

    $customerBal = $customer->balance + ($request->amount - $order->total);

    $customer->balance = $customerBal;

    $customer->save();

    $partner->partner_status = "free";

    $remainBal = $request->amount - $order->total;

    $partner->cash_in_hand =  $partner->cash_in_hand + ($remainBal + $order->delivery_fees);

    $partner->save();

    $order->status = "closed";

    $order->save();

    Mail::send('emails.paymentSuccess',[], function($message) use($order) {
         $message->to($order->user->email,'')->subject
            ('Payment Successful');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
      });

    return json_encode(array('status' => 'success', 'message' => 'Payment Successfully Done'));

  }
  
  public function cancelOrder( Request $request ){
  
    $order = Order::find($request->order_id);
    
    $order->status = "cancel";
    
    $order->save();
    
   return json_encode(["status"=>"success","message"=>"Order Cancelled Successfully"]);
  
  }
  public function testPushOld(){

    //die()

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

   public function testPush(){
    $user = User::find(3);
            $production = false; 
            // Put your device token here (without spaces):
            $deviceToken = 
            "dd15233c48eb455528290b43a8236faed23c35b28b238752db14b2c9dc487a67";
            // Put your private key's passphrase here:
            $passphrase = '123';
            // Put your alert message here:
            $message = "test vijay";
            
            $ctx = stream_context_create();
         
            if ($production) {
               stream_context_set_option($ctx, 'ssl', 'local_cert', 'others/cirrbAppProduction.pem') ;
            }else{
               stream_context_set_option($ctx, 'ssl', 'local_cert',  'others/cirrbAppDevelopment.pem');
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
   }
   #end of the fucnton

}

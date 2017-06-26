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

class apiCronController extends Controller
{


///////////////
public function partnerDenyResponse( Request $request ){

        # Notification Code Starts

        $partner_response = PartnerResponse::where("order_id","=",$request->order_id)->where("partner_id","=",$request->partner_id);
        $partner_response->update(["response"=>"not respond"]);

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

       return json_encode(array('status' => 'success'));

        # Notification Code Ends

  }
///////////////




}

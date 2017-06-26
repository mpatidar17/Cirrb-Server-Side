<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Branch;
use App\Models\Menu;
use App\Models\OrderList;


class orderController extends Controller
{
    public function index(){

    	$orders = Order::paginate(15);

    	return View::make('adminpanel.order')->with('orders',$orders);

    }
    public function show( $id ){

    	$order = Order::find($id);

    	$orderlists = Order::find($id)->order_list;

    	return View::make('adminpanel.orderDetail')
    	 ->with('orderlists',$orderlists)
    	 ->with('order',$order);
    }
    public function update( $id, Request $request ){

    	$order = Order::find($id);
    	
        $order->status = $request->status;

        $order->save();

        return json_encode(array('status' => 'success', 'message'=>'Status Changed Successfully'));

    }
}

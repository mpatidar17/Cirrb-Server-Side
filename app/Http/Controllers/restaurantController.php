<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\Menu;
use View;
use Input;
use Validator;
use Redirect;
use Response;
use Session;
use URL;

class restaurantController extends Controller
{
  public function __construct(){

      $this->middleware('auth');

    }

  public function index(){

    $restaurants = Restaurant::paginate(15);

    return View::make('adminpanel.restaurant')->with('restaurants',$restaurants);

  }
  public function store(){

    $restaurant = new Restaurant;

    $rules = [

      'name' => 'required|string|max:255',
      'phone' => 'required|numeric',
      'email' => 'required|email',

      ];


    $validator = Validator::make(Input::all(),$rules);

    if($validator->fails()){

      return Redirect::to('/restaurants')
      ->withErrors($validator)
      ->withInput(Input::except('password'));

    }

    $restaurant->approved = Input::get('approval');
    $restaurant->name = Input::get('name');
    $restaurant->description = Input::get('description');
    $restaurant->phone = Input::get('phone');
    $restaurant->email = Input::get('email');

    

     if(Input::hasFile('image')){

      $fileName = Input::file('image')->getClientOriginalName();

      Input::file('image')->move("images",$fileName);

      $restaurant->image = URL::to("/images/$fileName");
   
    }else{

      $restaurant->image = URL::to("/images/restaurent-1.png");
    }

    if(Input::get('approval') == "y"){
    	 $restaurant->approved_on = date('Y-m-d h:i:s') ;
    }	

    //$restaurant->approved_on = (Input::get('approval') == "y") ? date('Y-m-d h:i:s') : "0000-00-00 00:00:00";
    $restaurant->save();
    
    Session::flash("message","Restaurant Created Successfully");

    return Redirect::to("/restaurants");

  }
  public function show( $id ){

    $restaurant = Restaurant::find( $id );

    if( count($restaurant) == 0 ){
      return Redirect::to("/restaurants");

    }

    $branches = Restaurant::find( $id )->branches;

    $menus = Restaurant::find( $id )->menus;

    return View::make('adminpanel.detail')
    ->with('restaurant',$restaurant)
    ->with('branches',$branches)
    ->with('menus',$menus);

  }
  public function update( $restaurant_id ){

    $restaurant = Restaurant::find( $restaurant_id );

    $data = array(
      'name' => Input::get('name'),
      'email' => Input::get('email'),
      'phone' => Input::get('phone'),
      'description' => Input::get('description'),
    );


      $restaurant->name = $data['name'];
      $restaurant->email = $data['email'];
      $restaurant->description = $data['description'];
      
      if(Input::hasFile('image')){

        $fileName = Input::file('image')->getClientOriginalName();

        Input::file('image')->move("images",$fileName);

        $restaurant->image = URL::to("/images/$fileName");
     
      }
      
      $restaurant->phone = $data['phone'];
      $restaurant->save();

      Session::flash("message","Restaurant Updted Successfully");

      return Redirect::to('/restaurants/'.$restaurant_id);

      // return json_encode(array('status' => 'success','details' => $data ));

  }
  public function destroy($id){

    $restaurant = Restaurant::find($id);

    $restaurant->branches()->delete();

    $restaurant->menus()->delete();

    $restaurant->delete();

    return json_encode(array('success' => 'success','message'=>'Restaurant Deleted Successfully' ));

  }
  
  public function restaurantApproval( Request $request ){

    $restaurant = Restaurant::find($request->restaurant_id);

    if( $request->action == 'disapprove' ){
    
      $restaurant->approved = "n";
      $restaurant->approved_on = date("Y-m-d h:i:s");
    
    }
    else{

      $restaurant->approved = "y";
      $restaurant->approved_on = date("Y-m-d h:i:s");

    }

    $restaurant->save();

  }
}

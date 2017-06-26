<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use View;
use Validator;
use Redirect;
use Input;
use Session;
use URL;
use Mail;

class partnerController extends Controller
{

	/*
	* Get list of Partners
  *
  * @return Response
	*/


  public function index(){

    $partners = User::where("roles","=","partner")
    ->paginate(15);

    return View::make("adminpanel.partnerList")->with("partners",$partners);

  }

  /*
  * Get a Partner
  *
  * @params int $id
  *
  * @return Response
  */

  public function show( $id ){

    $partner = User::find($id);


    if($partner->count() == 0){

      return Redirect::to("/partners");
 
    }

    return View::make("adminpanel.partnerDetail")->with("partner",$partner);

  }

  /*
  * Create a Partner
  *
  * @return Response
  */

  public function store(){

    $rules = [
    'name'=>'required|string',
    'email'=>'required|email|string',
    'phone'=>'required|numeric',
    'password' => 'required',
    ]; 

    $validator = Validator::make(Input::all(),$rules);

    if($validator->fails()){

      return Redirect::to('/partners')
      ->withErrors($validator)
      ->withInput(Input::except('password'));

    }

      $partner = new User;
      $password = bcrypt(Input::get('password'));
      $verification_token = md5(uniqid(rand(), true));

      $partner->display = Input::get('display');
      $partner->name = Input::get('name');
      $partner->last_name = Input::get('last_name');
      $partner->email = Input::get('email');
      $partner->phone = Input::get('phone');
      $partner->password = $password;
      $partner->order_limit = empty(Input::get('order_limit')) ? 500 : Input::get('order_limit');
      $partner->balance = Input::get('balance');
      $partner->image = URL::to('/images/new-user-image-default.png');
      $partner->status = Input::get('status');
      $partner->roles = 'partner';
      $partner->verified = 0;
      $partner->verification_token = $verification_token;
      $partner->save();

      $data = ['verification_token' => $verification_token,'name' => Input::get('name')];

      Mail::send('emails.emailVerification', $data, function($message) {
         $message->to(Input::get('email'),'')->subject
            ('Confirm Email to Register');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
      });


      Session::flash("message","Partner Created Successfully");

      return Redirect::to("/partners");

  }

  /*
  * Update a Partners
  * 
  * @param int $id
  *
  * @return Response
  */

  public function update( $id ){

    $rules = [
    'name'=>'required|string',
    'email'=>'required|email|string',
    'phone'=>'required|numeric',
    ]; 

    $validator = Validator::make(Input::all(),$rules);

    if($validator->fails()){

      return Redirect::to("/partners/$id")
      ->withErrors($validator)
      ->withInput(Input::except('password'));

    }

      $partner = User::find($id);

      $partner->display = Input::get('display');
      $partner->name = Input::get('name');
      $partner->last_name = Input::get('last_name');
      $partner->email = Input::get('email');
      $partner->phone = Input::get('phone');
      $partner->order_limit = empty(Input::get('order_limit')) ? 500 : Input::get('order_limit');
      $partner->balance = Input::get('balance');
      $partner->status = Input::get('status');
      $partner->save();

      Session::flash("message","Partner Updated Successfully");

      return Redirect::to("/partners/$id");


  }

  /*
  * Delete a Partners
  * 
  * @param int $id
  *
  * @return Response
  */

  public function destroy( $id ){

    $partner = User::find($id);      

    $partner->delete();

    Session::flash("message","Partner Deleted Successfully");

  }
}

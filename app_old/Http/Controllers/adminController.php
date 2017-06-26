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

class adminController extends Controller
{

	/*
	* Get list of Admins
  *
  * @return Response
	*/


  public function index(){

    $admins = User::where("roles","=","admin")
    ->paginate(15);

    return View::make("adminpanel.adminList")->with("admins",$admins);

  }

  /*
  * Get a Admin
  *
  * @params int $id
  *
  * @return Response
  */

  public function show( $id ){

    $admin = User::find($id);


    if($admin->count() == 0){

      return Redirect::to("/admins");
 
    }

    return View::make("adminpanel.adminDetail")->with("admin",$admin);

  }

  /*
  * Create a Admin
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

      return Redirect::to('/admins')
      ->withErrors($validator)
      ->withInput(Input::except('password'));

    }

      $admin = new User;
      $password = bcrypt(Input::get('password'));
      $verification_token = md5(uniqid(rand(), true));

      $admin->display = Input::get('display');
      $admin->name = Input::get('name');
      $admin->last_name = Input::get('last_name');
      $admin->email = Input::get('email');
      $admin->phone = Input::get('phone');
      $admin->password = $password;
      $admin->order_limit = empty(Input::get('order_limit')) ? 500 : Input::get('order_limit');
      $admin->balance = Input::get('balance');
      $admin->image = URL::to('/images/new-user-image-default.png');
      $admin->status = Input::get('status');
      $admin->roles = 'admin';
      $admin->verified = 0;
      $admin->verification_token = $verification_token;
      $admin->save();

      $data = ['verification_token' => $verification_token,'name' => Input::get('name')];

      Mail::send('emails.emailVerification', $data, function($message) {
         $message->to(Input::get('email'),'')->subject
            ('Confirm Email to Register');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
      });


      Session::flash("message","Admin Created Successfully");

      return Redirect::to("/admins");

  }

  /*
  * Update a Admin
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

      return Redirect::to("/admins/$id")
      ->withErrors($validator)
      ->withInput(Input::except('password'));

    }

      $admin = User::find($id);

      $admin->display = Input::get('display');
      $admin->name = Input::get('name');
      $admin->last_name = Input::get('last_name');
      $admin->email = Input::get('email');
      $admin->phone = Input::get('phone');
      $admin->order_limit = empty(Input::get('order_limit')) ? 500 : Input::get('order_limit');
      $admin->balance = Input::get('balance');
      $admin->status = Input::get('status');
      $admin->save();

      Session::flash("message","Admin Updated Successfully");

      return Redirect::to("/admins/$id");


  }

  /*
  * Delete a Admin
  * 
  * @param int $id
  *
  * @return Response
  */

  public function destroy( $id ){

    $admin = User::find($id);      

    $admin->delete();

    Session::flash("message","Admin Deleted Successfully");

  }
}

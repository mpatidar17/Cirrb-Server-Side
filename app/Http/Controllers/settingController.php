<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use View;
use Input;
use Session;
use Redirect;

class settingController extends Controller
{
   
	public function showSettings(){

		$settings = Setting::all();

		return View::make("adminpanel.settings")
		->with("settings",$settings);

	}
	public function updateSettings( Request $request ){

		$values = Input::get("settings");

		foreach( $values as $key=>$value ){

			$setting = Setting::find($key);

			if(!is_numeric($value)){

				return Redirect::to("/settings")->withErrors(["Please enter only numeric values"]);

			}

			$setting->value = $value;

			$setting->save();

		 }

		 Session::flash("message","Settings Saved");

		 return Redirect::to("/settings");

	}
}

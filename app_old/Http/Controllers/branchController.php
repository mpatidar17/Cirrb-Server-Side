<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Branch;
use Input;
use Redirect;

class branchController extends Controller
{

    public function index(){

      $restaurant_id = Input::get("restaurant_id");

      $branches = Branch::where('restaurant_id','=',$restaurant_id)->get();

      $response = array('status' => 'success','errors' => 0,'branches'=>$branches );

      echo json_encode($response);die;

    }

    public function store(){

      $branch = new Branch;

      $branch->restaurant_id = Input::get('restaurant_id');
      $branch->name = Input::get('name');
      $branch->bl_lat = Input::get('lat');
      $branch->bl_long = Input::get('long');
      $branch->save();

      return json_encode(array('status' => 'success','message' => 'Branch Created Successfully' ));

    }

    public function update( $id, Request $request ){

      $branch = Branch::find( $id );

      $branch->restaurant_id = $request->restaurant_id;
      $branch->name = $request->name;
      $branch->bl_lat = $request->lat;
      $branch->bl_long = $request->long;
      $branch->save();


    }

    public function destroy($id){

      $branch = Branch::find($id);

      $branch->delete();

      return json_encode(array('status' => 'success','message' => 'Branch Deleted' ));

    }
}

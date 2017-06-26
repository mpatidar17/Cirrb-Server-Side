<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Menu;
use Input;
use Redirect;
use URL;

class menuController extends Controller
{
    public function store( Request $request ){

      $menu = new Menu;

      $data = array(
        'restaurant_id' => Input::get('restaurant_id'),
        'name' => Input::get('name'),
        'description' => Input::get('description'),
        'price' => Input::get('price'),
        );

      $menu->restaurant_id = $data['restaurant_id'];      
      $menu->branch_id = 0; 
      $menu->name = $data['name'];
      $menu->description = $data['description'];
      $menu->price = $data['price'];


      if($request->hasFile('image')){

        $fileName = $request->image->getClientOriginalName();

        $request->image->move("images",$fileName);

        $menu->image = URL::to("/images/$fileName");
     
      }
      else{

        $menu->image = URL::to("/images/menu-1.png");

      }

      $menu->save();

      return json_encode(['status' => 'success','details' => $data]);

    }

    public function edit( $menu_id ){

      $menu = Menu::find( $menu_id );



      return View::make('adminpanel.updateMenu')->with("menu",$menu);

    }

    public function update( $menu_id, Request $request ){

    $menu = Menu::find( $menu_id );

    $data = array(
      'name' => Input::get('name'),
      'description' => Input::get('description'),
      'price' => Input::get('price'),
      'restaurant_id' => Input::get('restaurant_id'),
    );


      $menu->name = $data['name'];
      $menu->description = $data['description'];
      $menu->price = $data['price'];
      $menu->restaurant_id = $data['restaurant_id'];

      if($request->hasFile('image')){
        
        $fileName = $request->image->getClientOriginalName();

        $request->image->move("images",$fileName);

        $menu->image = URL::to("/images/$fileName");
     
      }
      $menu->save();

      return Redirect::to("/restaurants/".$data['restaurant_id']);

      //return json_encode(array('status' => 'success','details' => $data ));

  }
  public function destroy( $menu_id ){

    $menu = Menu::find($menu_id);

    $menu->delete();

  }
}

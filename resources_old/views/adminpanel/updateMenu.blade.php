@extends('adminpanel.cirrb')

@section('page-title')
Edit Menu
@endsection

@section('content')
{{ Html::ul($errors->all()) }}
    {{ Form::model($menu,array( 'route' => array('menus.update',$menu->id),'method'=>'PUT','enctype'=>'multipart/form-data' )) }}   
              
              {{ Form::label('image','Image:') }}
              {{ Form::file('image') }}


              {{ Form::label('name','Name:') }}
              {{ Form::text('name',$menu->name,array('class'=>'form-control')) }}

              {{ Form::label('description','Description:') }}
              {{ Form::textarea('description',$menu->description,array('class'=>'form-control', 'id' => 'pwd')) }}

              {{ Form::label('price','Price:') }}
              {{ Form::text('price',$menu->price,array('class'=>'form-control', 'id' => 'pwd')) }}

              {{ Form::hidden( 'restaurant_id',$menu->restaurant->id ) }}

              {{ Form::submit('Create Menu',array("class"=>"btn btn-primary")) }}

    {{ Form::close() }}

@endsection
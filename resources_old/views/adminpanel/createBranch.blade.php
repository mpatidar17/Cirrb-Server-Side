@extends('adminpanel.cirrb')

@section('content')


    {{ Form::open(array( 'url'=> 'branches' )) }}  
          
             <p>New Restaurant</p>  
         
                {{ Form::label('name','Name:') }}
                {{ Form::text('name',Input::old('name'),array('class'=>'form-control')) }}
              

              {{ Form::label('bl_lat','Latitude:') }}
              {{ Form::text('bl_lat',Input::old('bl_lat'),array('class'=>'form-control', 'id' => 'pwd')) }}

              {{ Form::label('bl_long','Longitude:') }}
              {{ Form::text('bl_long',Input::old('bl_long'),array('class'=>'form-control', 'id' => 'pwd')) }}

          {{ Form::hidden( 'restaurant_id',$restaurant_id ) }}

            {{ Form::submit('Create Branch') }}

    {{ Form::close() }}



@endsection
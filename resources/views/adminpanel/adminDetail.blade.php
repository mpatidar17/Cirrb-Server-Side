@extends('adminpanel.cirrb')

@section('page-title')

  {{ $admin->name }}


@endsection

@section('content')

{{ Html::ul( $errors->all() ) }}

@if( Session::has("message") )
  <div class="alert alert-success">{{ Session::get("message") }}</div>
@endif

<div class="alert alert-error messages"></div>
{{ Form::open(array("url" => "/admins/$admin->id" ,'method'=> "PUT") ) }}

<button type="button" class="add-restaurant" id="edit-admin-btn">
  <span class="fa fa-plus"></span> Edit Admin
</button>
<button type="submit" class="save-btn field-hide">
  <span class="fa fa-plus"></span> Save
</button>
<div class="restaurant-result">

  <div id="response_message"></div>

  <div class="row">  
    <div class="col-md-6">
      <h5>Image:</h5>
    </div>
    <div class="col-md-6">
      <span><img style="width: 200px;" src="{{ $admin->image }}"></span>
      
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Display Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $admin->display }}</span>
      {{ Form::text('display',$admin->display,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>First Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $admin->name }}</span>
      {{ Form::text('name',$admin->name,array('class'=>'form-control field-hide','required' => 'required')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Last Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $admin->last_name }}</span>
      {{ Form::text('last_name',$admin->last_name,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Email:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $admin->email }}</span>
      {{ Form::text('email',$admin->email,array('class'=>'form-control field-hide','required' => 'required')) }}
    </div>
  </div>
  <hr>


  <div class="row">  
    <div class="col-md-6">
      <h5>Phone:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $admin->phone }}</span>
      {{ Form::text('phone',$admin->phone,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Cash Limit:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">SR {{ $admin->order_limit }}</span>
      {{ Form::text('order_limit',$admin->order_limit,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Cash In Hand:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">SR {{ $admin->balance }}</span>
      {{ Form::text('balance',$admin->balance,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Status:</h5>
    </div>
    <div class="col-md-6">
    <span class="field-show">{{ ($admin->status == 1) ? "Active" : "Inactive" }}</span>
      {{ Form::select('status',array('1' => 'Active','0' => 'Deactive'),$admin->status,array( 'class' => 'form-control field-hide')) }}
    </div>
  </div>  
</div>

{{ Form::close() }}


@endsection

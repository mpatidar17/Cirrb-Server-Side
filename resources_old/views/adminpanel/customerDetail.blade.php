@extends('adminpanel.cirrb')

@section('page-title')

  {{ $user->name }}

@endsection

@section('content')

<!-- {{ Html::ul( $errors->all() ) }} -->

<div class="alert alert-error messages"></div>
{{ Form::open(array('url' => "/customers/$user->id",'method' => 'PUT' ,'id'=> 'edit-customer') ) }}

{{ Form::hidden('user_id',$user->id,array('id'=>'user_id')) }}

<button type="button" class="add-restaurant" id="edit-customer-btn">
  <span class="fa fa-plus"></span> Edit Customer
</button>
<button type="submit" class="add-customer save-btn field-hide">
  <span class="fa fa-plus"></span> Save
</button>
<div class="restaurant-result">

  <div id="response_message"></div>

  <div class="row">  
    <div class="col-md-6">
      <h5>Image:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show display"><img style="width: 200px;" src="{{ $user->image }}" /></span>
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Display Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show display">{{ $user->display }}</span>
      {{ Form::text('display',$user->display,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>First Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $user->name }}</span>
      {{ Form::text('name',$user->name,array('class'=>'form-control field-hide','required' => 'required')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Last Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $user->last_name }}</span>
      {{ Form::text('last_name',$user->last_name,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Email:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $user->email }}</span>
      {{ Form::text('email',$user->email,array('class'=>'form-control field-hide','required' => 'required')) }}
    </div>
  </div>
  <hr>


  <div class="row">  
    <div class="col-md-6">
      <h5>Phone:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $user->phone }}</span>
      {{ Form::text('phone',$user->phone,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <!--<div class="row">  
    <div class="col-md-6">
      <h5>Password:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $user->password }}</span>
      {{ Form::text('password',$user->password,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr> -->

  <div class="row">  
    <div class="col-md-6">
      <h5>Order Limit:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $user->order_limit }}</span>
      {{ Form::text('order_limit',$user->order_limit,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Balance:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">SR {{ $user->balance }}</span>
      {{ Form::text('balance',$user->balance,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Status:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ ($user->status == 1) ? "Active" : "Inactive" }}</span>
      {{ Form::select('status',array('1' => 'Active','0' => 'Deactive'),$user->status,array( 'class' => 'form-control field-hide')) }}
    </div>
  </div>  
</div>

{{ Form::close() }}


@endsection
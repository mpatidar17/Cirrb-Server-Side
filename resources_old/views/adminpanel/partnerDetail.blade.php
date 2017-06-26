@extends('adminpanel.cirrb')

@section('page-title')

  {{ $partner->name }}


@endsection

@section('content')

{{ Html::ul( $errors->all() ) }}

@if( Session::has("message") )
  <div class="alert alert-success">{{ Session::get("message") }}</div>
@endif

<div class="alert alert-error messages"></div>
{{ Form::open(array("url" => "/partners/$partner->id" ,'method'=> "PUT") ) }}

<button type="button" class="add-restaurant" id="edit-partner-btn">
  <span class="fa fa-plus"></span> Edit Partner
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
      <span class=""><img style="width: 200px;" src="{{ $partner->image }}"></span>
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Display Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $partner->display }}</span>
      {{ Form::text('display',$partner->display,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>First Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $partner->name }}</span>
      {{ Form::text('name',$partner->name,array('class'=>'form-control field-hide','required' => 'required')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Last Name:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $partner->last_name }}</span>
      {{ Form::text('last_name',$partner->last_name,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Email:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $partner->email }}</span>
      {{ Form::text('email',$partner->email,array('class'=>'form-control field-hide','required' => 'required')) }}
    </div>
  </div>
  <hr>


  <div class="row">  
    <div class="col-md-6">
      <h5>Phone:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">{{ $partner->phone }}</span>
      {{ Form::text('phone',$partner->phone,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Cash Limit:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">SR {{ $partner->order_limit }}</span>
      {{ Form::text('order_limit',$partner->order_limit,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Cash In Hand:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show">SR {{ $partner->balance }}</span>
      {{ Form::text('balance',$partner->balance,array('class'=>'form-control field-hide')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Status:</h5>
    </div>
    <div class="col-md-6">
    <span class="field-show">{{ ($partner->status == 1) ? "Active" : "Inactive" }}</span>
      {{ Form::select('status',array('1' => 'Active','0' => 'Deactive'),$partner->status,array( 'class' => 'form-control field-hide')) }}
    </div>
  </div>  
</div>

{{ Form::close() }}


@endsection
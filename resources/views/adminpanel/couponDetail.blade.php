@extends('adminpanel.cirrb')

@section('page-title')

  {{ $coupon->code }}

@endsection

@section('content')

<!-- {{ Html::ul( $errors->all() ) }} -->

<div class="alert alert-error messages"></div>
{{ Form::open(array('url' => "/coupon/$coupon->id",'method' => 'PUT' ,'id'=> 'edit-coupon') ) }}

{{ Form::hidden('coupon_id',$coupon->id,array('id'=>'coupon_id')) }}

<button type="button" class="add-restaurant" id="edit-customer-btn">
  <span class="fa fa-plus"></span> Edit Coupon
</button>
<button type="submit" class="add-customer save-btn field-hide">
  <span class="fa fa-plus"></span> Save
</button>
<div class="restaurant-result">

  <div id="response_message"></div>

  <div class="row">  
    <div class="col-md-6">
      <h5>Code:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-hide restaurant-email">{{ $coupon->code }}</span>
      {{ Form::text('code',$coupon->code ,array('class'=>'form-control', 'id' => 'code')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Type:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-hide restaurant-email">{{ $coupon->type }}</span>
      {{ Form::select('type',array('amount' => 'In Amount','percent' => 'In Percent'), $coupon->type , array( 'class' => 'form-control')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Start Date:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-hide restaurant-email">{{ $coupon->start_date }}</span>
      {{ Form::text('start_date',$coupon->start_date,array('class'=>'form-control', 'id' => 'start_date')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Value:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-hide restaurant-email">{{ $coupon->value }}</span>
      {{ Form::text('value', $coupon->value , array('class'=>'form-control', 'id' => 'value')) }}
    </div>
  </div>
  <hr>

  <div class="row">  
    <div class="col-md-6">
      <h5>Status:</h5>
    </div>
    <div class="col-md-6">
      <span class="restaurant-email">{{ ($coupon->status == '1') ? "Active" : "Inactive" }}</span>
      {{ Form::select('status',array('1' => 'Active','0' => 'Deactive'),$coupon->status,array( 'class' => 'form-control field-hide')) }}
    </div>
  </div>  
</div>

{{ Form::close() }}


@endsection
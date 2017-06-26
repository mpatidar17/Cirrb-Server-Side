@extends('adminpanel.cirrb')

@section('page-title')

Coupon

@endsection

@section('content')
<button class="add-restaurant" id="show-add-customer">
  <span class="fa fa-plus"></span> New Coupon
</button>

<div id = 'add-customer-form' style="display:none">
    {{ Form::open(array('id' => 'add-coupon')) }}
      <h3>New Coupon</h3>  
      <div id="response_message"></div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('code','Coupon Code:') }}
          {{ Form::text('code',Input::old('code'),array('class'=>'form-control', 'id' => 'code')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('type','Type:') }}
        (<font color="red">*</font>)
        {{ Form::select('type',array('amount' => 'In Amount','percent' => 'In Percent'),null ,array( 'class' => 'form-control')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{ Form::label('start_date','Start Date:') }}
          (<font color="red">*</font>)
          {{ Form::text('start_date',Input::old('start_date'),array('class'=>'form-control', 'id' => 'start_date')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{ Form::label('end_date','End Date:') }}
          {{ Form::text('end_date',Input::old('end_date'),array('class'=>'form-control', 'id' => 'end_date')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('value','Value:') }}
          {{ Form::text('value',Input::old('value'),array('class'=>'form-control', 'id' => 'value')) }}
        </div>
      </div>
      <div class="col-md-6"> 
        <div class="form-group">          
          {{ Form::label('status','Status:') }}
          {{ Form::select('status',array('1' => 'Active','0' => 'Deactive'),null ,array( 'class' => 'form-control')) }}
        </div>
       </div>
 
      <div class="col-md-12 all_buttns">
        <button type="submit" id="save-customer" class="add-customer save-btn">
        <span class="fa fa-check"></span> Save</button>
      </div> 
    {{ Form::close() }}
</div>


<div class="clearfix"></div>
  <div class="table-box">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Code</th>
        <th>Type</th>
        <th>Value</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $coupons as $coupon )

        <tr>
          <td>{{ $coupon->id }}</td>
          <td>{{ $coupon->code }}</td>
          <td>{{ $coupon->type }}</td>
          <td>{{ $coupon->value }}</td>
          <td>{{ $coupon->start_date }}</td>
          <td>{{ $coupon->end_date }}</td>
          <td>{{ $coupon->order_limit }}</td>
          <td><a href="javascript:void(0)" onclick="redirectMeCustomer('{{$coupon->id}}')">Show</a> | <a href="javascript:void(0)" onclick="deleteCustomer('{{$coupon->id}}')">Delete</a></td>
        </tr>

      @endforeach

    </tbody>
  </table>
  
@endsection
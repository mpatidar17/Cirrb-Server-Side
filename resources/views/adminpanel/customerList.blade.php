@extends('adminpanel.cirrb')

@section('page-title')

Customers

@endsection

@section('content')
<button class="add-restaurant" id="show-add-customer">
  <span class="fa fa-plus"></span> New Customer
</button>

<div id = 'add-customer-form' style="display:none">
    {{ Form::open(array('id' => 'add-customer')) }}  
      <h3>New Customer</h3>  
      <div id="response_message"></div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('display','Display Name:') }}
          {{ Form::text('display',Input::old('display'),array('class'=>'form-control', 'id' => 'display')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{ Form::label('name','First Name:') }}
          (<font color="red">*</font>)
          {{ Form::text('name',Input::old('name'),array('class'=>'form-control', 'id' => 'name')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{ Form::label('last_name','Last Name:') }}
          {{ Form::text('last_name',Input::old('last_name'),array('class'=>'form-control', 'id' => 'last_name')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('email','Email:') }}
        (<font color="red">*</font>)
        {{ Form::email('email',Input::old('email'),array('class'=>'form-control', 'id' => 'email')) }}
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('phone','Phone:') }}
          {{ Form::text('phone',Input::old('phone'),array('class'=>'form-control', 'id' => 'phone')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('password','Password:') }}
        (<font color="red">*</font>)
        {{ Form::password('password',array('class'=>'form-control', 'id' => 'password')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('order_limit','Order Limit:') }}
        {{ Form::text('order_limit',Input::old('order_limit'),array('class'=>'form-control', 'id' => 'order_limit')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('balance','Balance:') }}
        {{ Form::text('balance',Input::old('balance'),array('class'=>'form-control', 'id' => 'balance')) }}
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
        <th></th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Last Login</th>
        <th>Balance</th>
        <th>Order Limit</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $users as $user )

        <tr>
          <td style="width: 10%;"><img style="width: 100%;" src="{{ $user->image }}" /></td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->last_name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->phone }}</td>
          <td>{{ $user->last_login }}</td>
          <td>SR {{ $user->balance }}</td>
          <td>{{ $user->order_limit }}</td>
          <td><a href="javascript:void(0)" onclick="redirectMeCustomer('{{$user->id}}')">Show</a> | <a href="javascript:void(0)" onclick="deleteCustomer('{{$user->id}}')">Delete</a> | <a href='{{URL::to("/change-password/$user->id")}}'>Change Password</a><!-- New --> | <a onclick='sendNotification("{{ $user->id }}","{{ $user->status }}")' >Send Notification</a><!-- New --></td>
        </tr>

      @endforeach

    </tbody>
  </table>
  {{ $users->links() }}
@endsection

<!-- Admins List Page extending cirrb template -->

@extends("adminpanel.cirrb")

@section("page-title")

Admins

@endsection

@section('content')

@if( Session::has("message") )
  <div class="alert alert-success">{{ Session::get("message") }}</div>
@endif

<button class="add-restaurant" id="show-add-admin">
  <span class="fa fa-plus"></span> New Admin
</button>

<div id = 'add-admin-form' style="display:none">
    {{ Form::open(array('url'=>'/admins')) }}  
      <h3>New admin</h3>  
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

          <span class="error">{{ ($errors->has('name')) ? $errors->first('name') : "" }}</span>
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

        <span class="error">{{ ($errors->has('email')) ? $errors->first('email') : "" }}</span>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('phone','Phone:') }}
          {{ Form::text('phone',Input::old('phone'),array('class'=>'form-control', 'id' => 'phone')) }}

          <span class="error">{{ ($errors->has('phone')) ? $errors->first('phone') : "" }}</span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('password','Password:') }}
        (<font color="red">*</font>)
        {{ Form::password('password',array('class'=>'form-control', 'id' => 'password ')) }}

        <span class="error">{{ ($errors->has('password')) ? $errors->first('password') : "" }}</span>
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
        <button type="submit" id="save-admin" class="save-btn">
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
        <th>Cash In Hand</th>
        <th>Cash Limit</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $admins as $admin )

        <tr>
          <td style="width: 10%;"><img style="width: 100%;" src="{{ $admin->image }}"></td>
          <td>{{ $admin->name }}</td>
          <td>{{ $admin->last_name }}</td>
          <td>{{ $admin->email }}</td>
          <td>{{ $admin->phone }}</td>
          <td>{{ $admin->last_login }}</td>
          <td>SR {{ $admin->balance }}</td>
          <td>SR {{ $admin->order_limit }}</td>
          <td><a href='{{ URL::to("/admins/$admin->id") }}'>Show</a> | <a href="javascript:void(0)" onclick="deleteAdmin('{{$admin->id}}')">Delete</a> | <a href='{{URL::to("/change-password/$admin->id")}}'>Change Password</a></td>
        </tr>

      @endforeach

    </tbody>
  </table>
{{ $admins->links() }}
@endsection
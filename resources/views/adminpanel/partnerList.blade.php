<!-- Partners List Page extending cirrb template -->

@extends("adminpanel.cirrb")

@section("page-title")

Partners

@endsection

@section('content')

@if( Session::has("message") )
  <div class="alert alert-success">{{ Session::get("message") }}</div>
@endif

<button class="add-restaurant" id="show-add-partner">
  <span class="fa fa-plus"></span> New Partner
</button>

<div id = 'add-partner-form' style="display:none">
    {{ Form::open(array('url'=>'/partners','enctype'=>'multipart/form-data')) }}  
      <h3>New Partner</h3>  
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
        {{ Form::label('balance','Cash_in_hand:') }}
        {{ Form::text('balance',Input::old('balance'),array('class'=>'form-control', 'id' => 'balance')) }}
        </div>
      </div>
      <div class="col-md-6"> 
        <div class="form-group">          
          {{ Form::label('status','Status:') }}
          {{ Form::select('status',array('1' => 'Active','0' => 'Deactive'),null ,array( 'class' => 'form-control')) }}
        </div>
       </div>

      <div class="col-md-6"> 
        <div class="form-group">          
          {{ Form::label('commission','Commission:') }}
          {{ Form::text('commission',Input::old('commission'),array('class'=>'form-control', 'id' => 'commission')) }}
        </div>
       </div>
       
      <div class="form-group">          
          {{ Form::label('image','Image:') }}
          {{ Form::file('image') }}
        </div>
 
      <div class="col-md-12 all_buttns">
        <button type="submit" id="save-partner" class="save-btn">
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
      @foreach( $partners as $partner )

        <tr>
          <td style="width: 10%;"><img style="width: 100%;" src="{{ $partner->image }}"></td>
          <td>{{ $partner->name }}</td>
          <td>{{ $partner->last_name }}</td>
          <td>{{ $partner->email }}</td>
          <td>{{ $partner->phone }}</td>
          <td>{{ $partner->last_login }}</td>
          <td>SR {{ $partner->cash_in_hand }}</td>
          <td>SR {{ $partner->order_limit }}</td>
          <td><a href='{{ URL::to("/partners/$partner->id") }}'>Show</a> | <a href="javascript:void(0)" onclick="deletePartner('{{$partner->id}}')">Delete</a> | <a href='{{URL::to("/change-password/$partner->id")}}'>Change Password</a><!-- New --> | <a onclick='sendNotification("{{ $partner->id }}","{{ $partner->status }}")' >Send Notification</a><!-- New --></td>
        </tr>

      @endforeach

    </tbody>
  </table>
{{ $partners->links() }}
@endsection

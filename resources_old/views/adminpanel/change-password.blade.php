@extends('adminpanel.cirrb')

@section('page-title')
	Reset Password
@endsection

@section('content')
{{ Html::ul($errors->all()) }}
@if(Session::has('message'))
<div class="alert alert-success">
  
  {{ Session::get('message') }}

</div>
@endif
{{ Form::open(array("url"=>"/reset-password/$user->id","method"=>"PUT")) }}
<div class="form-group">

  {{ Form::label("password","Password") }}
  {{ Form::password("password",array("class"=>"form-control")) }}

</div>
<div class="form-group">

  {{ Form::label("password_confirmation","Confirm Password") }}
  {{ Form::password("password_confirmation",array("class"=>"form-control")) }} 

</div>

  {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@endsection
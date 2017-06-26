@extends('adminpanel.cirrb')

@section('page-title')
	Notification
@endsection

@section('content')
{{ Html::ul($errors->all()) }}
@if(Session::has('message'))
<div class="alert alert-success">
  
  {{ Session::get('message') }}

</div>
@endif
{{ Form::open(array("url"=>"/notifications/","method"=>"POST")) }}

    <div class="form-group">
        {{ Form::label("to", "To") }}
        {{ Form::text("to", (!empty($user->name)) ? $user->name : $user->email , array('class' => 'form-control','disabled'=>'disabled')) }}
    </div>
    <div class="form-group">
        {{ Form::label("message", "Message") }}
        {{ Form::textarea("message","", array('class' => 'form-control')) }}
    </div>
    {{ Form::hidden("user_id",$user->id) }}

  {{ Form::submit('Send', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@endsection
@extends('adminpanel.cirrb')

@section('page-title')
	Settings
@endsection

@section('content')
{{ Html::ul($errors->all()) }}
@if(Session::has('message'))
<div class="alert alert-success">
  
  {{ Session::get('message') }}

</div>
@endif
{{ Form::open(array('url'=>'/updateSettings')) }}

  @foreach( $settings as $setting )

    <div class="form-group">
        {{ Form::label("settings[$setting->id]", "$setting->display_name (SR)") }}
        {{ Form::text("settings[$setting->id]", $setting->value, array('class' => 'form-control')) }}
    </div>

  @endforeach

  {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@endsection
@extends('adminpanel.cirrb')

@section('page-title')
  Restaurants
@endsection

@section('content')
@if(Session::has('message'))
<div class="alert alert-success">
  
  {{ Session::get('message') }}

</div>
@endif
  {{ Html::ul($errors->all()) }}

<div class="restaurant-box"> 
  <div class="col-md-12">
  <div class="flash-messages"></div>
    <button class="add-restaurant" id="show-add-restaurant"><span class="fa fa-plus"></span> New Restaurant</button>
    </div>
    <div id = 'add-restaurant-form'>
       {{ Form::open(array('url'=>'/restaurants','id' => 'add-restaurant','enctype'=>"multipart/form-data")) }}  
        <div class="col-md-12">
         <p>New Restaurant</p>  
          <div class="form-group">          
            {{ Form::label('approval','Approved / Unapproved:') }}
            {{ Form::select('approval',array('' => 'Select Value','y' => 'Approved' ,'n' => 'Unapproved'),null ,array( 'class' => 'form-control')) }}
          </div>
        </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('restaurant','Restaurant Name:') }}
          {{ Form::text('name',Input::old('name'),array('class'=>'form-control', 'id' => 'pwd')) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('desctiption','Description:') }}
          {{ Form::textarea('description',Input::old('description'),array('class'=>'form-control', 'id' => 'pwd')) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {{ Form::label('image','Image:') }}
          {{ Form::file('image') }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{ Form::label('phone','Phone:') }}
          {{ Form::text('phone',Input::old('phone'),array('class'=>'form-control', 'id' => 'pwd')) }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        {{ Form::label('email','Email:') }}
          {{ Form::email('email',Input::old('email'),array('class'=>'form-control', 'id' => 'pwd')) }}
        </div>
      </div>
      <div class="col-md-12 all_buttns">
      <button type="submit" id="save-restaurant" class="add-restaurant save-btn"><span class="fa fa-check"></span> Save</button>
      <!-- <button class="add-restaurant open-btn"><span class="fa fa-arrow-right"></span> Save & Open</button> -->
  </div> 
    {{ Form::close() }}
</div>
</div>

<div class="clearfix"></div>
  <div class="table-box">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>Thumbnail</th>
        <th>Name</th>
        <th>Description</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Created On</th>
        <th>Approved On</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $restaurants as $restaurant )

        <tr>
          <td><img src="{{ $restaurant->image }}" height="70px" width="70px"></td>
          <td>{{ $restaurant->name }}</td>
          <td>{{ $restaurant->description }}</td>
          <td>{{ $restaurant->phone }}</td>
          <td>{{ $restaurant->email }}</td>
          <td>{{ $restaurant->created_at }}</td>
          <td>{{ $restaurant->approved_on }}</td>
          <td><a href="javascript:void(0)" onclick="redirectMe('{{$restaurant->id}}')">Show</a> | <a href="javascript:void(0)" onclick="deleteResturant('{{$restaurant->id}}')">Delete</a></td>
        </tr></a>

      @endforeach

    </tbody>
  </table>
  </div>
{{ $restaurants->links() }}
@endsection
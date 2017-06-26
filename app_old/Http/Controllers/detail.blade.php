@extends('adminpanel.cirrb')

@section('content')

<button class="add-restaurant" id="show-add-restaurant"><span class="fa fa-plus"></span> Edit Restaurant</button>
<div class="restaurant-result">
  <div class="col-md-6">
    <p>Description:</p>
  </div>
  <div class="col-md-6">
    <p>{{ $restaurant->Description }}</p>
  </div>
  <!-- end left hand side col-md-6 -->
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <h5>Phone:</h5>
      </div>
    <div class="col-md-6">
      {{ $restaurant->phone }}
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6">
      <h5>Email:</h5>
    </div>
    <div class="col-md-6">
      {{ $restaurant->email }}
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6">
      <h5>Created On:</h5>
    </div>
    <div class="col-md-6">
      {{ $restaurant->created_at }}
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6">
      <h5>Approved:</h5>
    </div>
    <div class="col-md-6">
      {{ ($restaurant->approved == 'n') ? 'Unapproved' : 'Approved' }}
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6">
      <h5>Approved On:</h5>
    </div>
    <div class="col-md-6">
      {{ $restaurant->approved_on }}
    </div>
  </div>  
    <!-- end left hand side col-md-6 -->
  </div>
</div>
<div class="clearfix"></div>
  <div class="table-box">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Lat</th>
        <th>Long</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $branches as $branch )

        <tr>
          <td>{{ $branch->name }}</td>
          <td>{{ $branch->bl_lat }}</td>
          <td>{{ $branch->bl_long }}</td>
          <td><a href="#"><a href="#">Edit</a> | <a href="#">Delete</a></td>
        </tr></a>

      @endforeach

    </tbody>
  </table>
  <a href="{{ URL::to('/branches/').'/'.$restaurant->id }}" class="add-restaurant" id="show-add-restaurant"><span class="fa fa-plus"></span> Add Branch</a>
<div class="clearfix"></div>
  <div class="table-box">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $menus as $menu )

        <tr>
          <td>{{ $menu->name }}</td>
          <td>{{ $menu->description }}</td>
          <td>{{ $menu->price }}</td>
          <td><a href="#"><a href="#">Edit</a> | <a href="#">Delete</a></td>
        </tr></a>

      @endforeach

    </tbody>
  </table>
  <a href="{{ URL::to('/menus').'/'.$restaurant->id }}" class="add-restaurant" id="show-add-restaurant"><span class="fa fa-plus"></span> Add Menu</a>  
@endsection
@extends('adminpanel.cirrb')

@section('page-title')

  {{ $restaurant->name }}

@endsection

@section('content')

{{ Html::ul( $errors->all() ) }}

  @if(Session::has("message"))
  <div class="alert alert-success">
  {{ Session::get("message") }}
  </div>
  @endif

  {{ Form::open(array('url' => "/restaurants/$restaurant->id" ,'method'=>'PUT','id'=> '','enctype'=>'multipart/form-data') ) }}
  {{ Form::hidden('restaurant_id',$restaurant->id,array('id'=>'restaurant_id')) }}
<button type="button" class="add-restaurant" id="edit-restaurant-btn"><span class="fa fa-plus"></span> Edit Restaurant</button>
<button type="submit" class="add-restaurant save-btn field-hide"><span class="fa fa-plus"></span> Save</button>
<div class="restaurant-result">
  <div class="col-md-6">
  {{ Form::text('name',$restaurant->name,array('class'=>'form-control field-hide','required' => 'required')) }}
    <div class="col-md-3">
      <p>Description:</p>
      <img class="field-show" src="{{ $restaurant->image }}" style="width: 100%;" />
    </div>
    <div class="col-md-9">
     <span class="field-show restaurant-description">{{ $restaurant->description }}</span>
     {{ Form::textarea('description',$restaurant->description,array('class'=>'form-control field-hide')) }}
     {{ Form::label('image','Image') }}
     {{ Form::file('image',["class"=>"field-hide","style"=>"display:none;"]) }}
    </div>

  </div>
   
  <!-- end left hand side col-md-6 -->
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <h5>Phone:</h5>
      </div>
    <div class="col-md-6">
      <span class="field-show restaurant-phone">{{ $restaurant->phone }}</span>
      {{ Form::text('phone',$restaurant->phone,array('class'=>'form-control field-hide','required' => 'required','max'=>'10')) }}
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6">
      <h5>Email:</h5>
    </div>
    <div class="col-md-6">
      <span class="field-show restaurant-email">{{ $restaurant->email }}</span>
     {{ Form::text('email',$restaurant->email,array('class'=>'form-control field-hide','required' => 'required')) }}
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
    @if($restaurant->approved == 'n')
    
    <div id="restaurantApprovedStatus">Not Approved Yet <a href='#' onclick='approveRestaurant()'>Approve</a></div>
    
    @else

    <div id="restaurantApprovedStatus">Approved <a href="#" onclick="disapproveRestaurant()">Disapprove</a></div>

    @endif
    
    </div>
  </div>
  <div class="row">  
    <div class="col-md-6">
      <h5>Approved On:</h5>
    </div>
    <div class="col-md-6">
      <div id="restaurantApprovedOn">{{ $restaurant->approved_on }}</div>
    </div>
  </div>  
    <!-- end left hand side col-md-6 -->
  </div>
</div>

{{ Form::close() }}










<div class="ui divider table-box"></div>
    
    <div class="ui grid">
      <div class="row">
        <div class="column">
          <div class="clearfix"></div>
          <div class="branch-list-heading">
            <h3>Branches</h3>
          </div>
          
          <div id="map" class="fullWidthMap">Loading map</div>
          
          <table  class="table table-bordered" id="branchesTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Lat</th>
                <th>Long</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5">
                  <!-- <div class="ui right floated small primary labeled icon button"
                    onclick="addBranch();">
                    <i class="user icon"></i> Add Branch
                  </div>
                  <div class="ui right floated small primary secondaryToPrimary labeled icon button"
                    id="saveBranchesButton" onClick="saveNewBranches();">
                    <i class="check icon"></i> Save
                  </div> -->
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    




















<!-- Brach List -->


<!--   <div class="table-box">
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

        <tr id="branch-table-cell-{{$branch->id}}">
          <td>{{ $branch->name }}</td>
          <td>{{ $branch->bl_lat }}</td>
          <td>{{ $branch->bl_long }}</td>
          <td><a href="#"><a href="javascript:void(0)" onclick="editBranch('{{$branch->id}}')">Edit</a> | <a href="javascript:void(0)" onclick="deleteBranch('{{$branch->id}}')">Delete</a></td>
        </tr></a>

      @endforeach

    </tbody>
  </table> -->
  <button class="add-restaurant" id="add-branch" onclick="addBranch();"><span class="fa fa-plus"></span> Add Branch</button>

<!-- End Branch List -->

<!-- Menu List -->
  
<div class="clearfix"></div>

  <div class="Menu-list-heading">
    <h3>Menus</h3>
  </div>
  <div class="table-box">
  {{Form::open(array("id"=>"menu-form","enctype"=>"multipart/form-data"))}}
    <table class="table table-bordered" id="menus-table">
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $menus as $menu )

        <tr id="menu-table-cell-{{$menu->id}}">
          <td><img src="{{ $menu->image }}" style="width: 10%" /></td>
          <td>{{ $menu->name }}</td>
          <td>{{ $menu->description }}</td>
          <td>SR {{ $menu->price }}</td>
          <td><a href="{{URL::to('/menus/'.$menu->id.'/edit')}}">Edit</a> | <a href="#-" onclick="deleteMenu('{{$menu->id}}')">Delete</a></td>
        </tr></a>

      @endforeach

    </tbody>
  </table>
  {{Form::close()}}
  <button class="add-restaurant" id="add-menu"><span class="fa fa-plus"></span> Add Menu</button>

<!-- End Menu List -->

@endsection

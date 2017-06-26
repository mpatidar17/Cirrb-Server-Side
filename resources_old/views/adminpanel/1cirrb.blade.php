<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnBaqlqhN_49ENEVVKe82NCYog0oL-j8o">
  </script>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style_2.css') }}" />
<?php $restaurant_id = isset($restaurant->id) ? $restaurant->id : "" ?>

<script type="text/javascript">
$(document).ready(function(){
    // $("#menu-toggle").click(function(e) {
    //     e.preventDefault();
    //     $("#wrapper").toggleClass("active");
    // });

    // /*Scroll Spy*/
    // $('body').scrollspy({ target: '#spy', offset:80});

    // /*Smooth link animation*/
    // $('a[href*=#]:not([href=#])').click(function() {
    //     if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

    //         var target = $(this.hash);
    //         target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //         if (target.length) {
    //             $('html,body').animate({
    //                 scrollTop: target.offset().top
    //             }, 1000);
    //             return false;
    //         }
    //     }
    // });
    $('#show-add-restaurant').click(function(e){
      $('#add-restaurant-form').toggle();
    });
     $("#edit-restaurant-btn").click(function(e){

        $(".field-show").toggle();
        $(".field-hide").toggle();

     });
    $(document).on('submit',"form#edit-restaurant",function(e){
          $.ajax({

            url:'{{ URL::to("/restaurants/$restaurant_id") }}/',
            type: 'put',
            data:$(this).serialize(),
            success:function(responseRAW){
              response = JSON.parse(responseRAW);
              $(".page-title").html(response.details.name);
              $(".restaurant-description").html(response.details.description);
              $(".restaurant-email").html(response.details.email);
              $(".restaurant-phone").html(response.details.phone);

              $(".field-show").show();
              $(".field-hide").hide();
            }
        });
        e.preventDefault();
    });

    

    $(document).on('click',"#add-menu",function(e){
        $("#menus-table").append('<tr id="form-table-cell"><td>{{Form::file("image",array("id"=>"menu-image"))}}</td><td>{{ Form::text("name","",array("class" =>"form-control menu-name","required"=>"required")) }}</td><td>{{ Form::text("description","",array("class" =>"form-control menu-discription","required"=>"required")) }}</td><td>{{ Form::text("price","",array("class" =>"form-control menu-price","required"=>"required")) }}</td>{{ Form::hidden("restaurant_id","$restaurant_id",array("class"=>"restaurant-id") ) }}<td><button type="button" id="save-add-menu" class="add-restaurant save-btn"><span class="fa fa-plus"></span> Save</button></td></tr>');
        $("#add-menu").hide();
    });
  $(document).on('click',"#save-add-menu, #save-add-menu > span",function(e){
    // debugger
    $("#menu-form").ajaxForm({
       url : '{{ URL::to("/menus") }}',
       type: "POST",
       success: function (response) {
        location.reload();
       }
    }).submit()

  });
});
function showEditMenu(menuID,menuName,menuDescription,menuPrice){

  $("#menu-table-cell-"+menuID).replaceWith('<tr id="form-table-cell"><td>{{Form::file("image")}}</td><td><input type="text" name="name" value="'+menuName+'" class="form-control menu-name"></td><td><input type="text" name="description" value="'+menuDescription+'" class="form-control menu-description"></td><td><input type="text" name="price" value="'+menuPrice+'" class="form-control menu-price"></td><input type="hidden" name="menu_id" class="menu-id" value="'+menuID+'"><input type="hidden" name="restaurant_id" class="restaurant-id" value="{{$restaurant_id}}"><td><button type="button" onclick="saveEditMenu('+menuID+')" class="add-restaurant save-btn"><span class="fa fa-plus"></span> Save</button></td></tr>');
  $("#add-menu").hide();

}

function deleteMenu( menu_id ){
  if(confirm("Are You Sure you want to delete this Menu ?")){
    $.ajax({

      url:'{{ URL::to("/menus") }}/'+menu_id,
      type:'delete',
      data:'_token={{csrf_token()}}',
      success:function(responseRAW){

        location.reload();

      }

    });
  }  

}

function deleteCustomer( customer_id ){
  if(confirm("Are You Sure you want to delete this Customer ?")){
    $.ajax({

      url:'{{ URL::to("/customers") }}/'+customer_id,
      type:'delete',
      data:'_token={{csrf_token()}}',
      success:function(responseRAW){

        location.reload();

      }

    });
  }

}

function deletePartner( partner_id ){
  if(confirm("Are You Sure you want to delete this Partner ?")){
    $.ajax({

      url:'{{ URL::to("/partners") }}/'+partner_id,
      type:'delete',
      data:'_token={{csrf_token()}}',
      success:function(responseRAW){

        location.reload();

      }

    });
  }
}


function redirectMe(id){

  return window.location='{{ URL::to("/restaurants") }}/'+id;

}
function menuStatus(id,status){

  $.ajax({

    url:"{{ URL::to('/orders') }}/"+id,
    type:"put",
    data:"_token={{csrf_token()}}&status="+status,
    success:function(responseRAW){
      response = JSON.parse(responseRAW);
      alert(response.message);

    }

  });

}
function deleteResturant(id){

 if(confirm("Are You Sure you want to delete this Restaurant ?")){
  $.ajax({
  
      url:"{{ URL::to('/restaurants') }}/"+id,
      type:"delete",
      data:"_token={{csrf_token()}}",
      success:function(responseRAW){
        location.reload();
  
      }
  
    });
  } 

}
</script>

</head>
<body>
<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <nav id="spy">
                <ul class="sidebar-nav nav">
                    <li class="sidebar-brand logo">
                        <a href="{{ URL::to('/dashboard') }}"><img src="{{ URL::to('/images/logo-white.png') }}" /></a>
                    </li>
                    <li>
                        <a href="">
                            <span >Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <ul class="">                     
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle " data-toggle="dropdown">
                                    <div class="">
                                       <span class="welcome">Orders</span>
                                       <i class="fa fa-angle-down pull-right"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{URL::to('/orders')}}">
                                           
                                            <span>Orders</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="ajax/page_messages.html" class="ajax-link">
                                           
                                            <span>Carts</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href=" {{ URL::to('/restaurants') }} ">
                            <span >Restaurants</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/partners') }}">
                            <span >Partners</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/customers') }}">
                            <span >Customers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/settings') }}">
                            <span >Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/logout') }}">
                            <span >Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <div class="content-header">
                <h1 id="home">
                    <a id="menu-toggle" href="#" class="glyphicon glyphicon-align-justify btn-menu toggle">
                      
                    </a>
                    <span class="page-title">@yield('page-title')</span>
                </h1>
            </div>

            <div class="page-content inset" data-spy="scroll" data-target="#spy">

                  @yield('content')

                <div class="navbar navbar-default navbar-static-bottom">
                    <p class="navbar-text pull-left">
                        
                    </p>
                </div>
            </div>

        </div>

    </div>

<script>
//Set up some of our variables.
var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker?

//Function called to initialize / create the map.
//This is called when the page has loaded.
function initMap(position) {
 
    //The center location of our map.
    if( position !== undefined){

    var centerOfMap = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
    }else{

      var centerOfMap = new google.maps.LatLng(23.2050,77.0851);

    }
    //Map options.
    var options = {
      center: centerOfMap, //Set center.
      zoom: 10 //The zoom value.
    };
 
    //Create the map object.
    map = new google.maps.Map(document.getElementById('map'), options);

}

function addMarker(id) {
  //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) {                
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker[id] === false){
            //Create the marker.
            marker[id] = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true //make it draggable
            });
            //Listen for drag events!
            google.maps.event.addListener(marker[id], 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Marker has already been added, so just change its location.
            marker[id].setPosition(clickedLocation);
        }
        //Get the marker's location.
        markerLocation();
    });
}
        
//This function will get the marker's current location and then add the lat/long
//values to our textfields so that we can save the location.
function markerLocation(id){
    //Get location.
    var currentLocation = marker[id].getPosition();
    //Add lat and lng values to a field that we can save.
    document.getElementById('bl_lat').value = currentLocation.lat(); //latitude
    document.getElementById('bl_long').value = currentLocation.lng(); //longitude
}
          
</script>

<script type="text/javascript">
  
  // Javascript request URL
  var requestURL = '//api.cirrb.com/';
  
  function logout() {
    $.ajax({
      url: requestURL + '?request=profile&operation=logout',
      dataType: 'json',
      success: function(response) {
        if (response['logout'] == 1) {
          window.location = './';
        }
      }
    });
  }
  
  
  function resizeSideMenu() {
    var documentHeight = $(document).height();
    $('#sideMenu').css( 'min-height', documentHeight );
  }
  
  $(document).ready( function() {
    resizeSideMenu();
    
  });
  $(window).resize( function() {
    resizeSideMenu();
  });
  
  function system_notification(type, header, message) {
    
    $('#systemNotificationMessage').finish();
    
    $('#systemNotificationMessage')
      .removeClass('negative');
    $('#systemNotificationMessage')
      .removeClass('success');
    
    var icon;
      
    if ( type === "processing" ) {
      icon = 'notched circle loading icon';
    }
    else if ( type === "error" ) {
      icon = '';
      $('#systemNotificationMessage')
        .addClass('negative');
    }
    else if ( type === "confirm" ) {
      icon = 'check icon';
      $('#systemNotificationMessage')
        .addClass('success');
    }
    
    if( icon !== "" ) {
      icon = '<i class="'+ icon +'" id="icon"></i>';
    }
      
    $('#systemNotificationMessage').html(
        icon
      + '<i class="close icon"></i>'
      + '<div class="content">'
        + '<div class="header">'
        + header + '</div>'
        + '<div>'
        + message + '</div>'
      + '</div>'
    );
      
    $('#systemNotificationMessage')
      .slideDown()
      .delay(5000)
      .fadeOut();
  
    $('#systemNotificationMessage .close')
      .on('click', function() {
        $('#systemNotificationMessage')
          .stop().fadeOut();
    });
  }
  
  
</script>
<script type="text/javascript">
      
      var restaurantId = 1;
      var newItemFormCounter = 0;
      var gMarkers = Array;
      var newBranchCounter = 0;
      
      $(document).ready(function() {
         navigator.geolocation.getCurrentPosition(initMap);
        //debugger
        $('#saveItemsButton').hide();
        $('#saveBranchesButton').hide();
        
        $('#updateRestaurantButton').hide();
        $('#cancelRestaurantEditButton').hide();
        
        getRestaurant();
        setTimeout(function(){getBranches()},3000);
        getMenu();
        initMap();
      });
      
      function editRestaurant() {
        var restaurantName = $('#restaurantName').html();
        var restaurantPhone = $('#restaurantPhone').html();
        var restaurantEmail = $('#restaurantEmail').html();
        var restaurantDescription = $('#restaurantDescription').html();
        $('#newRestaurantName').val( restaurantName );
        $('#newRestaurantPhone').val( restaurantPhone );
        $('#newRestaurantEmail').val( restaurantEmail );
        $('#newRestaurantDescription').val( restaurantDescription );
        
        $('#newRestaurantNameForm').show();
        $('#newRestaurantDescriptionForm').show();
        $('#restaurantDescription').hide();
        $('#newRestaurantPhoneForm').show();
        $('#restaurantPhone').hide();
        $('#newRestaurantEmailForm').show();
        $('#restaurantEmail').hide();
        
        $('#updateRestaurantButton').show();
        $('#cancelRestaurantEditButton').show();
        $('#editRestaurantButton').hide();
      }
      
      function cancelRestaurantEdit() {
        $('#newRestaurantNameForm').hide();
        $('#newRestaurantDescriptionForm').hide();
        $('#restaurantDescription').show();
        $('#newRestaurantPhoneForm').hide();
        $('#restaurantPhone').show();
        $('#newRestaurantEmailForm').hide();
        $('#restaurantEmail').show();
        
        $('#updateRestaurantButton').hide();
        $('#cancelRestaurantEditButton').hide();
        $('#editRestaurantButton').show();
      }
      
      function updateRestaurant() {
        var restaurantName = $('#newRestaurantName').val();
        var restaurantPhone = $('#newRestaurantPhone').val();
        var restaurantEmail = $('#newRestaurantEmail').val();
        var restaurantDescription = $('#newRestaurantDescription').val();
        
        var data = ({
          operation: 'updateRestaurant',
          restaurantId: restaurantId,
          restaurantName: restaurantName,
          restaurantPhone: restaurantPhone,
          restaurantEmail: restaurantEmail,
          restaurantDescription: restaurantDescription
        });
        
        $.ajax({
          url: requestURL+'/?request=restaurants',
          data: data,
          method: 'post',
          dataType: 'json',
          success: function(response) {
            if(response.errors == 0) {
              
              $('#restaurantName').html(restaurantName);
              $('#restaurantDescription').html(restaurantDescription);
              $('#restaurantPhone').html(restaurantPhone);
              $('#restaurantEmail').html(restaurantEmail);
              
              cancelRestaurantEdit();
            }
            else {
              
            }
          },
          error: function(response) {
            
          }
        });
      }
      
      
      function getRestaurant() {
        
        var data = ({
          operation: 'getRestaurant',
          restaurantId: restaurantId
        });
        
        $.ajax({
          
          url: requestURL + '/?request=restaurants',
          data: data,
          method: 'post',
          dataType: 'JSON',
          success: function(response) {
            if (response.errors === 0) {
              $('#restaurantName').html(response.restaurant.name);
              $('#restaurantDescription').html(response.restaurant.description);
              $('#restaurantPhone').html(response.restaurant.phone);
              $('#restaurantEmail').html(response.restaurant.email);
              $('#restaurantCreatedOn').html(response.restaurant.created_on);
              
              if(response.restaurant.approved === 'n') {
                $('#restaurantApprovedStatus').html('Not Approved Yet <a href="#" onclick="approveRestaurant()">'
                                  + 'Approve</a>');
              }
              else {
                $('#restaurantApprovedStatus').html('Approved <a href="#" onclick="disapproveRestaurant()"'
                                 + '>Disapprove</a>');
              }
              
              $('#restaurantApprovedOn').html(response.restaurant.approved_on);
              
            }
            else {
              system_notification('error', 'Cannot load restaurant', 
                'Cannot find the restaurant in the database.')
            }
          },
          error: function(response) {
            
            $('#restaurantsTable').find('tbody').html(
              '<tr><td colspan=\'7\'>No records found</td></tr>'
            );
          }
          
        });
      }
      
      function disapproveRestaurant() {        
        $.ajax({
          url: '{{ URL::to("/restaurantApproval") }}',
          data: '_token={{csrf_token()}}&action=disapprove&restaurant_id={{$restaurant_id}}',
          method: 'post',
          success: function (response) {
              
            $('#restaurantApprovedStatus').html('Not Approved Yet <a href="#" onclick="approveRestaurant()">'
                                + 'Approve</a>');
            $('#restaurantApprovedOn').html('<i>Refresh page</i>');
          }  
        });
      }
      
      function approveRestaurant() {        
        $.ajax({
          url: '{{ URL::to("/restaurantApproval") }}',
          data: '_token={{csrf_token()}}&action=approve&restaurant_id={{$restaurant_id}}',
          method: 'post',
          success: function (response) {
              $('#restaurantApprovedStatus').html('Approved <a href="#" onclick="disapproveRestaurant()"'
                                 + '>Disapprove</a>');
              $('#restaurantApprovedOn').html('<i>Refresh page</i>');
            }
            
        });
      }
      
      function getBranches() {
        
        var data = ({
          operation: 'getBranches',
          restaurantId: restaurantId
        });
        
        $.ajax({
          
          url: '{{URL::to("/branches")}}',
          data: "restaurant_id={{$restaurant_id}}",
          method: 'get',
          success: function(responseRAW) {

            response = JSON.parse(responseRAW);

            

            if (response.errors === 0) {
              
              $('#branchesTable').find('tbody').html('');
              
              
              
              $.each( response.branches, function(key, value) {
                
                
                $('#branchesTable').find('tbody').append(
                  '<tr id="branch-' + value['id'] + '">'
                  + '<td id="branch-namecell-'+value['id']+'">' + value['name'] + '</td>'
                  + '<td id="branch-latcell-'+value['id']+'">' + value['bl_lat'] + '</td>'
                  + '<td id="branch-longcell-'+value['id']+'">' + value['bl_long'] + '</td>'
                  + '<td class="right aligned">'
                  + '<div onclick="editBranch(' + value['id'] + ')" class="link inline button">Edit</div>'
                  + '<div onclick="deleteBranch(' + value['id'] + ')" class="link inline button">Delete</div></td>'
                  + '</tr>'
                  + '<tr id="branch-' + value['id'] + '-form" class="ui form hidden">'
                  + '<td><input class="text" name="branchName" id="branchName-'+ value['id'] +'" ' 
                  + 'value="' + value['name'] + '"></td>'
                  + '<td><input class="text" name="branchLat" id="branchLat-'+ value['id'] +'" ' 
                  + 'value="' + value['bl_lat'] + '"></td>'
                  + '<td><input class="text" name="branchLong" id="branchLong-'+ value['id'] +'" ' 
                  + 'value="' + value['bl_long'] + '"></td>'
                  + '<td class="right aligned">'
                  + '<div onclick="updateBranch(' + value['id'] + ')" class="link inline button">Save</div>'
                  + '<div onclick="cancelEditBranch(' + value['id'] + ')" class="link inline button">Cancel</div></td>'
                  + '</tr>'
                );


                var location = { lat: parseFloat(value['bl_lat']), lng: parseFloat(value['bl_long']) } 
                gMarkers[ value['id'] ] = new google.maps.Marker({
                  position: location,
                  label: value['name'],
                  map: map,
                  draggable: true //make it draggable
                });
                
                google.maps.event.addListener(gMarkers[ value['id'] ], 'dragend', function(event){
                  editBranch(value['id']);
                  var currentLocation = gMarkers[ value['id'] ].getPosition();
                  //Add lat and lng values to a field that we can save.
                  $('#branch-' + value['id'] +'-form').find('#branchLat-'+value['id']).val( currentLocation.lat() );
                  $('#branch-' + value['id'] +'-form').find('#branchLong-'+value['id']).val( currentLocation.lng() );
                });
              });
            }
            else {
              $('#branchesTable').find('tbody').html(
                '<tr><td colspan="4">No records found.</td></tr>'
              );
            }
          },
          error: function(response) {
            
            $('#branchesTable').find('tbody').html(
              '<tr><td colspan=\'4\'>No records found</td></tr>'
            );
           }
          
         });
      }
      
      function addBranch() {
        newBranchCounter++;
        
        var newMarker = Array;
        newMarker[newBranchCounter] = new google.maps.Marker({
          position: map.getCenter(),
          label: 'New branch',
          map: map,
          draggable: true
        });
        
        google.maps.event.addListener(newMarker[ newBranchCounter ], 'dragend', function(event){
          var currentLocation = newMarker[ newBranchCounter ].getPosition();
          //Add lat and lng values to a field that we can save.
          $('#newBranchForm')
            .find('#branchLat').val( currentLocation.lat() );
          $('#newBranchForm')
            .find('#branchLong').val( currentLocation.lng() );
        });
        
        $('#branchesTable').find('tbody').append(
          '<tr id="newBranchForm" class="ui form newBranch">'
          + '<td><div class="field"><input class="form-control" name="branchName" id="branchName" value=""></div></td>'
          + '<td><div class="field"><input class="text form-control" name="branchLat" id="branchLat" value=""></div></td>'
          + '<td><div class="field"><input class="text form-control" name="branchLong" id="branchLong" value=""></div></td>'
          + '<td><a href="javascript:void(0)" onclick="saveBranch()">Save</a> | <div class="link inline button" onclick="removeNewBranchForm()">'
          + 'Cancel</div></td>'
          + '</tr>'
        );


        $("#add-branch").hide();

      }
      
      function removeNewBranchForm(id) {

        location.reload()

      }
      
      function saveBranch() {

        var name = $("#branchName").val();
        var lat = $("#branchLat").val();
        var long = $("#branchLong").val();
        $.ajax({

          url:"{{URL::to('/branches')}}",
          method:'post',
          data:'_token={{csrf_token()}}&name='+name+'&lat='+lat+'&long='+long+'&restaurant_id={{$restaurant_id}}',
          success:function(responseRAW){
            

            location.reload();

          }

        });
        
      }
      
      function updateBranch(id) {
        var name = $('#branchName-'+id).val();
        var lat = $('#branchLat-'+id).val();
        var long = $('#branchLong-'+id).val();
        
        $.ajax({
          url: '{{ URL::to("/branches") }}/'+id,
          data:'_token={{csrf_token()}}&name='+name+'&lat='+lat+'&long='+long+'&restaurant_id={{$restaurant_id}}',
          method: 'put',
          success: function(response) {
              $("#branch-namecell-"+id).html(name);
              $("#branch-latcell-"+id).html(lat);  
              $("#branch-longcell-"+id).html(long);  

              cancelEditBranch(id);
          }  
        });
      }
     function deleteBranch( branch_id ){
      if(confirm("Are You Sure you want to delete this Branch ?")){
        $.ajax({
      
          url:'{{ URL::to("/branches") }}/'+branch_id,
          type:'delete',
          data:'_token={{csrf_token()}}',
          success:function(responseRAW){
      
            location.reload();
      
          }
      
        });
      }  
    }
      
      function editBranch(id) {
        $('#branch-' + id +'-form').removeClass("hidden");
        $("#add-branch").hide();
        $('#branch-' + id).hide();
      }
      
      function cancelEditBranch(id) {
        $('#branch-' + id +'-form').addClass("hidden");
        $("#add-branch").show();
        $('#branch-' + id).show();
      }
      
      function getMenu() {
        
        var data = ({
          operation: 'getMenu',
          restaurantId: restaurantId
        });
        
        $.ajax({
          
          url: requestURL + '/?request=restaurants',
          data: data,
          method: 'post',
          dataType: 'JSON',
          success: function(response) {
            if (response.errors === 0) {
              
              $('#itemsCount').html( '('+ response.menu.length +')' );
              $('#menuTable').find('tbody').html('');
              
              var marker = Array;
              
              $.each( response.menu, function(key, value) {
                
                $('#menuTable').find('tbody').append(
                  '<tr id="item-' + value['id'] + '" class="top aligned">'
                  + '<td>' + value['id'] + '</td>'
                  + '<td id="itemName-' + value['id'] + '-label">' + value['name'] + '</td>'
                  + '<td id="itemDescription-' + value['id'] + '-label">' + value['description'] + '</td>'
                  + '<td id="itemPrice-' + value['id'] + '-label">' + value['price'] + '</td>'
                  + '<td class="right aligned">'
                  + '<div onclick="editItem(' + value['id'] + ')" class="link inline button">Edit</div>'
                  + '<div onclick="deleteItem(' + value['id'] + ')" class="link inline button">Delete</div></td>'
                  + '</tr>'
                  + '<tr id="item-' + value['id'] + '-form" class="ui form hidden top aligned">'
                  + '<td>' + value['id'] + '</td>'
                  + '<td><input class="text" name="itemName-' + value['id'] + '" id="itemName-' + value['id'] + '" ' 
                  + 'value="' + value['name'] + '"></td>'
                  + '<td><textarea class="text" rows="4" name="itemDescription-' + value['id'] + '" id="itemDescription-' + value['id'] + '">' 
                  + value['description'] + '</textarea></td>'
                  + '<td><input class="text" name="itemPrice-' + value['id'] + '" id="itemPrice-' + value['id'] + '" ' 
                  + 'value="' + value['price'] + '"></td>'
                  + '<td class="right aligned">'
                  + '<div onclick="updateItem(' + value['id'] + ')" class="link inline button">Save</div>'
                  + '<div onclick="cancelItemEdit(' + value['id'] + ')" class="link inline button">Cancel</div></td>'
                  + '</tr>'
                );
                
              });
            }
            else {
              $('#menuTable').find('tbody').html(
                '<tr><td colspan="4">No records found.</td></tr>'
              );
            }
          },
          error: function(response) {
            $('#menuTable').find('tbody').html(
              '<tr><td colspan=\'4\'>No records found</td></tr>'
            );
          }
          
        });
      }
      
      function editItem(id) {
        $('#item-' + id).hide();
        $('#item-'+id+'-form').show();
      }
      
      function cancelItemEdit(id) {
        $('#item-' + id).show();
        $('#item-'+id+'-form').hide();
      }
      
      function deleteItem(id) {
        
        var data = ({
          operation: 'deleteItem',
          itemId: id,
        });
        
        $.ajax({
          url: requestURL+'/?request=restaurants',
          data: data,
          dataType: 'json',
          method: 'post',
          success: function(response) {
           
            if(response.errors === 0) {
             
              $('#item-'+id).hide();
            }
            else {
              
            }
            
          },
          error: function(response) {
            
          }
        })
      }
      
      function updateItem(id) {
        
        var itemName = $('#item-'+id+'-form').find('#itemName-'+id);
        var itemDescription = $('#item-'+id+'-form').find('#itemDescription-'+id);
        var itemPrice = $('#item-'+id+'-form').find('#itemPrice-'+id);
        
        var data = ({
          operation: 'updateItem',
          itemId: id,
          itemName: itemName.val(),
          itemDescription: itemDescription.val(),
          itemPrice:itemPrice.val()
        });
        
        $.ajax({
          url: requestURL+'/?request=restaurants',
          data: data,
          dataType: 'json',
          method: 'post',
          success: function(response) {
            
            if(response.errors === 0) {
              
              $('#item-'+id).find('#itemName-'+id+'-label').html(
                itemName.val() );
              $('#item-'+id).find('#itemDescription-'+id+'-label').html(
                itemDescription.val() );
              $('#item-'+id).find('#itemPrice-'+id+'-label').html(
                itemPrice.val() );
              cancelItemEdit(id);
            }
            else {
              
            }
            
          },
          error: function(response) {
            
          }
        })
      }
      
      function addItem() {
        newItemFormCounter += 1;
        
        $('#menuTable').append(
          '<tr id="newItemForm-'+newItemFormCounter+'" class="ui top aligned form newItem">'
          + '<td></td>'
          + '<td>'
            + '<div class="field">'
            + '<input type="text" name="newItemName[]" id="newItemName[]">'
            + '</div>'
          + '</td>'
          + '<td>'
            + '<div class="field">'
            + '<textarea name="newItemDescription[]" id="newItemDescription[]" '
            + 'rows="3"></textarea>'
            + '</div>'
          + '</td>'
          + '<td>'
            + '<div class="field">'
            + '<input type="text" name="newItemPrice[]" id="newItemPrice[]">'
            + '</div>'
          + '</td>'
          + '<td>'
            + '<div class="ui icon button" onclick="removeNewItemForm('+newItemFormCounter+')">'
            + '<i class="cancel icon"></i></div>'
          + '</td>'
          + '</tr>'
        );
        
        $('#saveItemsButton').show();
      }
      
      function saveItems() {
        var errors = 0;
        
        $('input[id="newItemName[]"]').each(function() {
          if ( $.trim( $(this).val() ).length == "" ) {
            $(this).closest('.field').addClass('error');
            errors = 1;
          }
          else {
            $(this).closest('.field').removeClass('error');
          }
        });
        
        $('textarea[id="newItemDescription[]"]').each(function() {
          if ( $.trim( $(this).val() ).length == "" ) {
            $(this).closest('.field').addClass('error');
            errors = 1;
          }
          else {
            $(this).closest('.field').removeClass('error');
          }
        });
        
        $('input[id="newItemPrice[]"]').each(function() {
          if ( $.trim( $(this).val() ).length == "" ) {
            $(this).closest('.field').addClass('error');
            errors = 1;
          }
          else {
            $(this).closest('.field').removeClass('error');
          }
        });
        
        if( errors == 0) {
          var itemsNames = $('input[id="newItemName[]"').map(function(){return $(this).val();}).get();
          var itemsDescriptions = $('textarea[id="newItemDescription[]"').map(function(){return $(this).val();}).get();
          var itemsPrices = $('input[id="newItemPrice[]"').map(function(){return $(this).val();}).get();
          
          var data = {
            operation: 'addItems',
            restaurantId: restaurantId,
            itemsNames: JSON.stringify(itemsNames),
            itemsDescriptions: JSON.stringify(itemsDescriptions),
            itemsPrices: JSON.stringify(itemsPrices)
          };
          
          $.ajax({ 
            url: requestURL+'/?request=restaurants',
            data: data,
            method: 'post',
            dataType: 'json',
            success: function(response) {
              if(response.errors == 0) {
                
                getMenu();
                $('#saveItemsButton').hide();
              }
              else {
                
              }
            },
            error: function(response) {
             
            }
          });
        }
      }
      
      function removeNewItemForm(id) {
        $('#newItemForm-'+id).remove();
        
        if( $('.newItem').length === 0 ) {
          $('#saveItemsButton').hide();
        }
      }
    </script>


    <script>
    $(document).ready(function(){
          $('#show-add-customer').click(function(e){
              $('#add-customer-form').toggle();
          });
          $('#show-add-partner').click(function(e){
              $('#add-partner-form').toggle();
          });

          $("#add-customer").submit(function(e){
            $("#response_message").html('');
            $.ajax({
              url:'{{ URL::to("/customers") }}',
              type: 'post',
              data:$(this).serialize(),
              success:function(response){
                if(response == '1'){
                  location.reload();
                }else{
                  $("#response_message").html(response);
                } 
              }
            });
            e.preventDefault();
          });

        $("#edit-customer-btn").click(function(e){
              $(".field-show").toggle();
              $(".field-hide").toggle();
         });
        $("#edit-partner-btn").click(function(e){
              $(".field-show").toggle();
              $(".field-hide").toggle();
         });
    })

    function redirectMeCustomer(id){
      return window.location='{{ URL::to("/customers") }}/'+id;
    }
    function redirectMeOrder(id){
      return window.location='{{ URL::to("/orders") }}/'+id;
    }

    </script>
</body>
</html>
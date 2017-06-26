@extends('adminpanel.cirrb')

@section('page-title')
User Info
@endsection

@section('content')

<style>
#Detailsmap{

height:600px;
width:100%;

}
</style>
<div id="Detailsmap" style=""></div>

<script type="text/javascript">
var map;
var markers=[];
function initDetailsMap(currentPosition)
{
  //alert('call init');
  if( currentPosition !== undefined){
    var centerOfMap = new google.maps.LatLng(currentPosition.coords.latitude,currentPosition.coords.longitude);
  }
  else{
    var centerOfMap = new google.maps.LatLng(24.5247,39.5692);
    //var centerOfMap = new google.maps.LatLng(33.836593,-117.914301); 
  }
  map=new google.maps.Map(document.getElementById('Detailsmap'),{center:centerOfMap,zoom:10});
  $.ajax({

  url: '{{ URL::to("/set-infomap") }}',
  type: 'get',
  success:function(responseRAW){

  response = JSON.parse(responseRAW);

  createMarker(response);

  }

  });
function createMarker(locations){var largeInfoWindow=new google.maps.InfoWindow();
var bounds=new google.maps.LatLngBounds();
for(var i=0;i<locations.length;i++)
{

var position={lat:parseFloat(locations[i].lat),lng:parseFloat(locations[i].long)};
//debugger
var title="Online Customers";
var email= locations[i].email;
var name= ( locations[i].name != ' ' ) ? '<h3>' + locations[i].name + '</h3>' : '<h3> (No Name) </h3>';
var role = locations[i].roles;

var partner_status = ( role == 'partner' ) ? '<span>Status : ' + locations[i].partner_status + '</span><br>' : '';

//var contentString = '<h1>' + name + '</h1><span>Email:'+ email +'</span>';

 //var infowindow = new google.maps.InfoWindow({
   //       content: contentString
     //   });
var icon ;
if(role=='customer'){
  icon = "{{URL::to('/images/map-marker-blue.png')}}";
  //debugger
}else{
  icon = "{{URL::to('/images/map-marker-orange.png')}}";
}


var marker=new google.maps.Marker({map:map,position:position,title:title,animation:google.maps.Animation.DROP,id:i,email:email,name:name , icon: new google.maps.MarkerImage(icon)});
markers.push(marker);
bounds.extend(marker.position);

/*marker.addListener('click',function(){
//infowindow.open(map, marker);
populateInfoWindow(this,largeInfoWindow)
});//populateInfoWindow(this,largeInfoWindow)*/

 var content = name + '<h5>' + role  + '</h5>'+ partner_status +'<br><span>Email : '+ email +'</span>';

 var infowindow = new google.maps.InfoWindow();

 google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
        return function() {
           infowindow.setContent(content);
           infowindow.open(map,marker);
        };
    })(marker,content,infowindow));


}
}
function populateInfoWindow(marker,infowindow)
{
if(infowindow.marker!=marker){
infowindow.marker=marker;

infowindow.setContent('<h1>' + marker.name + '</h1><span>Email:'+ marker.email +'</span>');
infowindow.open(map,marker);
infowindow.addListener('closeclick',function(){infowindow.setContent("")
});
}
}
//map.fitBounds(bounds);
}

$(document).ready(function(){

  navigator.geolocation.getCurrentPosition(initDetailsMap);
  initDetailsMap();	
})
</script>

@endsection

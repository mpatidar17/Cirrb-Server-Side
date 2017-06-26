<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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
      $('#add-restaurant-form').show();
    });
     $('#cancel-add-restaurant').click(function(e){
      $('#add-restaurant-form').hide();
    });
    $("#add-restaurant").submit(function(e){
      $.ajax({

        url:'{{ URL::to("/restaurants") }}',
        type: 'post',
        data:$(this).serialize(),
        success:function(response){

          alert(response);

        }

      });
      e.preventDefault();
    });
});
function redirectMe(id){

  return window.location='{{URL::to("/restaurant-detail")}}/'+id;

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
                    <!-- <li>
                        <a href="">
                            <span>Anchor 2</span>
                        </a>
                    </li> -->
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
                                        <a href="#">
                                           
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
                        <a href="#">
                            <span >Partners</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span >Customers</span>
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
                    @yield('page-title')
                </h1>
            </div>

            <div class="page-content inset" data-spy="scroll" data-target="#spy">

                  @yield('content')

                <div class="navbar navbar-default navbar-static-bottom">
                    <p class="navbar-text pull-left">
                        Built by <a href="http://mvnguyen.com" target="_blank">Michael V Nguyen
                    </p>
                </div>
            </div>

        </div>

    </div>

</body>
</html>

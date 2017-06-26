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
    //  $('#cancel-add-restaurant').click(function(e){
    //   $('#add-restaurant-form').toggle();
    // });
     $("#edit-restaurant-btn").click(function(e){

        $(".field-show").toggle();
        $(".field-hide").toggle();

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

    // $(".add-restaurant.save-btn").click(() => {})
    $(document).on('submit',"form#edit-restaurant",function(e){
          $.ajax({

            url:'{{ URL::to("/restaurants") }}/'+$("#restaurant_id").val(),
            type: 'put',
            data:$(this).serialize(),
            success:function(responseRAW){
              debugger
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
        $("#menus-table").append('<tr><td>{{ Form::text("name") }}</td><td>{{ Form::text("description") }}</td><td>{{ Form::text("price") }}</td><td><button type="submit" id="save-menu" class="add-restaurant save-btn"><span class="fa fa-plus"></span> Save</button></td></tr>');
    });      
});
function redirectMe(id){

  return window.location='{{ URL::to("/restaurants") }}/'+id;

}
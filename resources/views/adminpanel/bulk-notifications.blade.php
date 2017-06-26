@extends('adminpanel.cirrb')

@section('page-title')
	Notifications
@endsection

@section('content')
{{ Html::ul($errors->all()) }}
@if(Session::has('message'))
<div class="alert alert-success">
  
  {{ Session::get('message') }}

</div>
@endif
{{ Form::open(array('url'=>'/bulk-notifications')) }}
    <div class="form-group col-md-12">
       <font id="error_message" color="red"></font>
    </div>

    <div class="form-group col-md-12">
    	<div class="col-md-6">
        {{ Form::label("customer", "Customer") }}
        </div>
        <div class="col-md-6">
        {{ Form::checkbox("customer","customer",false , array( 'id' => 'customer_checkbox' , 'class' => 'checkbox_class')) }}
        </div>
    </div>
    <div class="form-group col-md-12">
    	<div class="col-md-6">
        {{ Form::label("partner", "Partner") }}
        </div>
        <div class="col-md-6">
        {{ Form::checkbox("partner", "partner",false,array('id' => 'partner_checkbox','class'=>'show-partner-more checkbox_class')) }}
        </div>
    </div>
    <div class="partner-check" style="display: none;">
	    <div class="form-group col-md-12">
	    	<div class="col-md-6">
	        {{ Form::label("busy", "Busy") }}
	        </div>
	        <div class="col-md-6">
	        {{ Form::checkbox("busy", "busy",false,array('id' => 'busy_checkbox','class'=>'partner_checkbox_class')) }}
	        </div>
	    </div>
	    <div class="form-group col-md-12">
	    	<div class="col-md-6">
	        {{ Form::label("free", "Free") }}
	        </div>
	        <div class="col-md-6">
	        {{ Form::checkbox("free", "free",false,array('id' => 'free_checkbox','class'=>'partner_checkbox_class')) }}
	        </div>
	    </div>
	</div>
	<div class="form-group">
        {{ Form::label("message", "Message") }}
        {{ Form::textarea("message", "", array('id'=>'message','class' => 'form-control')) }}
    </div>

{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

<script type="text/javascript">
	
$(document).ready(function(e){
	
	
        $(document).on('submit','form',function(){
           $('#error_message').html('');
           var customer_checkbox = $('#customer_checkbox').is(':checked') ;
           var partner_checkbox  = $('#partner_checkbox').is(':checked') ;
	   var busy_checkbox  = $('#busy_checkbox').is(':checked') ;
           var free_checkbox  = $('#free_checkbox').is(':checked') ;	
           var message  = $('#message').val() ;
           
           if( customer_checkbox  || partner_checkbox ){
               if(partner_checkbox){
                  if( !busy_checkbox && !free_checkbox ){
		      $('#error_message').html('* Please Choose Busy Or Free');
                      return false ;  
                  }
               }//end of the inner if

               if(message == ''){
                        $('#error_message').html('* Please Fill Message Field');
                        return false ;  	
               }
           }else{
              $('#error_message').html('* Please Choose Partner Or Customer Or Both');
              return false;
           }
           
        });
        

	$(".show-partner-more").click(function(e){

		$(".partner-check").toggle();

	});

});

</script>

@endsection

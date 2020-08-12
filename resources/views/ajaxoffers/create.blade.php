@extends('layouts.app')


@section('content')


<div class="container">

    <div class="alert alert-success" id="success_msg" style="display: none;">
         Congats Saved Successfully
    </div>

        <div class="flex-center position-ref full-height">
           
            <div class="content">
                <div class="title m-b-md">
                    
                    {{__('messages.Add Your Offer')}}

                </div>



       <form method="POST" id="offerForm" action="" enctype="multipart/form-data">

            <!--   <input name="_token" value="{{csrf_token()}}">  -->

            @csrf

              <div class="form-group">
                <label for="exampleInputEmail1">{{__('messages.add photo')}}</label>
                <input type="file" class="form-control" name="photo">
                    <small id="photo_error" class="form-text text-danger"></small>
              </div>

    
              <div class="form-group">
                <label for="exampleInputEmail1">{{__('messages.offer name ar')}}</label>
                <input type="text" class="form-control" name="name_ar"  placeholder="Enter Offer Name Arabic">
                    <small id="name_ar_error" class="form-text text-danger"></small>
              </div>


               <div class="form-group">
                <label for="exampleInputEmail1">{{__('messages.offer name en')}}</label>
                <input type="text" class="form-control" name="name_en"  placeholder="Enter Offer Name English">
                    <small id="name_en_error" class="form-text text-danger"></small>
              </div>


              <div class="form-group">
                <label for="exampleInputPassword1">{{__('messages.offer price')}}</label>
                <input type="text" class="form-control" name="price" placeholder="Enter Price">
                    <small id="price_error"  class="form-text text-danger"></small>
              </div>


              <div class="form-group form-check">
                <label class="form-check-label" for="exampleCheck1">{{__('messages.enter details ar')}}</label>
                <input type="text" class="form-control" name="details_ar" placeholder="Enter Details Arabic">
                    <small id="details_ar_error" class="form-text text-danger"></small>
              </div>

              <div class="form-group form-check">
                <label class="form-check-label" for="exampleCheck1">{{__('messages.enter details en')}}</label>
                <input type="text" class="form-control" name="details_en" placeholder="Enter Details English">
                    <small id="details_en_error" class="form-text text-danger"></small>
              </div>

              <button id="save_offer" class="btn btn-primary">{{__('messages.save offer')}}</button>
      </form>

            </div>
    </div>

</div>
@stop


@section('scripts')

<script>

$(document).on('click', '#save_offer', function(e){
        e.preventDefault();

        $('#photo_error').text('');
        $('#name_ar_error').text('');
        $('#name_en_error').text('');
        $('#price_error').text('');
        $('#details_ar_error').text('');
        $('#details_en_error').text('');

    var formData = new FormData($('#offerForm')[0]);    

        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url : "{{route('ajax.offers.store')}}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {

                if(data.status == true) {
                    $('#success_msg').show();
                }

            }, error: function(reject){

            var response = $.parseJSON(reject.responseText);
            $.each(response.errors, function(key, val) {
                $('#' + key + '_error').text(val[0]);
            });

            }
               
        });



   
       /* $.ajax({
            type: 'post',
            url : "{{route('ajax.offers.store')}}",
            data: {

                '_token'     : "{{csrf_token()}}",
                'name_ar'    : $("input[name='name_ar']").val(),    
                'name_en'    : $("input[name='name_en']").val(),       
                'price'      : $("input[name='price']").val(),    
                'details_ar' : $("input[name='details_ar']").val(),   
                'details_en' : $("input[name='details_en']").val(),  

            },
            success: function(data) {

            }, error: function(reject){

            }
        });*/

});

</script>

@stop
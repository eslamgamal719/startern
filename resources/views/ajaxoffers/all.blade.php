@extends('layouts.app')


@section('content')

      <div class="alert alert-success" id="success_msg" style="display: none;">
           Congats Deleted Successfully
      </div>
        
      <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">{{__('messages.offer name')}}</th>
              <th scope="col">{{__('messages.offer price')}}</th>
              <th scope="col">{{__('messages.offer details')}}</th>
              <th scope="col">صوره العرض</th>
              <th scope="col">{{__('messages.operations')}}</th>
            </tr>
          </thead>
          <tbody>

            @foreach($offers as $offer)
            <tr class="offerRow{{$offer->id}}">
                <th scope="row">{{$offer -> id}}</th>
                 <td>{{$offer -> name}}</td>
                <td>{{$offer -> price}}</td>
                <td>{{$offer -> details}}</td>
                <td><img  style="width: 90px; height: 90px;" src="{{asset('images/offers/'.$offer->photo)}}"></td>
                
                <td><a class="btn btn-success" href="{{url('offers/edit/' . $offer->id)}}">{{__('messages.edit')}}</a></td>
                <td><a class="btn btn-danger" href="{{route('offers.delete', $offer->id)}}">{{__('messages.delete')}}</a></td>
                <td><a class="btn btn-danger delete_btn" offer_id= "{{$offer->id}}"  href="">Delete Ajax</a></td>
                <td><a class="btn btn-success" href="{{route('ajax.offers.edit',$offer->id)}}">UpdateAj</a></td>

            </tr>
            @endforeach
          </tbody>
      </table>

@stop


@section('scripts')

<script>

$(document).on('click', '.delete_btn', function(e){
        e.preventDefault();

        var offer_id = $(this).attr('offer_id');
      

              $.ajax({
                  type: 'post',
                  url : "{{route('ajax.offer.delete')}}",
                  data: {
                      '_token': "{{csrf_token()}}",
                      'id' : offer_id,

                  },
                  success: function(data) {

                      if(data.status == true) {
                          $('#success_msg').show();
                      }

                      $('.offerRow' + data.id).remove();

                  }, error: function(reject){

                  }
                     
              });


});

</script>

@stop
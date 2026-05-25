@extends('layouts.app')

@section('content')
      <div class="container">
         <h1 class="mt-3"> Seleziona indirizzo </h1>

         <hr class="border border-primary border-1 opacity-75">

         <div class="row">

            
            <div class="col-xs-12 mb-4">
             
               <label for="province" class="form-label">Provincia *</label>
               <select id="province" class="form-select" name="province">
                  <option>Seleziona Provincia</option>
                  @foreach($provinces as $province)
                     <option value="{{$province}}">{{$province}}</option>
                  @endforeach
               </select>
            </div>

            <div class="col-xs-12 mt-4">
               <label for="comune" class="form-label">Comune *</label>
               <select id="comune" class="form-select" name="comune" disabled>
                  <option>Seleziona prima una provincia</option>
               </select>
               <div id="comuneSpinner" class="visually-hidden">
                   <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  <span class="sr-only">Loading...</span>
               </div>
            </div>
         </div>

         <script>
            // $(document).ready(
               function ajaxCall(provincia, comune, comuneSpinner){

                  const url = "/loadComuni/"+provincia;
                  console.log(provincia);
                  $.ajax({
                     url: url, 
                     method: "GET"
                  });
               }
               function fetchCall(){

               }

               $('#province').on('change', function (){
                  const provincia = $(this).val();

                  // alert(provincia);
                  const comune = $('#comune');
                  const comuneSpinner = $('#comuneSpinner');
                  comune.prop('disabled', true);
                  comune.html('<option>Seleziona prima una provincia</option>');
                  console.log(provincia)
                  if(provincia && provincia!='Seleziona Provincia'){
                     comuneSpinner.removeClass('visually-hidden');
                     ajaxCall(provincia, comune, comuneSpinner);

                  }else {

                     comuneSpinner.addClass('visually-hidden');
                  }
               })
            // )
         </script>
      </div>
@endsection
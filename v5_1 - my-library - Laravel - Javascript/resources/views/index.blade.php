@extends('layouts.app')

@section('content')
      <div class="container">
         <h1 class="mt-3"> Questa è la mia libreria e contiene {{ $countBooks }} libri 
         e {{ $countAuthors }} autori </h1>

         <hr class="border border-primary border-1 opacity-75">

         <div class="row">

            
            <div class="col-xs-12 col-md-8">
               Qui ci sono i libri che ho letto e quelli che voglio leggere
               <p>
                  citazione libro
               </p>
            </div>
            <div class="col-xs-12 col-md-4 p-2">
               <img class="img-responsive img-home" src="{{ asset('images/library.jpg') }}" alt="libreria" >
            </div>

         </div>
      </div>
@endsection
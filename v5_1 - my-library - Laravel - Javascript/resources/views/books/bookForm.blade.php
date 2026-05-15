    
@extends('layouts.app')
@section('content')
    <div class="container"> 
        <div>
            <h1 class="mt-3"> {{ $book && $book->id ? 'Modifica Libro':'Aggiungi libro'}}</h1>
            <hr class="border border-primary border-1 opacity-75">
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row"> 
                    
                    <form id="bookForm" 
                    action="{{ $book && $book->id ? route('book.edit', ['bookId'=> $book->id]) : route('book.create') }}" 
                    method="POST" novalidate>
                        @csrf
                        @if($book && $book->id)
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input 
                            type="text" 
                            class="form-control @error('title') is-invalid @enderror" 
                            id="title" 
                            name="title" 
                            required 
                            value="{{old('title', $book->title)}}" >
                            @error('title')
                                <div class="invalid-feedback"> {{$message}} </div>
                            @enderror 
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                                <select class="form-control" id="author" name="author" required>
                                    <option value="">Select Author</option>
                                    @foreach ($authors as $author)
                                        <option value="{{$author['id']}}"  {{ $book['author_id'] == $author['id'] ? 'selected':'' }}>{{$author['surname']}} {{$author['name']}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="year" name="year" required value="{{$book->year}}">
                            
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" max="9999" min="0" value="{{$book['price']}}" min="0" step="0.01">
                        </div>
                      
                                                
                        <button type="submit" class="btn btn-primary" onclick="submitBookForm(event)">
                            Salva
                        </button>
                        <a href="{{route('book.index')}}" class="btn btn-secondary">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
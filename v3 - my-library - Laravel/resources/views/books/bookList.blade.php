
@extends('layouts.app')
@section('content')
    <div class="container"> 
        <div>
            <h1 class="mt-3"> Book's List</h1>
            <hr class="border border-primary border-1 opacity-75">

        </div>
        <div class="row"> 
            <div class="col-xs-12 mb-3 text-end">
                <a href="{{ route('book.form') }}" class="btn btn-success"> Aggiungi libro</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                            <tr>
                                <th>Titolo</th>
                                <th>Autore</th>
                                <th>Genere</th>
                                <th>Prezzo</th>
                                <th width="300px">Azioni</th>
                            </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td> {{ $book->title }}</td>
                            <td> {{ $book->author->name }} {{ $book->author->surname }} </td>
                            {{-- <td><?php echo $book['genre']; ?></td> --}}
                            <td>€ {{ number_format($book->price, 2, ',', '.') }}</td>
                            <td> {{ $book->year }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('book.details', ['bookId' => $book['id']]) }}"> Visualizza </a>
                                <a class="btn btn-sm btn-warning" href="{{ route('book.form', ['bookId' => $book['id']]) }}"> Modifica </a>

<a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modaleEliminaLibro_{{$book->id}}"> Elimina </a>
                        <div class="modal fade" id="modaleEliminaLibro_{{$book->id}}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminazione {{$book->title}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Sei sicuro di voler eliminare questo libro ({{$book->title}})?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <a href="{{route('book.delete', ['bookId'=>$book->id])}}" class="btn btn-danger">Elimina</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                        
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection
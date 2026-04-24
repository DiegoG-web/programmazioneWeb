<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function index(){
        $books = Book::all();
        return view('books.bookList', ["books"=>$books]);

    }

    public function detailsOrFail($bookId) {
        $book = Book::find($bookId);
        return view('books.bookDetails', ["book"=>$book]);
    }


    public function viewForm($bookId = null) {
        $book= new Book();
        
        if($bookId){
            $book = Book::findOrFail($bookId);
        }
        $authors = Author::all();

        return view('books.bookForm', [
            'book'=>$book, 
            'authors'=>$authors
        ]);

        //return redirect()->route('book.index');
    }

    public function validateBook(Request $request): array{
        return $request->validate([
            'title' => ['required','string','max:255','min:3'],
            'price' => ['required','numeric','min:0'],
            'year' => ['required','integer','min:1000','max:'.date('Y')],
            'author' => ['required','exists:authors,id'],
        ]);
    }


    // Input data of the book to create
    public function createBook(Request $request){
        $validated= $this->validateBook($request);

        $title = $validated["title"];
        $price = $validated["price"];
        $year = $validated["year"];
        $authorId = $validated["author"];

        $book = new Book();
        $book->title = $title;
        $book->author_id = $authorId;
        $book->price = $price;
        $book->year = $year;
        $book->save();

        return redirect()->route('book.index')->with('success', 'Book created successfully!');
    }

    // Input data of the book to edit + $idBook
    public function editBook(request $request, $bookId){

        $title = $request->input('title');
        $price = $request->input('price');
        $year = $request->input('year');
        $authorId = $request->input('author');

        $book = Book::findOrFail($bookId);
        $book->title = $title;
        $book->author_id = $authorId;
        $book->price = $price;
        $book->year = $year;
        $book->save();
        return redirect()->route('book.index')->with('success', 'Book updated successfully!');
    }

    public function deleteBook($bookId){
        $book = Book::findOrFail($bookId);
        $book->deleteQuietly();

        return redirect()->route('book.index')->with('success', 'Book deleted successfully!');
    }
}

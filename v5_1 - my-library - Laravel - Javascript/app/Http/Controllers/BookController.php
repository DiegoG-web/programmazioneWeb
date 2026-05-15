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

    public function details($bookId) {
    
        $book = Book::findOrFail($bookId);
        return view('books.bookDetails', ["book"=>$book]);
    }


    public function viewForm($bookId = null) {
        $book= new Book();

        if($bookId){
            $book = Book::findOrFail($bookId);
        }
        $authors = Author::all();
    //   return response()->json([
    //         "book"=> $book,
    //         'authors'=> $authors
            
    //     ]);
        return  view('books.bookForm', [
            'book' => $book,
            'authors'=> $authors
        ]);
    }

    
    public function validateBook(Request $request): array {
        return $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'price' => ['required', 'numeric', 'min:0'], 
            'year' => ['required', 'integer', 'min:1000', 'max:'.date('Y')],
            'author' => ['required', 'exists:authors,id']
        ]);
    }

    // Input data of the book to create
    public function createBook(Request $request){
        $validated = $this->validateBook($request);
        
        $title = $validated["title"];
        $price = $validated["price"];
        $year = $validated["year"];
        $authorId = $validated["author"];

        $book = new Book();
        $book->title = $title;
        $book->price = $price;
        $book->year = $year;
        $book->author_id = $authorId;

        $book->save();
        //TODO Check Errors in and add flusshing session errors and success.
        return redirect()->route('book.index')->with('success', 'Libro creato correttamente');

    }

    // Input data of the book to edit + $idBook
    public function editBook(Request $request, $bookId){
        // $id = $request->input("bookId");
        $book = Book::findOrFail($bookId);
        
        $title = $request->input("title");
        $price = $request->input("price");
        $year = $request->input("year");
        $authorId = $request->input("author");

        $book->title = $title;
        $book->price = $price;
        $book->year = $year;
        $book->author_id = $authorId;


        $book->save();
        return redirect()->route('book.index');
        
    }

    public function deleteBook($bookId){
        $book = Book::findOrFail($bookId);
        $book->deleteQuietly();

        return redirect()->route('book.index')->with('success', 'Libro eliminato correttamente');
    }
}

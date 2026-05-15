<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;



class HomeController extends Controller
{
    public function getHome() {
        $countBooks = Book::count();
        $countAuthors = Author::count();
        return  view('index', [
            'countBooks' => $countBooks,
            'countAuthors'=> $countAuthors
        ]);
    }

    public function queryExample($id=null){
        $authors = Author::all();
        $books = Book::all();
        $countBooks = Book::count();

        $selectedBook = null;
        if($id){
            $selectedBook = Book::findOrFail($id);
        }

        return response()->json([
            "authors"=> $authors,
            "books"=> $books, 
            "booksNumber" => $countBooks,
            "selectedBook"=> $selectedBook
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;



class HomeController extends Controller
{
    private $provinces = ['BS', 'MI', 'RM'];
    private $provinceEComuni = [
        'BS' => [
            'Brescia',
            'Desenzano del Garda',
            'Montichiari',
            'Lonato del Garda',
            'Palazzolo sull\'Oglio',
            'Chiari',
            'Gussago',
            'Rovato',
            'Concesio',
            'Rezzato',
        ],

        'MI' => [
            'Milano',
            'Sesto San Giovanni',
            'Cinisello Balsamo',
            'Rho',
            'Legnano',
            'Cologno Monzese',
            'Paderno Dugnano',
            'Rozzano',
            'San Donato Milanese',
            'Segrate',
        ],

        'RM' => [
            'Roma',
            'Fiumicino',
            'Guidonia Montecelio',
            'Tivoli',
            'Pomezia',
            'Anzio',
            'Velletri',
            'Civitavecchia',
            'Ardea',
            'Nettuno',
        ],
    ];

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

    public function loadPageProvince(){
        $provinces = $this->provinces;
        return view('selectAddress', ["provinces" => $provinces]);
    }

    public function comuniByProvince($provinces){
        $comuni = $this->provinceEComuni[$provinces];
        return response()->json($comuni ?? []);
    }
}
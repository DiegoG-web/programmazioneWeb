<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    use SoftDeletes;

//    protected $table = "my_books"; //Personalizzazione nome della tabella
    protected $fillable = [
        "title",
        "year", 
        "price", 
        "author_id"
    ];

    public function author() {
        return $this->belongsTo(Author::class);
    }


    // public function genres(){
    //     return $this->belongsToMany(Genre::class);
    // }
}

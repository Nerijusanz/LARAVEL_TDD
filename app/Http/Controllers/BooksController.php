<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Book;

class BooksController extends Controller
{

    public function index()
    {

        return view('books.index');

    }

    public function store(Request $request)
    {

        Book::create( $this->_validate() );

        return redirect('/books')->with('success','Book Created');

    }

    public function update(Book $book)
    {

        $book->update( $this->_validate() );

        return redirect('/books/'.$book->id)->with('success','Book Updated');
        
    }

    public function destroy(Book $book)
    {
        
        $book->delete($book);

        return redirect('/books')->with('success','Book Deleted');
        
    }

    private function _validate()
    {

        $data = request()->validate([
            'title'=>['required','string','min:3','max:255'],
            'author'=>['required','string','min:2','max:255']
        ]);

        return $data;
    }


}

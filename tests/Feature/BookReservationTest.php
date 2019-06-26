<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Book;
use App\Author;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    public function testAddBookTitleRequired()
    {

        $data = $this->_data();
        $data['title'] = '';

        $response = $this->post('/books',$data);

        $this->assertCount(0,Book::all());

        $response->assertSessionHasErrors('title');

    }

    public function testAddBookTitleRequiredMinThreeStringSymbols()
    {

        $book = [
            'title'=>'BB',
            'author'=>'Book1 author'
        ];

        $response = $this->post('/books',$book);

        $this->assertCount(0,Book::all());

        $response->assertSessionHasErrors('title');

        
    }

    public function testAddBook()
    {

        $this->withoutExceptionHandling();

        $response = $this->post('/books',$this->_data());

        $this->assertCount(1,Book::all());
        
        //-----TEST REDIRECT-------------- //
        $book = Book::first();
        $response->assertRedirect($book->viewPath());
    }

    public function testUpdateBook()
    {

    //-----------ADD SECTION--------------
        $book = [
            'title'=>'Book1',
            'author'=>'Book1'
        ];

        $this->withoutExceptionHandling();

        $response = $this->post('/books',$book);

        //-----TEST BOOK CREATED -------------//
        $this->assertCount(1,Book::all());

        //-----TEST REDIRECT-------------- //
        $book = Book::first();
        $response->assertRedirect($book->viewPath());


    //------------UPDATE SECTION--------------

        //get added book by title
        //$currBook = Book::first();
        $currBook = Book::where([
            ['title','=',$book['title'] ],
            ['author','=',$book['author']]
            ])->first();
        
        $updBookId = $currBook->id;

        //update book
        $uBookData = [
            'title'=>'Book1 title updated',
            'author'=>'Book1 author updated'
        ];
        
        $response = $this->put('/books/'.$updBookId,$uBookData);

        //-----------TEST UPDATED DATA----------------------
        $updBook = Book::where('id','=',$updBookId)->first();
        
        $this->assertEquals($updBook->title,$uBookData['title']);
        $this->assertEquals($updBook->author,$uBookData['author']);

        //-----TEST REDIRECT-------------- //

        $response->assertRedirect($updBook->viewPathById());

    }

    public function testDeleteBook()
    {

        //-----------ADD SECTION--------------
        $book = [
            'title'=>'Book1',
            'author'=>'Book1'
        ];

        $this->withoutExceptionHandling();

        $response = $this->post('/books',$book);

        //---- TEST BOOK IS ADDEDD--------//

        $this->assertCount(1,Book::all());

        //-----TEST REDIRECT-------------- //
        $book = Book::first();
        $response->assertRedirect($book->viewPath());


    //--------------DELETE SECTION--------------

        //get added book by title
        //$currBook = Book::first();
        $currBook = Book::where([
            ['title','=',$book['title'] ],
            ['author','=',$book['author']]
            ])->first();
        

        $response = $this->delete('/books/'.$currBook->id);

        //-----------TEST DELETED DATA----------------------

        $this->assertCount(0,Book::all());
        
        //-----------TEST REDIRECT ------------------------
        
        $response->assertRedirect('/books');

    }

    private function _data()
    {
        return [
            'title'=>'Book1',
            'author'=>'Author1'
        ];
    }

}

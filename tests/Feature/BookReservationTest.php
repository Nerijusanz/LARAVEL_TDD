<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Book;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    public function testAddBook()
    {

        $this->withoutExceptionHandling();

        $book = [
            'title'=>'Book1 title',
            'author'=>'Book1 author'
        ];

        $this->post('/books',$book);

        $response = $this->get('/books');

        $response->assertOk();

        $this->assertCount(1,Book::all());
    }

    public function testUpdateBook()
    {

    //-----------ADD SECTION--------------
        $book = [
            'title'=>'Book1',
            'author'=>'Book1'
        ];

        $this->withoutExceptionHandling();

        $this->post('/books',$book);

        $response = $this->get('/books');

        $response->assertOk();

        $this->assertCount(1,Book::all());


    //------------UPDATE SECTION--------------

        //get added book by title
        //$currBook = Book::first();
        $currBook = Book::where('title','=',$book['title'])->first();
        
        $updBookId = $currBook->id;

        //update book
        $uBookData = [
            'title'=>'Book1 title updated',
            'author'=>'Book1 author updated'
        ];
        
        $this->put('/books/'.$updBookId,$uBookData);
        
        
        //-----------TEST REDIRECT ------------------------

        //after update redirect to books page
        $response = $this->get('/books'); 

        $response->assertOk();

        //-----------TEST UPDATED DATA----------------------
        $updBook = Book::where('id','=',$updBookId)->first();
        
        $this->assertEquals($updBook->title,$uBookData['title']);
        $this->assertEquals($updBook->author,$uBookData['author']);

    }


    public function testBookTitleRequired()
    {

        $book = [
            'title'=>'',
            'author'=>'Book1 author'
        ];

        $response = $this->post('/books',$book);

        $this->assertCount(0,Book::all());

        $response->assertSessionHasErrors('title');

        
    }

    public function testBookTitleRequiredMinThreeStringSymbols()
    {

        $book = [
            'title'=>'BB',
            'author'=>'Book1 author'
        ];

        $response = $this->post('/books',$book);

        $this->assertCount(0,Book::all());

        $response->assertSessionHasErrors('title');

        
    }

}

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

        $data = $this->_data();
        $data['title']='XX';

        $response = $this->post('/books',$data);

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
        $data = $this->_data();

        $this->withoutExceptionHandling();
        $response = $this->post('/books',$data);

        //-----TEST BOOK CREATED -------------//
        $this->assertCount(1,Book::all());

        //-----TEST REDIRECT-------------- //
        $book = Book::first();
        $response->assertRedirect($book->viewPath());


    //------------UPDATE SECTION--------------

        //get added book by title
        //$currBook = Book::first();
        $currBook = Book::where([
            ['title','=',$data['title'] ],
            ['author','=',$data['author']]
            ])->first();
        
        $currBookId = $currBook->id;


        $data['title'] = $data['title'] .' updated';
        $data['author'] = $data['author'] .' updated';

        $response = $this->put('/books/'.$currBookId,$data);

        //-----------TEST UPDATED DATA----------------------
        $updBook = Book::where('id','=',$currBookId)->first();
        
        $this->assertEquals($updBook->title,$data['title']);
        $this->assertEquals($updBook->author,$data['author']);

        //-----TEST REDIRECT-------------- //

        $response->assertRedirect($updBook->viewPathById());

    }

    public function testDeleteBook()
    {

        //-----------ADD SECTION--------------
        $data = $this->_data();

        $this->withoutExceptionHandling();

        $response = $this->post('/books',$data);

        //------- TEST BOOK IS ADDEDD--------//

        $this->assertCount(1,Book::all());

    //--------------DELETE SECTION--------------

        $currBook = Book::where([
            ['title','=',$data['title'] ],
            ['author','=',$data['author']]
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

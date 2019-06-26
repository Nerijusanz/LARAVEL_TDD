<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

use App\Author;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    public function testAddAuthor()
    {

        $this->withoutExceptionHandling();

        $data = [
            'name'=>'Author1',
            'dob'=>'1988/05/14' //dob=>data of birth
        ];

        $response = $this->post('/authors',$data);

        $author = Author::all();

        $this->assertCount(1,$author);
        $this->assertInstanceOf(Carbon::class,$author->first()->dob);   //test `dob` field catch  carbon instance format
        $this->assertEquals($data['dob'],$author->first()->dob->format('Y/m/d'));   //test if given data catch 'Y/m/d' format
        
        //-----TEST REDIRECT-------------- //
        $author = Author::first();
        $response->assertRedirect($author->viewPath());
    }

}

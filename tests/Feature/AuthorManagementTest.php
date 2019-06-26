<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->assertCount(1,Author::all());
        
        //-----TEST REDIRECT-------------- //
        $author = Author::first();
        $response->assertRedirect($author->viewPath());
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Author;

class AuthorsController extends Controller
{
    public function store(Author $author){

        Author::create($this->_validate() );

        return redirect($author->viewPath())->with('success','Author Created');

    }

    private function _validate()
    {

        $data = request()->validate([
            'name'=>['required','string','min:2','max:255'],
            'dob'=>['required','string']
        ]);

        return $data;
    }
}

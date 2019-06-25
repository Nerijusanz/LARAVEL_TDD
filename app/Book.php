<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public $viewPath='/books';


    public function viewPath(){

        return $this->viewPath;
    }

    public function viewPathById(){
        return $this->viewPath().'/'.$this->id;
    }
}

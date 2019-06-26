<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [];

    public $viewPath='/authors';


    public function viewPath(){

        return $this->viewPath;
    }

    public function viewPathById(){
        return $this->viewPath().'/'.$this->id;
    }
}

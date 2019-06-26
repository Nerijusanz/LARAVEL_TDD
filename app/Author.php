<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Author extends Model
{
    protected $guarded = [];

    public $viewPath='/authors';

    protected $dates = ['dob']; //dob timestamp format field 

    //note: func() name structure set{FieldName}Attribute(${fieldname});
    public function setDobAttribute($dob)
    {
        $this->attributes['dob'] = Carbon::parse($dob); //parse field into carbon format
    }


    public function viewPath(){

        return $this->viewPath;
    }

    public function viewPathById(){
        return $this->viewPath().'/'.$this->id;
    }
}

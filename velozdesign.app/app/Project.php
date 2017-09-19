<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Project extends Eloquent
{

    protected $collection = 'projects';

    protected $fillable = ['title', 'designer_id', 'content', 'image', 'video'];


    public function getImageOfProject($project_id){
    	
    }
}

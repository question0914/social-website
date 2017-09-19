<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Review extends Eloquent
{

    protected $collection = 'reviews';

    protected $fillable = ['user_id', 'project_id', 'reviewer_id', 'rate', 'title', 'content', 'images', 'created_time'];

}

<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Image extends Eloquent
{

    protected $collection = 'images';

    protected $fillable = ['user_id', 'project_id', 'link', 'title', 'content', 'viewed_time'];

}

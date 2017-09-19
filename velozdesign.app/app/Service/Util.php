<?php

namespace App\Service;

use MongoDB\BSON\ObjectID;

class Util
{

    public static function getObjectId($id) {
        if (($id instanceof ObjectID) || !(preg_match('/^[a-f\d]{24}$/i', $id)))
            die("wrong_id");
        else 
            return new ObjectID($id);
    }

    public static function checkProfileId($id) {
        if (($id instanceof ObjectID) || !(preg_match('/^[a-f\d]{24}$/i', $id)))
            return true;
        else 
        	return false;
    }
}

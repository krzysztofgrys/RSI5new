<?php
/**
 * Created by PhpStorm.
 * User: krzysztofgrys
 * Date: 6/17/17
 * Time: 5:45 PM
 */

namespace App\Models;


class Book implements \JsonSerializable
{
    public $id = null;
    public $title = null;
    public $author = null;

    public function __construct($id, $title, $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
    }

    protected function publishAttributes(){
        $x = new \stdClass();
        $x->id = $this->id;
        $x->title = $this->title;
        $x->author = $this->author;
    }

    public function jsonSerialize()
    {
        return $this;
    }
}
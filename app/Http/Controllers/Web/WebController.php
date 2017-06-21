<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;


class WebController extends Controller
{
    public function returnBooks(){

        $url = "localhost:8899/api/v1/books";
        $data = $this->curl($url);

        var_dump($data);

        return view('library');

    }



    public function searchBook(){
        return view('library');

    }
}

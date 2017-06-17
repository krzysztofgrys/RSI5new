<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Book as BookModel;
use App\Models as Book;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\HttpException;


class LibraryController extends Controller
{
    public function index()
    {
        $books = BookModel::all();
        $response = [];

        foreach ($books as $book) {
            $response[] = new Book\Book($book->id, $book->title, $book->author);
        }

        return json_encode(["data" => $response], JSON_PRETTY_PRINT);
    }


    public function show($id)
    {
        $rules = [
            'id' => 'required|Integer'
        ];
        $validator = Validator::make(['id' => $id], $rules);

        if ($validator->fails()) {
            return json_encode(['code' => 404, 'message' => "wrong parameter"], JSON_PRETTY_PRINT);
        }

        $book = BookModel::where('id', $id)->get()->first();

        if (empty($book)) {
            return json_encode(['code' => 404, 'message' => "book not found"], JSON_PRETTY_PRINT);
        }

        $data = new Book\Book($book->id, $book->title, $book->author);
        $response = ['data' => $data];

        return $response;

    }


    public function add(Request $request)
    {
        $title = $request->title;
        $author = $request->author;

        $rules = [
          'title' => 'required', 'author' => 'required'
        ];
        $validator = Validator::make(['title' => $title, 'author' => $author], $rules);

        if($validator->fails()){
            return json_encode(['code' => 400, 'message' => 'title and author are reuqired'], JSON_PRETTY_PRINT);
        }

        $book = new BookModel();
        $book->title = $title;
        $book->author = $author;
        $book->save();


        $id = BookModel::all()->sortByDesc('id')->first();
        $href = ['href'=>'/api/v1/book/'.$id->id];
        $data = ['data'=> $href];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }


    public function delete($id){
        $rules = [
            'id' => 'required|Integer'
        ];
        $validator = Validator::make(['id' => $id], $rules);

        if ($validator->fails()) {
            return json_encode(['code' => 404, 'message' => "wrong parameter"], JSON_PRETTY_PRINT);
        }
        $book = BookModel::where('id', $id)->delete();

        if (empty($book)) {
            return json_encode(['code' => 404, 'message' => "book not found"], JSON_PRETTY_PRINT);
        }


        return json_encode(['code' => 200, 'message' => 'OK'], JSON_PRETTY_PRINT);
    }


}

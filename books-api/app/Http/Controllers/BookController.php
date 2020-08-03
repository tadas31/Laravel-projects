<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as ResourcesBook;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        if (sizeof($books) > 0)
            return ResourcesBook::collection($books);

        return response()->json(['error' => 'Not found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $book = Book::create($request->all());
        return new ResourcesBook($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $book = Book::FindOrFail($id);
            return new ResourcesBook($book);
        }
        catch (Exception $ex) {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validator($request);
        if ($validator->fails())
            return response()->json($validator->errors(), 400);
        
        try {
            $book = Book::FindOrFail($id);
            $book->update($request->all());
            return response()->noContent();
        }
        catch (Exception $ex) {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $book = Book::FindOrFail($id);
            $book->delete();
            return response()->noContent();
        }
        catch (Exception $ex) {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function validator(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'author_id' => 'numeric|exists:authors,id|nullable'
        ]);
        return $validator;
    }
}

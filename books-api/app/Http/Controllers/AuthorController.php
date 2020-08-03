<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Resources\Author as ResourcesAuthor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        if (sizeof($authors) > 0)
            return ResourcesAuthor::collection($authors);
  
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

        if ($request->name == null && $request->last_name == null && $request->alias == null)
            return response()->json(['all_fields' => ['at least one field is required out of name, last_name and alias']], 400);

        $author = Author::create($request->all());
        return new ResourcesAuthor($author);
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
            $author = Author::FindOrFail($id);
            return new ResourcesAuthor($author);
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
        if($validator->fails())
            return response()->json($validator->errors(), 400);

        if ($request->name == null && $request->last_name == null && $request->alias == null)
            return response()->json(['all_fields' => ['at least one field is required out of name, last name and alias']], 400);
        
        try {
            $author = Author::FindOrFail($id);
            $author->update($request->all());
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
            $author = Author::FindOrFail($id);
            $author->delete();
            return response()->noContent();
        }
        catch (Exception $ex) {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function validator(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => [
                'nullable',
                'regex:/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+$/'
            ],
            'last_name' => [
                'nullable',
                'regex:/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+$/'
            ],
            'birthday' => 'date_format:Y-m-d'
        ]);
        return $validator;
    }
}

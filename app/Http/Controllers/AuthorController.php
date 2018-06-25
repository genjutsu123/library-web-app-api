<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $authors = Author::where('deleted_at', NULL)->get();
        $authors->each(function ($item, $key) {
            $item['books'] = $item->book;
        });
        return response()->json($authors);
    }

    public function getdeleted() {
        log::info('authorgetdeleted');
//        $data = Author::onlyTrashed()->get();
        $data = DB::table('authors')->whereNotNull('deleted_at')->pluck('id');
        $data = Author::find($data);

        $data->each(function ($item, $key) {
            $item['books'] = $item->book;
        });

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|unique:authors',
        ]);
        if ($validator->fails()) {
            return response("ERROR: Author already exists!", 500);
        } else {
            $author = Author::create($request->all());
            return response($author, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $author = Author::find($id);
        $author['books'] = $author->book;
        return response()->json($author);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        Author::where('id',$id)->update($request->all());
        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Author::destroy($id);
    }

    public function restore(Request $request) {
        Author::onlyTrashed()->find($request->id)->restore();
    }
}

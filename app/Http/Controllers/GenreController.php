<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::where('deleted_at',NULL)->get();
        $genres->each( function($item, $key) {
            $item['books'] = $item->book;
        });
        return response()->json($genres);
    }

    public function getdeleted()
    {
        log::info('genregetdeleted');
        $data = DB::table('genres')->whereNotNull('deleted_at')->pluck('id');
        $data = Genre::find($data);

        $data->each( function ($item, $key){
            $item['books'] = $item->book;
        });

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'bail|unique:genres',
        ]);
        if ($validator->fails()){
            return response("ERROR: Genre already exists!", 500);
        }else{
            $genre = Genre::create($request->all());
            return response($genre, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        $genre['books'] = $genre->book;
        return response()->json($genre);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Genre::where('id',$id)->update($request->all());
        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Genre::destroy($id);
    }

    public function restore(Request $request){
        Genre::onlyTrashed()->find($request->id)->restore();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shelf;
use App\Book;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Validator;
class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shelves = Shelf::where('deleted_at',NULL)->get();
        $shelves->each( function ($item, $key){
           $item['books'] = $item->book;
        });
        return response()->json($shelves);
    }

    public function getdeleted()
    {
        log::info('shelvegetdeleted');
        $data = DB::table('shelves')->whereNotNull('deleted_at')->pluck('id');
        $data = Shelf::find($data);

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
    public function create(Request $request)
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
            'name' => 'bail|unique:shelves',
        ]);
        if ($validator->fails()){
            return response("ERROR: Shelve already exists!", 500);
        }else{
            $shelve = Shelf::create($request->all());
            return response($shelve, 200);
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
        $shelve = Shelf::find($id);
        $shelve['books'] = $shelve->book;
        return response()->json($shelve);

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
        Shelf::where('id',$id)->update($request->all());
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
        Shelf::destroy($id);
    }

    public function restore(Request $request){
        Shelf::onlyTrashed()->find($request->id)->restore();
    }
}

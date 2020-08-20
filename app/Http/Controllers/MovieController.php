<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::index_default(['turns']);
        $response = (request()->wantsJson()) ? response()->json($movies) : view('movies.index', compact('movies'));
        return $response;
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
        $response = Movie::store_with_file($request);
        return response()->json($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Movie::show_default($id);
        return response()->json($response, $response['code']);
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
        $response = Movie::update_default($request, Movie::$rules, $id);
        return response()->json($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Movie::destroy($id);
        return response()->json($response, $response['code']);
    }

    /**
     * Activate or desactivate an item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activator(Request $request, $id)
    {
        $response = Movie::update_default($request, Movie::rules_activator(), $id);
        return response()->json($response, $response['code']);
    }
    
    /**
     * Activate or desactivate an item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_turns(Request $request, $id)
    {
        $response = Movie::update_many_to_many($request, $id, "turns", "turns_id");
        return response()->json($response, $response['code']);
    }
}

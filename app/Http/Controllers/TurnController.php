<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turn;

class TurnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turns = Turn::index_default(['movies']);
        $response = (request()->wantsJson()) ? response()->json($turns) : view('turns.index', compact('turns'));
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
        $response = Turn::store_default($request);
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
        $response = Turn::show_default($id);
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
        $response = Turn::update_default($request, Turn::$rules, $id);
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
        $response = Turn::destroy($id);
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
        $response = Turn::update_default($request, Turn::rules_activator(), $id);
        return response()->json($response, $response['code']);
    }
}

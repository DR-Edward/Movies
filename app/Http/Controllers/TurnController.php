<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TurnCreateRequest;
use App\Http\Requests\TurnUpdateRequest;
use App\Http\Requests\TurnActivatorRequest;
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
    public function store(TurnCreateRequest $request)
    {
        $response = Turn::store_default($request->all());
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
    public function update(TurnUpdateRequest $request, $id)
    {
        $response = Turn::update_default($request->all(), $id);
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
    public function activator(TurnActivatorRequest $request, $id)
    {
        $response = Turn::update_default($request->all(), $id);
        return response()->json($response, $response['code']);
    }
}

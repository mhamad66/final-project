<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;

class ShowroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Showroom::all();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Showroom::create([
            'name' => $request['name'],
            'district' => $request['district'],
            'address' => $request['address'],
            'total_space' => $request['total_space'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
            'avg_sales' => $request['avg_sales'],

        ]);
        return response()->json(['Message' => 'Stored Successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showroom = Showroom::find($id);
        return $showroom->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Showroom::where('id', $id)->update([
            'name' => $request['name'],
            'district' => $request['district'],
            'address' => $request['address'],
            'total_space' => $request['total_space'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
            'avg_sales' => $request['avg_sales'],
        ]);
        return response()->json(['Message' => 'Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Showroom::destroy($id);

        return response()->json(['Message' => 'Deleted Successfully'], 200);
    }
}

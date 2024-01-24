<?php

namespace App\Http\Controllers\CommodityLocations\Ajax;

use App\CommodityLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommodityLocationAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048', // Adjust file types and size limit as needed
        ]);

        $commodity_location = new CommodityLocation();
        $commodity_location->name = $request->name;
        $commodity_location->description = $request->description;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('images'), $fileName);
            $commodity_location->file_path = 'images/' . $filePath;
        }

        $commodity_location->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commodity_location = CommodityLocation::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commodity_location = CommodityLocation::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048', // Adjust file types and size limit as needed
        ]);

        $commodity_location = CommodityLocation::findOrFail($id);
        $commodity_location->name = $request->name;
        $commodity_location->description = $request->description;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('images'), $fileName);
            $commodity_location->file_path = 'images/' . $filePath;
        }

        $commodity_location->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity_location], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Commodity_Location = CommodityLocation::findOrFail($id)->delete();

        if ($Commodity_Location->file_path) {
            $filePath = 'images/' . basename($Commodity_Location->file_path);
            $fullPath = public_path($filePath);
    
            // Delete the file from storage
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
    
            // Delete the file record from the database
            Storage::delete($filePath);
        }

        $Commodity_Location->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}

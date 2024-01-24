<?php

namespace App\Http\Controllers\SchoolOperationalAssistances\Ajax;

use App\Http\Controllers\Controller;
use App\SchoolOperationalAssistance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolOperationalAssistanceAjaxController extends Controller
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
            'file' => 'file|mimes:pdf,doc,docx|max:2048', // Adjust file types and size limit as needed
        ]);

        $school_operational_assistance = new SchoolOperationalAssistance();
        $school_operational_assistance->name = $request->name;
        $school_operational_assistance->description = $request->description;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(('images'), $fileName);
            $school_operational_assistance->file_path = 'images/' . $filePath;
        }

        $school_operational_assistance->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
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
            'file_edit' => 'file|mimes:pdf,doc,docx|max:2048', // Adjust file types and size limit as needed
        ]);

        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);
        $school_operational_assistance->name = $request->name;
        $school_operational_assistance->description = $request->description;

        // Handle file upload for editing
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(('images'), $fileName);
            $school_operational_assistance->file_path = 'images/' . $filePath;
        }

        $school_operational_assistance->save();

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $school_operational_assistance], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school_operational_assistance = SchoolOperationalAssistance::findOrFail($id);

        // Delete the associated file if it exists
        if ($school_operational_assistance->file_path) {
            $filePath = 'images/' . basename($school_operational_assistance->file_path);
            $fullPath = public_path($filePath);
        
            // Delete the file from storage
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        
            // Delete the file record from the database
            Storage::delete($filePath);
        }
        

        $school_operational_assistance->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}

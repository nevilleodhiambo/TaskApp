<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = $request->all();

        $errors = Validator::make($field, [
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',

        ]);
        
        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $project = Project::create([
            'name' => $field['name'],
            'startDate' => $field['startDate'],
            'endDate' => $field['endDate'],
            'status' => Project::NOT_STARTED,
            'slug' => Project::createSlug($field['startDate'])
        ]);
        
        return response(['project' => $project, 'message' => 'Project Created Successfull'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        $field = $request->all();

        $errors = Validator::make($field, [
            'id' => 'required',
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',

        ]);
        
        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $project = Project::where('id', $field['id'])->update([
            'name' => $field['name'],
            'startDate' => $field['startDate'],
            'endDate' => $field['endDate'],
            'status' => Project::NOT_STARTED,
            'slug' => Project::createSlug($field['startDate'])
        ]);

        // $project = Project::create([
        //     'name' => $field['name'],
        //     'startDate' => $field['startDate'],
        //     'endDate' => $field['endDate'],
        //     'status' => Project::NOT_STARTED,
        //     'slug' => Project::createSlug($field['startDate'])
        // ]);
        
        return response(['project' => $project, 'message' => 'Project Updated Successfull'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}

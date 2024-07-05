<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TaskProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = $request->get('query');
        $projects = Project::with(['taskProgress']);

        if (!is_null($query) && $query !== '') {
            $projects->where('name', 'like', '%' . $query . '%')
                ->orderBy('id', 'desc');

            return response(['data' => $projects->paginate(10)], 200);
        }
        return response(['data' => $projects->paginate(10)], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function getProject(Request $request, $slug)
    {
        $project = Project::with(['tasks.taskMembers.member'])
            ->where('slug', $slug)->first();

        return response(['data' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
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
            TaskProgress::create([
                'projectId' => $project->id,
                'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD,
                'progress' => TaskProgress::INITIAL_PROJECT_PERCENT,
            ]);

            return response(['project' => $project, 'message' => 'Project Created Successfull'], 200);
        });
    }

    public function pinnedProject(Request $request)
    {
        $field = $request->all();

        $errors = Validator::make($field, [
            'projectId' => 'required|numeric',

        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }
        TaskProgress::where('projectId', $field['projectId'])
            ->update([
                'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD,
            ]);
        return response(['mesage', 'Pinned On Dashboard!']);
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

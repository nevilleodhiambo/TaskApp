<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = $request->get('query');
        // $members = Member::with(['taskProgress']);
        $members = DB::table('members');

        if (!is_null($query) && $query !== '') {
            $members->where('name', 'like', '%' . $query . '%')
                ->orderBy('id', 'desc');

            return response(['data' => $members->paginate(10)], 200);
        }
        return response(['data' => $members->paginate(10)], 200);
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
        return DB::transaction(function () use ($request) {
            $field = $request->all();

            $errors = Validator::make($field, [
                'name' => 'required',
                'email' => 'required|email',

            ]);

            if ($errors->fails()) {
                return response($errors->errors()->all(), 422);
            }

            $member = Member::create([
                'name' => $field['name'],
                'email' => $field['email'],
            ]);
            // TaskProgress::create([
            //     'projectId' => $project->id,
            //     'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD,
            //     'progress' => TaskProgress::INITIAL_PROJECT_PERCENT,
            // ]);

            return response(['member' => $member, 'message' => 'Member Created Successfull'], 200);
        });
    }


    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
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
            'id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required',

        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $member = Member::where('id', $field['id'])->update([
            'name' => $field['name'],
            'email' => $field['email'],
        ]);

        // $project = Project::create([
        //     'name' => $field['name'],
        //     'startDate' => $field['startDate'],
        //     'endDate' => $field['endDate'],
        //     'status' => Project::NOT_STARTED,
        //     'slug' => Project::createSlug($field['startDate'])
        // ]);

        return response(['member' => $member, 'message' => 'Member Updated Successfull'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}

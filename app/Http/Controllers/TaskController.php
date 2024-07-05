<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createTask(Request $request)
    {

        DB::transaction(function () use ($request) {
            $field = $request->all();

            $errors = Validator::make($field, [
                'name' => 'required',
                'projectId' => 'required|numeric',
                'memberIds' => 'required|array',
                'memberIds.*' => 'numeric',
            ]);

            if ($errors->fails()) {
                return response()->json($errors->errors()->all(), 422);
            }

            $task = Task::create([
                'projectId' => $field['projectId'],
                'name' => $field['name'],
                'status' => Task::NOT_STARTED,
            ]);

            $members = $field['memberIds'];
            foreach ($members as $memberId) {
                TaskMember::create([
                    'projectId' => $field['projectId'],
                    'taskId' => $task->id,
                    'memberId' => $memberId,
                ]);
            }
            return response(['message' => 'Task Created Successfully']);
        });
    }

    public function taskNotStartedToPending(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::PENDING);

        return response(['message', 'task moved to pending']);
    }
    public function taskNotStartedToCompleted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::COMPLETED);

        return response(['message', 'task moved to Completed']);
    }

    public function taskPendingToCompleted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::COMPLETED);
        return response(['message', 'task moved to Completed']);
    }

    public function taskPendingToNotStarted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::NOT_STARTED);

        return response(['message', 'task moved to Not Started']);
    }
    public function taskCompletedToPending(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::PENDING);

        return response(['message', 'task moved to Not Started']);
    }

    public function taskCompletedToNotStarted(Request $request)
    {
        Task::changeTaskStatus($request->taskId, Task::NOT_STARTED);

        return response(['message', 'task moved to Not Started']);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}

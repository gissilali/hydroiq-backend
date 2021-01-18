<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssignedMail;
use App\Models\Task;
use App\Models\User;
use App\Transformers\TaskTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function assignTaskToUsers(Request $request, $task_id)
    {
        try {
            $task = Task::findOrFail($task_id);
            $users = User::select(['email', 'id'])->whereIn('id', $request->assigned_users)->get();

            $task->assignToUsers($users->pluck('id')->toArray());

            try {
                Mail::to([$users->pluck('email')->toArray()])
                    ->send(new TaskAssignedMail($task->refresh()));
            } catch (\Swift_TransportException $exception) {
                $userCount = $users->count();
                return response()->json([
                    'message' => "email sent to {$userCount} " . Str::plural('user', $userCount),
                    'data' => $task->refresh()
                ], 201);
            }


        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => __('could not find requested task')
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $currentUser = $request->user();
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'admin_id' => $currentUser->id
        ]);

        $task->assignToUsers($request->assigned_users, $currentUser->id);

        return response()->json([
            'data' => fractal($task->refresh(), new TaskTransformer())
        ], 201);
    }

    public function index(Request $request)
    {
        $tasks = Task::where('id', 'desc')->get();
        return response()->json([
            'data' => fractal($tasks, new TaskTransformer())
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssignedMail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TasksController extends Controller
{
    public function assignTaskToUsers(Request $request, $task_id)
    {
        try {
            $task = Task::findOrFail($task_id);
            $users = User::select(['email', 'id'])->whereIn('id', $request->user_ids)->get();
            foreach ($users as $user) {
                $task->users()->attach([$request->user_ids], [
                    'assigned_by' => $request->user()->id,
                ]);
            }

            Mail::to([$users->pluck('email')->toArray()])
                ->send(new TaskAssignedMail($task->refresh()));


        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message'  => __('could not find requested task')
            ]);
        }
    }
}

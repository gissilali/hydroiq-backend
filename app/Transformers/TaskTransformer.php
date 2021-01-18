<?php

namespace App\Transformers;

use App\Models\Task;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'due_date' =>  Carbon::parse($user->date_of_birth)->format('M d, Y'),
            'assigned_users' => fractal($task->users, new UserTransformer())
        ];
    }
}

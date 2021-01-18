<?php

namespace App\Transformers;

use App\Models\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'tasks_assigned' => $user->tasks->count(),
            'date_of_birth' => Carbon::parse($user->date_of_birth)->format('M d, Y')
        ];
    }
}

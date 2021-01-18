<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'due_date',
        'admin_id'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function assignToUsers(array $userIds, int $creatorId)
    {
        foreach ($userIds as $userId) {
            $this->users()->attach($userId, [
                'assigned_by' => $creatorId,
            ]);
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tasks_users_join', 'task_id', 'user_id')->withTimestamps();
    }
}

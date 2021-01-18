@component('mail::message')
# A task has been assigned to you.



@component('mail::button', ['url' => url('tasks/{task_id}')])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

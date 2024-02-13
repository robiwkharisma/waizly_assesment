<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, HasFactory;

	protected $table = 'tasks';

	protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	protected $fillable = [
        'title',
        'description',
        'due_date',
        'time_estimate',
        'task_statuses_id',
        'assigned_to',
	];

	public function setAttributeFromJson($attributes)
	{
		if (isset($attributes['title'])) {
			$this->title = $attributes['title'];
		}
		if (isset($attributes['description'])) {
			$this->description = $attributes['description'];
		}
		if (isset($attributes['due_date'])) {
			$this->due_date = $attributes['due_date'];
		}
		if (isset($attributes['time_estimate'])) {
			$this->time_estimate = $attributes['time_estimate'];
		}
		if (isset($attributes['task_statuses_id'])) {
			$this->task_statuses_id = $attributes['task_statuses_id'];
		}
		if (isset($attributes['assigned_to'])) {
			$this->assigned_to = $attributes['assigned_to'];
		}
	}
}

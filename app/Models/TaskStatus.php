<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use SoftDeletes, HasFactory;

	protected $table = 'task_statuses';

	protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
	];

	public function setAttributeFromJson($attributes)
	{
		if (isset($attributes['name'])) {
			$this->name = strtoupper($attributes['name']);
		}
	}
}

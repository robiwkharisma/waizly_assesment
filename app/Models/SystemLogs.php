<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLogs extends Model
{
	use HasFactory;

	protected $table = 'system_logs';

	protected $primaryKey = 'id';

	protected $fillable = [
		'type',
		'status',
		'data',
		'message',
	];

	public function setAttributeFromJson($attributes)
	{
		if (isset($attributes['type'])) {
			$this->type = $attributes['type'];
		}
		if (isset($attributes['status'])) {
			$this->status = $attributes['status'];
		}
		if (isset($attributes['data'])) {
			$this->data = json_encode($attributes['data']);
		}
		if (isset($attributes['message'])) {
			$this->message = $attributes['message'];
		}
	}
}

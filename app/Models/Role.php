<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Role extends Model
{
    use SoftDeletes, HasFactory;

	protected $table = 'roles';

	protected $dates = ['deleted_at'];

	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'slug',
	];

	public function setAttributeFromJson($attributes)
	{
		if (isset($attributes['name'])) {
			$this->name = $attributes['name'];
		}
		if (isset($attributes['slug'])) {
			$this->slug = Str::kebab($this->name);
		}
	}
}

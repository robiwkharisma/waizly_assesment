<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'nik',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'is_active',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

	public function setAttributeFromJson($attributes)
	{
		if (isset($attributes['email'])) {
			$this->email = $attributes['email'];
		}
		if (isset($attributes['password'])) {
			$this->password = Hash::make($attributes['password']);
		}
		if (isset($attributes['nik'])) {
			$this->nik = $attributes['nik'];
		}
		if (isset($attributes['first_name'])) {
			$this->first_name = $attributes['first_name'];
		}
		if (isset($attributes['middle_name'])) {
			$this->middle_name = $attributes['middle_name'];
		}
		if (isset($attributes['last_name'])) {
			$this->last_name = $attributes['last_name'];
		}
		if (isset($attributes['gender'])) {
			$this->gender = $attributes['gender'];
		}
		if (isset($attributes['is_active'])) {
			$this->is_active = $attributes['is_active'];
		}
		if (isset($attributes['role_id'])) {
			$this->role_id = $attributes['role_id'];
		}
	}
}

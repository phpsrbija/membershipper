<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
		'first',
		'last',
		'email',
		'nickname',
		'username',
		'password',
		'password_salt',
		'password_verified',
		'active',
		'github_profile_url',
		'manualy_uploaded_biografy_file_url',
		'about_me',
		'profile_image_url',
    ];
}
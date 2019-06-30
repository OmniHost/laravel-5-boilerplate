<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RadiostationContests;
use App\Models\Auth\User;

class Upload extends Model
{
    protected $fillable = [
		'filename', 'original'
	];

	public function contest(){
		return $this->belongsTo(RadiostationContests::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
}

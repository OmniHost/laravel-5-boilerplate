<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ActionButtons;

class RadiostationUsers extends Model
{
	use ActionButtons;

	protected $fillable = ['user_id','radiostation_id'];

	protected $attributes = [
        'administrator' => 0
    ];
}

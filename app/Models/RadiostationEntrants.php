<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ActionButtons;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;
use App\Models\RadiostationContests;

class RadiostationEntrants extends Model
{

	use ActionButtons, SoftDeletes,Uuid;

	protected $fillable = ['name','email','mobile','recording','completed','ipaddress','radiostation_contests_id'];

	protected $buttons = [
		'route' => 'admin.stations',
		'edit' => true,
		'delete' => true,
		'custom' => [

		]
	];

	protected $attributes = [
		'name' => '',
		'email' => '',
		'ipaddress' => ''
	];


	public function getContest(){
		return RadiostationContests::find($this->radiostation_contests_id);
		//radiostation_contests_id
	}

	public function getStation(){
		return $this->getContest()->getStation();
	}

}

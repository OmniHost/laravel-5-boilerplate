<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ActionButtons;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;
use App\Models\RadiostationContests;
use App\Models\Radiostation;

use Illuminate\Notifications\Notifiable;

use App\Notifications\ContestEntered;

class RadiostationEntrants extends Model
{

	use ActionButtons, SoftDeletes,Uuid, Notifiable;

	protected $fillable = ['name','email','mobile','recording','recording_url','completed','ipaddress','radiostation_contests_id'];

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
		'ipaddress' => '',
		'completed' => 0,
		'recording_url' => ''
	];


	public function getContest(){
		return RadiostationContests::find($this->radiostation_contests_id);
		//radiostation_contests_id
	}

	public function getStation(){
		return $this->getContest()->getStation();
	}


	public function routeNotificationForNexmo($notification)
    {
        return $this->mobile;
	}

	public function contest()
    {
        return $this->hasOne(RadiostationContests::class, 'id', 'radiostation_contests_id');
	}

	public function station(){
		return $this->hasOneThrough(
            Radiostation::class,
            RadiostationContests::class,
            'id', // Foreign key on contest table...
            'id', // Foreign key on station table...
            'radiostation_contests_id', // Local key on CURRENT table...
            'radiostation_id' // Local key on contest table...
        );
	}

}

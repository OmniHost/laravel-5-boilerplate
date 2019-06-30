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

	protected $fillable = ['first_name','last_name','email','mobile','recording','recording_url','completed','ipaddress','radiostation_contests_id','optin','message_image'];

	protected $buttons = [
		'route' => 'admin.entrants',
		'edit' => false,
		'delete' => true,
		'custom' => [
			'getCallButtonAttribute'
		]
	];

	protected $attributes = [
		'name' => '',
		'email' => '',
		'ipaddress' => '',
		'completed' => 0,
		'recording_url' => ''
	];




	/**
     * @return string
     */
    public function getCallButtonAttribute()
    {
		return '<a href="'.route('admin.entrants.download', ['uuid' => $this->uuid]).'" class="btn btn-success"><i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="'.__('Download Recording').'"></i></a>';
   }

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

	 /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route($this->buttons['route'] . '.destroy', ['station' => $this->station->id, 'contest' => $this->radiostation_contests_id, $this ]).'"
			 data-method="delete"
			 data-trans-button-cancel="'.__('buttons.general.cancel').'"
			 data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
			 data-trans-title="'.__('strings.backend.general.are_you_sure').'"
			 class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a> ';
	}

	public function shareImage(){
		return $this->hasOne(Upload::class,'id','message_image');
	}

}

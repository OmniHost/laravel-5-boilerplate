<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ActionButtons;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

use App\Models\Radiostation;

class RadiostationContests extends Model
{
	use ActionButtons, SoftDeletes, Sluggable;

	protected $fillable = ['name','start','end','enabled','radiostation_id','unique_entrants'];

	protected $buttons = [
		'route' => 'admin.contests',
		'edit' => true,
		'delete' => true,
		'custom' => [
			'getContestantsButtonAttribute'
		]
	];



	protected $attributes = [
        'unique_entrants' => 0
	];


		   /**
     * @return string
     */
    public function getContestantsButtonAttribute()
    {
        return '<a href="'.route('admin.contests.index', $this).'" class="btn btn-success"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="'.__('Contestants').'"></i></a>';
    }

	public function getStationAttribute($value)
	{
		return $this->attributes['radiostation_id'];
	}


	public function getStation(){
		return Radiostation::find($this->radiostation_id);
	}

	/**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
	}

		   /**
     * @return string
     */
    public function getEditButtonAttribute()
    {

        return '<a href="'.route($this->buttons['route'] . '.edit', ['station' => $this->station, 'context' => $this->id ]).'" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
	}

	 /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route($this->buttons['route'] . '.destroy', ['station' => $this->station, 'context' => $this->id ]).'"
			 data-method="delete"
			 data-trans-button-cancel="'.__('buttons.general.cancel').'"
			 data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
			 data-trans-title="'.__('strings.backend.general.are_you_sure').'"
			 class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a> ';
    }
}

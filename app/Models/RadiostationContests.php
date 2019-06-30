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

	protected $fillable = ['name','start','end','enabled','radiostation_id','unique_entrants','message','upload_id', 'image1', 'image2', 'image3', 'image4'];

	protected $buttons = [
		'route' => 'admin.contests',
		'edit' => true,
		'delete' => true,
		'custom' => [
			'getContestantsButtonAttribute'
		]
	];

	    /**
     * @var array
     */
    protected $dates = [
        'start',
        'end',
    ];



	protected $attributes = [
        'unique_entrants' => 0
	];


		   /**
     * @return string
     */
    public function getContestantsButtonAttribute()
    {
        return '<a href="'.route('admin.entrants.index', ['station' => $this->radiostation_id, 'contest' => $this->id]).'" class="btn btn-success"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="'.__('Contestants').'"></i></a>';
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


	public function upload(){
		return $this->hasOne(Upload::class,'id','upload_id');
	}

	public function imageOne(){
		return $this->hasOne(Upload::class,'id','image1');
	}
	public function imageTwo(){
		return $this->hasOne(Upload::class,'id','image2');
	}
	public function imageThree(){
		return $this->hasOne(Upload::class,'id','image3');
	}
	public function imageFour(){
		return $this->hasOne(Upload::class,'id','image4');
	}
}

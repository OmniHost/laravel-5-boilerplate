<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ActionButtons;
use Cviebrock\EloquentSluggable\Sluggable;

class Radiostation extends Model
{
	use ActionButtons, Sluggable;
	//
	protected $fillable = ['name','timezone'];

	protected $buttons = [
		'route' => 'admin.stations',
		'edit' => true,
		'delete' => true,
		'custom' => [
			'getContestsButtonAttribute'
		]
	];

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
    public function getContestsButtonAttribute()
    {
        return '<a href="'.route('admin.contests.index', $this).'" class="btn btn-success"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="'.__('Station Users').'"></i></a>';
    }

}

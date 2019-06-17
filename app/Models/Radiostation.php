<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ActionButtons;

class Radiostation extends Model
{
	use ActionButtons;
	//
	protected $fillable = ['name'];

	protected $buttons = [
		'route' => 'admin.stations',
		'edit' => true,
		'delete' => true,
		'custom' => [
			'getContestsButtonAttribute'
		]
	];


	   /**
     * @return string
     */
    public function getContestsButtonAttribute()
    {
        return '<a href="'.route('admin.contests.index', $this).'" class="btn btn-success"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="'.__('Station Users').'"></i></a>';
    }

}

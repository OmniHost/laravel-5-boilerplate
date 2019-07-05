<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\RadiostationContests;

/**
 * @property integer $id
 * @property integer $contest_id
 * @property string $subject
 * @property string $body
 * @property string $schedule
 * @property string $initials
 * @property string $suburb
 * @property boolean $is_sms
 * @property boolean $running
 * @property boolean $completed
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property RadiostationContest $radiostationContest
 */
class RadiostationNotifications extends Model
{


    /**
     * @var array
     */
	protected $fillable = ['contest_id', 'subject', 'body', 'schedule', 'initials', 'suburb', 'is_sms'];

	protected $dates = [
        'schedule',
	];

	protected $attributes = [
		'running' => 0,
		'completed' => 0
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function radiostationContest()
    {
        return $this->belongsTo(RadiostationContests::class, 'contest_id');
    }
}

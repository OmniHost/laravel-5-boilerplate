<?php namespace App\Repositories\Api;

use App\Repositories\BaseRepository;
use App\Models\RadiostationContests;

/**
 * Class DummyClass.
 */
class radiostation_contestsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return RadiostationContests::class;
    }
}

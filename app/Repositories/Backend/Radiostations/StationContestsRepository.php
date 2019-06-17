<?php

namespace App\Repositories\Backend\Radiostations;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
//use Your Model
Use App\Models\RadiostationContests;

/**
 * Class Stations.
 */
class StationContestsRepository extends BaseRepository
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

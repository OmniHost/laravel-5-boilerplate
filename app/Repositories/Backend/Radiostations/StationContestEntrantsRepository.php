<?php

namespace App\Repositories\Backend\Radiostations;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
//use Your Model
Use App\Models\RadiostationEntrants;

/**
 * Class Stations.
 */
class StationContestEntrantsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return RadiostationEntrants::class;
    }
}

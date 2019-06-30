<?php

namespace App\Http\Controllers\Backend\Radiostation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Repositories\Backend\Radiostations\StationContestEntrantsRepository;

class StationEntrantsController extends Controller
{


	/**
     * @var StationContestEntrantsRepository
     */
	protected $stationEntrantsRepository;

	   /**
     * UserController constructor.
     *
     * @param StationContestEntrantsRepository $stationEntrantsRepository
     */
    public function __construct(StationContestEntrantsRepository $stationEntrantsRepository)
    {
		$this->stationEntrantsRepository = $stationEntrantsRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $station, int $contest)
    {
		//
		return $this->_view('index')
		->withStationId($station)
		->withContestId($contest)
		->withEntrants($this->stationEntrantsRepository->where('radiostation_contests_id', $contest)->where('completed',1)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stationId,$contestId, $entrantId){
		$this->stationEntrantsRepository->deleteById($entrantId);
		return redirect()->route('admin.entrants.index',[$stationId,$contestId])->withFlashSuccess('Contest Entrant Deleted');
	}

	/*public function destroy($stationId, $contestId)
    {
		//

		$this->stationContestsRepository->deleteById($contestId);

        return redirect()->route('admin.contests.index',$stationId)->withFlashSuccess('Contest Deleted');
	}*/

	protected function _view($tpl){
		return view('backend.radiostations.entrants.' . $tpl);
	}

}

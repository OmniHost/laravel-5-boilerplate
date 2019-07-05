<?php

namespace App\Http\Controllers\Backend\Radiostation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RadiostationContests;
use App\Models\RadiostationEntrants;
use App\Repositories\Backend\Radiostations\StationContestEntrantsRepository;


use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

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
    public function index(int $station, RadiostationContests $contest, Request $request)
    {


		$contest->hasAccess();

		

		$entrants = $this->stationEntrantsRepository->where('radiostation_contests_id', $contest->id)->where('completed',1);

		//$sort:
		$sorts = [
			'first_name',
			'last_name',
			'mobile',
			'email',
			'address1',
			'address2',
			'created_at'
		];

		$sort = in_array($request->input('sort'), $sorts) ? $request->input('sort') : 'created_at';
		$dir = $request->input('order') == 'desc' ? 'asc' : 'desc';

		$entrants->orderBy($sort, $dir);

		$filters = $request->input('filter');


		if($filters){

			foreach($filters as $fld => $val){
				if(!empty($val)){
					$entrants->whereStartsWith($fld, $val );
				}
			}
		}


		$sortLink = function($column, $label) use ($request, $station, $contest, $sort, $dir, $filters) {

			$page = $request->input('page') ? (int)$request->input('page') : 1;

			$class = ['sort-by'];
			$order = 'desc';

			if($sort == $column){
				$class[] = $dir;
				$order = $dir;
			}

			$route = route('admin.entrants.index', ['station' => $station, 'contest' => $contest, 'filter' => $filters, 'sort' => $column, 'order'=> $order, 'page' => $page]);


			return html()->a($route , $label)->class($class);
		};


		//
		return $this->_view('index')
		->withSuburbs(RadiostationEntrants::select('address1', \DB::raw('count(*) as total'))->where('completed',1)->where('radiostation_contests_id', $contest->id)->groupBy('address1')->orderBy('total','desc')->get())
		->withInitials(RadiostationEntrants::select( \DB::raw('concat_ws(" ", LEFT(first_name,1), LEFT(last_name,1)) as initials, count(*) as total'))->where('completed',1)->where('radiostation_contests_id', $contest->id)->groupBy(\DB::raw('concat_ws(" ", LEFT(first_name,1), LEFT(last_name,1))'))->orderBy('total','desc')->get())
		->withFormLink(route('admin.entrants.index', ['station' => $station, 'contest' => $contest]))
		->withSortLink($sortLink)
		->withStationId($station)
		->withContestId($contest)
		->withFilter($filters)
		->withEntrants($entrants->paginate());
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stationId,RadiostationContests $contestId, $entrantId){
		$contest->hasAccess();
		$this->stationEntrantsRepository->deleteById($entrantId);
		return redirect()->route('admin.entrants.index',[$stationId,$contestId])->withFlashSuccess('Contest Entrant Deleted');
	}

	protected function _view($tpl){
		return view('backend.radiostations.entrants.' . $tpl);
	}

	public function download($uuid) {
		$entrant = $this->stationEntrantsRepository->where('uuid', $uuid)->first();
		return response()->streamDownload(function() use ($entrant) { echo file_get_contents($entrant->recording_url); }, $entrant->first_name .'_' . $entrant->uuid . '.mp3');
	}

}

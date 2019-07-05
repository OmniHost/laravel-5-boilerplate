<?php

namespace App\Http\Controllers\Backend\Radiostation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Radiostations\StationsRepository;
use App\Models\Radiostation;
use Spatie\Permission\Exceptions\UnauthorizedException;

class StationsController extends Controller
{

    /**
     * @var StationsRepository
     */
	protected $stationsRepository;

	   /**
     * UserController constructor.
     *
     * @param StationsRepository $stationsRepository
     */
    public function __construct(StationsRepository $stationsRepository)
    {
        $this->stationsRepository = $stationsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//
		if(!auth()->user()->isAdmin()){
			throw new UnauthorizedException(400, 'Not Authorized to view this page');
		}
		return $this->_view('index')->withStations($this->stationsRepository->paginate());
	}


	public function profile(){

		$user = auth()->user();
		$stations = $user->stations();

		$stationId = $stations->first()->radiostation_id;

		$station = $this->stationsRepository->getById($stationId);


		if(empty($stations)){
			throw new UnauthorizedException(400, 'Not Authorized to view this page');
		}
		return $this->_view('edit')
		->withRadioStation($station);

	}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//
		$timezones = \DateTimeZone::listIdentifiers();

		return $this->_view('create')->withTimezones($timezones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->stationsRepository->create($request->only(
			'name',
			'timezone'
        ));

        return redirect()->route('admin.stations.index')->withFlashSuccess('Station Created');
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
    public function edit($id, Radiostation $radiostation)
    {
		//print_r($radiostation->find($id)->name);exit;
		//
		$timezones = \DateTimeZone::listIdentifiers();
		return $this->_view('edit')
		->withRadioStation($radiostation->find($id))
		->withTimezones($timezones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $station_id)
    {
		//

		$data = $request->only(
			'name',
			'timezone'
		);
		$this->stationsRepository->updateById($station_id, $data);

		return redirect()->route(auth()->user()->isAdmin() ? 'admin.stations.index' : 'admin.dashboard')->withFlashSuccess('Station Updated');

	}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
	}

	protected function _view($tpl){
		return view('backend.radiostations.stations.' . $tpl);
	}
}

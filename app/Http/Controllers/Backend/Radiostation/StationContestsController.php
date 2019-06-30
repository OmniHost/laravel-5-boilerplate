<?php

namespace App\Http\Controllers\Backend\Radiostation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Radiostations\StationContestsRepository;
use App\Repositories\Backend\Radiostations\StationsRepository;
use App\Models\RadiostationContests;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\File;

class StationContestsController extends Controller
{

	  /**
     * @var StationContestsRepository
     */
	protected $stationContestsRepository;

	 /**
     * @var StationsRepository
     */
	protected $stationsRepository;

   /**
     * UserController constructor.
     *
     * @param StationContestsRepository $stationContestsRepository
     */
    public function __construct(StationContestsRepository $stationContestsRepository, StationsRepository $stationsRepository)
    {
		$this->stationContestsRepository = $stationContestsRepository;
		$this->stationsRepository = $stationsRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $station)
    {
		//
		return $this->_view('index')
		->withStationId($station)
		->withContests($this->stationContestsRepository->where('radiostation_id', $station)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $station)
    {
		//
		return $this->_view('create')
		->withStationId($station);
    }


	    /**
     * Store a newly created resource in storage.
     *
	 * @param int $station
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $station, Request $request)
    {
		$data = $request->only(	'name',
		'enabled',
		'unique_entrants',
		'message',
		'upload_id',
		'start',
		'image1','image2','image3','image4',
		'end');
		$data['radiostation_id'] = $station;

		$this->stationContestsRepository->create($data);

        return redirect()->route('admin.contests.index',$station)->withFlashSuccess('Contest Created');
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
    public function edit(int $stationId, int $contestId, RadiostationContests $radiostationContests )
    {
		//

		return $this->_view('edit')
			->withContest($radiostationContests->find($contestId))
			->withStationId($stationId);
    }



	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stationId, $contestId)
    {


		$data = $request->only(	'name',
		'enabled',
		'unique_entrants',
		'message',
		'start',
		'image1','image2','image3','image4',
		'upload_id',
		'end');

		$this->stationContestsRepository->updateById($contestId, $data);

		return redirect()->route('admin.contests.index',$stationId)->withFlashSuccess('Contest Updated');

	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stationId, $contestId)
    {
		//

		$this->stationContestsRepository->deleteById($contestId);

        return redirect()->route('admin.contests.index',$stationId)->withFlashSuccess('Contest Deleted');
	}

	protected function _view($tpl){
		return view('backend.radiostations.contests.' . $tpl);
	}



	public function uploadImage(FileReceiver $receiver){
		// check if the upload is success, throw exception or return response you need
		if ($receiver->isUploaded() === false) {
			throw new UploadMissingFileException();
		}
		// receive the file
		$save = $receiver->receive();
		// check if the upload has finished (in chunk mode it will send smaller files)
		if ($save->isFinished()) {
			// save the file and return any response you need
			return $this->saveFile($save->getFile(), 'contestimage');
		}
		// we are in chunk mode, lets send the current progress
		/** @var AbstractHandler $handler */
		$handler = $save->handler();
		return response()->json([
			"done" => $handler->getPercentageDone()
		]);
	}


	public function upload(FileReceiver $receiver)
	{

		// check if the upload is success, throw exception or return response you need
		if ($receiver->isUploaded() === false) {
			throw new UploadMissingFileException();
		}
		// receive the file
		$save = $receiver->receive();
		// check if the upload has finished (in chunk mode it will send smaller files)
		if ($save->isFinished()) {
			// save the file and return any response you need
			return $this->saveFile($save->getFile(), 'callscripts', '.mp3');
		}
		// we are in chunk mode, lets send the current progress
		/** @var AbstractHandler $handler */
		$handler = $save->handler();
		return response()->json([
			"done" => $handler->getPercentageDone()
		]);

	}

protected function saveFile($uploadedFile, $folder= "", $ext = NULL){



	  //$filename = new File()
	  $original = $uploadedFile->getClientOriginalName();
	  $filename = sha1(time()) . $ext;

     $filename = Storage::disk('public')->putFileAs(
        $folder,
		$uploadedFile,
		$filename
      );

      $upload = new Upload;
	  $upload->filename = $filename;
	  $upload->original = $original;

      $upload->user()->associate(auth()->user());

      $upload->save();

      return response()->json([
        'id' => $upload->id
      ]);
}

}

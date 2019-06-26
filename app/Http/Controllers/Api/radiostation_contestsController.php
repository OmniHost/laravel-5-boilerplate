<?php namespace App\Http\Controllers\Api;

use Phpsa\LaravelApiController\Http\Api\Controller;
use App\Models\RadiostationContests;
use App\Repositories\Api\radiostation_contestsRepository;
use Twilio;
use Twilio\TwiML;

class radiostation_contestsController extends Controller
{
    /**
     * Eloquent model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function model()
    {
        return new RadiostationContests;
    }

    /**
     * Repository for the current model.
     *
     * @return App\Repositories\BaseRepository
     */
    protected function repository()
    {
        return new radiostation_contestsRepository;
	}

	public function index(){
		return $this->errorForbidden();
	}


	public function show($id){
		try {
			$item = $this->repository->getById($id);
		}catch(\Exception $e){
			$item = false;
		}
		$now = \Carbon\Carbon::now();
		$response = new TwiML;

		if(!$item || !$item->enabled || $item->start->greaterThan($now) || $item->end->lessThan($now)){
			$response->say('Hello. Sorry this contest is no longer available.',array('voice' => 'alice'));

		}else{
			$response->say('Hello. Please record your message.',array('voice' => 'alice'));
			$response->record();
		}

		$response->hangup();

		return response()->xml((string)$response);


	}

}
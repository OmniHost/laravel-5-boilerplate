<?php namespace App\Http\Controllers\Api;

use Phpsa\LaravelApiController\Http\Api\Controller;
use App\Models\RadiostationContests;
use App\Repositories\Api\radiostation_contestsRepository;
use App\Models\RadiostationEntrants;
use Twilio;
use Twilio\Twiml as TwiML;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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


	public function incommingCall($id, Request $request){
		Log::info(print_r($_POST,1));
		try {
			$item = $this->repository->getById($id);
		}catch(\Exception $e){
			$item = false;
		}
		$now = \Carbon\Carbon::now();
		$response = new TwiML;

		if(!$item || !$item->enabled || $item->start->greaterThan($now) || $item->end->lessThan($now)){
			$response->say('Hello. Sorry this contest is no longer available.',array('voice' => 'man'));
			$response->hangup();

			return response()->xml((string)$response);

		}

		if($item->unique_entrants == '1'){
			//Check if entrant entered before
			$result = RadiostationEntrants::where('mobile',$request->input('Caller'))->first();
			if($result){
				$response->say('Hello. You have already entered this contest.',array('voice' => 'man'));
				$response->hangup();
				return response()->xml((string)$response);
			}
		}

		$entrant = new RadiostationEntrants();
		$entrant->recording = $request->input('CallSid');
		$entrant->mobile = $request->input('Caller');
		$entrant->radiostation_contests_id = $id;
		try {
			$entrant->save();
		}catch(\Exception $e){
			$response->say('Hello. There was an issue with this call, please try again later.',array('voice' => 'man'));
			$response->hangup();
			return response()->xml((string)$response);
		}


		$response->say('Hello. Please record your message.',array('voice' => 'man','language' => 'en-gb'));
		$response->record();
		$response->hangup();

		return response()->xml((string)$response);


	}

	public function statusCall(Request $request){
		Log::info(print_r($request->all(),1));
	}

}
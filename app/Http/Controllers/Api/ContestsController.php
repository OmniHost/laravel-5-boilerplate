<?php namespace App\Http\Controllers\Api;

use Phpsa\LaravelApiController\Http\Api\Controller;
use App\Models\RadiostationContests;
use App\Repositories\Api\radiostation_contestsRepository;
use App\Models\RadiostationEntrants;
use Twilio;
use Twilio\Twiml as TwiML;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use Illuminate\Notifications\Notification;
use App\Notifications\ContestEntered;
use App\Notifications\ContestProfileCompleted;

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class ContestsController extends Controller
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

		$entry = RadiostationEntrants::find(5);
	//	$r = $entry->notify(new ContestProfileCompleted($entry));

		return (new ContestProfileCompleted($entry))
		->toMail($entry);

		return $this->errorForbidden();
	}


	public function incommingCall($id, Request $request){

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

		//Silly system sends straight back here with the recording url:
		$recording = $request->input('CallSid');
		if($recording){

			$entry = RadiostationEntrants::where('recording',$recording)->first();
			if($entry){
				$entry->recording_url = $request->input('RecordingUrl') . '.mp3';
				$entry->save();

				//Now we need to notify!
				$entry->notify(new ContestEntered($entry));
				return response()->xml((string)$entry->uuid);
			}
		}

		if($item->unique_entrants == '1'){
			//Check if entrant entered before
			$result = RadiostationEntrants::where('mobile',$request->input('Caller'))->where('completed','1')->first();
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
			Log::error($e->getMessage());
			$response->say('Hello. There was an issue with this call, please try again later.',array('voice' => 'man'));
			$response->hangup();
			return response()->xml((string)$response);
		}


		$response->say($item->message ,array('voice' => 'man','language' => 'en-gb'));
		$response->record();
		$response->hangup();

		return response()->xml((string)$response);


	}

	public function getEntrant($uuid, Request $request){


		try {
			$item = RadiostationEntrants::with(['station','contest'])->where('uuid' , $uuid)->first();
			if(!$item){
				throw new \Exception('Record not found');
			}
		}catch(\Exception $e){
			return $this->errorNotFound("Record not found:");
		}

		$res = $item->only('uuid','mobile','completed','first_name','last_name','email','address1','address2','message_image');
		$res['station'] = $item->station->only('name');
		$contest = $item->contest->only(['name', 'message']);
		$contest['images'] = [];
		foreach(['image1' => 'imageOne','image2'=> 'imageTwo','image3' => 'imageThree','image4' => 'imageFour'] as $img => $imgCall){
			if(!empty($item->contest->{$img})){
				$contest['images'][$item->contest->{$img}] = $item->contest->{$imgCall}->url();
			}
		}

		$contest['shareimages'] = [];
		foreach(['shareimage1' => 'shareImageOne','shareimage2'=> 'shareImageTwo','shareimage3' => 'shareImageThree','shareimage4' => 'shareImageFour'] as $img => $imgCall){
			if(!empty($item->contest->{$img})){
				$contest['shareimages'][$item->contest->{$img}] = $item->contest->{$imgCall}->url();
			}
		}


		$res['contest'] = $contest;

		$res['entrant_url'] = route('frontend.entrant.shareurl', $item->uuid);

        return $this->respondWithOne($res);
	}



	public function saveEntrantProfile($uuid, Request $request){
		try {
			$item = RadiostationEntrants::where('uuid' , $uuid)->first();
		}catch(\Exception $e){
			return $this->errorNotFound("Record not found:");
		}

		if( $request->input('notify') == 1){
			//Email notification Here
		}else{
			$item->fill($request->only(['first_name','last_name','email','address1','address2','opt_in','ipaddress','message_image','optin','completed']));
			$item->save();
		}


		return $this->getEntrant($uuid, $request);
		return $this->respondWithOne($item->only('uuid','station_name','mobile','completed','contest_name','first_name','last_name','email','address1','address2','optin'));

	}

	public function statusCall(Request $request){
	}

}
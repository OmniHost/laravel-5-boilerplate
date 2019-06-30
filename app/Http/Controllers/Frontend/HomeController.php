<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RadiostationEntrants;
use App\Notifications\ContestEntered;
use Illuminate\Notifications\Notification;
/**
 * Class HomeController.
 */
class HomeController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
	}

	public function entrant($uuid){
		try {
			$entrant = RadiostationEntrants::where('uuid', $uuid)->where('completed',1)->first();
		}catch(\Exception $e){
			abort(404);
		}

		return view('frontend.entrant')->withEntrant($entrant);
	}

	public function entry($stationSlug, $contestSlug, $uuid){
		return view('stations.jacaranda');
	}
}

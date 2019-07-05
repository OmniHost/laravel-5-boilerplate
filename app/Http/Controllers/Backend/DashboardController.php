<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Charts\RadioStationChart;
use App\Models\RadiostationEntrants;
use App\Models\RadiostationContests;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

		$user = auth()->user();
		$station = $user->stations()->first();
		$chart = null;
		$stats =[];
		$today = 0;


		if($station){
		$stationId = $station->radiostation_id;

		$contests = RadiostationContests::where('enabled', 1)
		->where('radiostation_id', $stationId)->get()
		->where('start', '<=', Date("Y-m-d 23:59:59"))
		->where('end', '>=', Date("Y-m-d 00:00:00"));





		if($contests){
			$chart = new RadioStationChart;
			$labels = collect([]);
			for ($days_backwards = 21; $days_backwards >= 0; $days_backwards--) {
				$labels->push(today()->subDays($days_backwards)->format("d M"));
			}
			$chart->labels($labels)->height('300');
			foreach($contests as $contest){


				//Graph
				$data = collect([]);
				$label = $contest->name;
				for ($days_backwards = 21; $days_backwards >= 0; $days_backwards--) {
					$data->push(RadiostationEntrants::where('completed',1)->where('radiostation_contests_id', $contest->id)->whereDate('created_at', today()->subDays($days_backwards))->count());
				}
				$chart->dataset($label, 'line', $data);

				//lets build top entries for this contest
				$today += RadiostationEntrants::where('completed',1)->where('radiostation_contests_id', $contest->id)->whereDate('created_at', today())->count();
				$stat['TopInitials'] = RadiostationEntrants::select( \DB::raw('concat_ws(" ", LEFT(first_name,1), LEFT(last_name,1)) as initials, count(*) as total'))->where('completed',1)->where('radiostation_contests_id', $contest->id)->groupBy(\DB::raw('concat_ws(" ", LEFT(first_name,1), LEFT(last_name,1))'))->orderBy('total','desc')->limit(10)->get();
				$stat['TopSuburbs'] = RadiostationEntrants::select('address1', \DB::raw('count(*) as total'))->where('completed',1)->where('radiostation_contests_id', $contest->id)->groupBy('address1')->orderBy('total','desc')->limit(10)->get();
				$stats[$label] = $stat;
			}



		//	$stats[] = $contest

		}


	}

        return view('backend.dashboard')->withChart($chart)->withStats($stats)->withToday((int) $today);
    }
}

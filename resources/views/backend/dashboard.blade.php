@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
			</div>
			<!--card-header-->
		</div>
	</div>

	@if($chart)

	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<strong>Entrants - Last 3 Weeks ({{ $today }} Today)</strong>
			</div>
			<!--card-header-->
			<div class="card-body" style="max-height: 300px;">
				{!! $chart->container() !!}
			</div>
		</div>
	</div>

	@endif

</div>
@if($stats)
@foreach($stats as $contest => $stat)
<div class="row">


	<div class="col-6">
		<div class="card">
			<div class="card-header">
				<strong>Top 10 Suburbs - {{ $contest }}</strong>
			</div>
			<!--card-header-->
			<div class="card-body">
				<table class="table table-responsive-sm">
					<thead>
						<tr>
							<th>Suburb</th>
							<th class="text-right">No. Entrants</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stat['TopSuburbs'] as $entrant)
						<tr>
							<td>{{ $entrant->address1 }}</td>
							<td class="text-right">{{ $entrant->total }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-6">
		<div class="card">
			<div class="card-header">
				<strong>Top 10 Initials - {{ $contest }}</strong>
			</div>
			<!--card-header-->
			<div class="card-body">
				<table class="table table-responsive-sm">
					<thead>
						<tr>
							<th>Initials</th>
							<th class="text-right">No. Entrants</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stat['TopInitials'] as $entrant)
						<tr>
							<td>{{ $entrant->initials }}</td>
							<td class="text-right">{{ $entrant->total }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endforeach
@endif

@endsection




@push('after-scripts')
@if($chart)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

{!! $chart->script() !!}

@endif
@endPush
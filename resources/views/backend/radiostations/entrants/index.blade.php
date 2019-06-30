@extends('backend.layouts.app')

@section('title', app_name() . ' | Radio Stations' )

@section('breadcrumb-links')
    @include('backend.radiostations.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Entrants
                </h4>
            </div><!--col-->


        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
							<th></th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Suburb</th>
							<th>City</th>
							<th>Created</th>

                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($entrants as $entrant)
                            <tr>
								<td><audio preload="auto" src="{{ $entrant->recording_url }}"></audio></td>
								<td>{{ $entrant->first_name }}</td>
								<td>{{ $entrant->last_name }}</td>
								<td>{{ $entrant->mobile }}</td>
								<td>{{ $entrant->email }}</td>
								<td>{{ $entrant->address1 }}</td>
								<td>{{ $entrant->address2 }}</td>

                                <td>{{ $entrant->created_at->diffForHumans() }}</td>
                                <td>{!! $entrant->action_buttons !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $entrants->total() !!} {{ trans_choice(' Total Entrants', $entrants->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $entrants->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

@push('after-scripts')


	   <script>
$('audio').initAudioPlayer();
</script>
@endPush
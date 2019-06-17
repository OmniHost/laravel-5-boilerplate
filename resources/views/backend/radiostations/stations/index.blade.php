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
                    Radio Stations
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
				<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
					<a href="{{ route('admin.stations.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
				</div><!--btn-toolbar-->
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
							<th>Station Name</th>
							<th>Created</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stations as $station)
                            <tr>
                                <td>{{ $station->name }}</td>

                                <td>{{ $station->created_at->diffForHumans() }}</td>
                                <td>{!! $station->action_buttons !!}</td>
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
                    {!! $stations->total() !!} {{ trans_choice(' Total Radio Stations', $stations->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $stations->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

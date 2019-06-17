@extends('backend.layouts.app')

@section('title', app_name() . ' | Radio Station Contests' )

@section('breadcrumb-links')
    @include('backend.radiostations.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Contests
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
				<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
					<a href="{{ route('admin.contests.create', $stationId) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
				</div><!--btn-toolbar-->
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
							<th>Contest Name</th>
							<th>Entry-ID</th>
							<th>Created</th>
							<th>Updated</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contests as $contest)
                            <tr>
                                <td>{{ $contest->name }}</td>
								<td>{{ $contest->slug }}</td>
								<td>{{ $contest->created_at->diffForHumans() }}</td>
								<td>{{ $contest->updated_at->diffForHumans() }}</td>
                                <td>{!! $contest->action_buttons !!}</td>
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
                    {!! $contests->total() !!} {{ trans_choice(' Total Radio Contests', $contests->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $contests->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

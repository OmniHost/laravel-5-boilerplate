@extends('backend.layouts.app')

@section('title', app_name() . ' | Radio Stations' )


@section('content')
{{ html()->modelForm($contest, 'PATCH', route('admin.contests.update', ['contest' => $contest->id,'station' => $stationId]))->class('form-horizontal')->open() }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                       Radio Contests
                        <small class="text-muted">Edit Contest</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Contest Name')
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.roles.name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
					</div><!--form-group-->

					<div class="form-group row">
                        {{ html()->label('Contest Call Recording')
                            ->class('col-md-2 form-control-label')
                            ->for('message') }}

                        <div class="col-md-10">
                            {{ html()->textarea('message')
                                ->class('form-control')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

					<div class="form-group row">
						{{ html()->label('Enabled')->class('col-md-2 form-control-label')->for('enabled') }}
						<label class="switch switch-label switch-pill switch-primary">
							{{ html()->checkbox('enabled', true, '1')->class('switch-input') }}
							<span class="switch-slider" data-checked="yes" data-unchecked="no"></span>
						</label>

					</div><!--form-group-->

					<div class="form-group row">
						{{ html()->label('Enforce Unique Entants')->class('col-md-2 form-control-label')->for('unique_entrants') }}
						<label class="switch switch-label switch-pill switch-primary">
							{{ html()->checkbox('unique_entrants', false, '1')->class('switch-input') }}
							<span class="switch-slider" data-checked="yes" data-unchecked="no"></span>
						</label>

					</div><!--form-group-->

					<div class="form-group row">
                        {{ html()->label('Contest Opens')
                            ->class('col-md-2 form-control-label')
                            ->for('start') }}

                        <div class="col-md-10">
                            {{ html()->text('start')
                                ->class('form-control datepicker')
                                ->placeholder(__('Start Date'))
                                ->attribute('datepicker', 'true')
                                ->autofocus() }}
                        </div><!--col-->
					</div><!--form-group-->

					<div class="form-group row">
                        {{ html()->label('Contest Closes')
                            ->class('col-md-2 form-control-label')
                            ->for('end') }}

                        <div class="col-md-10">
                            {{ html()->text('end')
                                ->class('form-control datepicker')
                                ->placeholder(__('Start Date'))
                                ->attribute('datepicker', 'true')
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->



                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.stations.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
	{{ html()->closeModelForm() }}
@endsection

@stack('after-scripts')
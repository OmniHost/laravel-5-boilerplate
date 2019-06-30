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
                        {{ html()->label('Contest Tag Line')
                            ->class('col-md-2 form-control-label')
                            ->for('message') }}

                        <div class="col-md-10">
                            {{ html()->textarea('message')
                                ->class('form-control')
                                ->required() }}
                        </div><!--col-->
					</div><!--form-group-->

					<div class="form-group row ">
						{{ html()->label('Call File')->class('col-md-2 form-control-label')->for('dropzonefile') }}

                        <div class="col-md-10">
							<input type="hidden" name="upload_id" id="upload_id" value="{{ $contest ? $contest->upload_id : null }}"/>
							<input type="text" class="form-control" id="upload_id_filename" disabled value="{{ $contest && $contest->upload ? $contest->upload->original : null }}" />
							<div id="file" class="dropzone"></div>
                        </div>
                      </div>

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
                    {{ form_cancel(route('admin.contests.index',['station' => $contest->radiostation_id]), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
	{{ html()->closeModelForm() }}
@endsection

@push('after-scripts')


	   <script>
    var drop = new Dropzone('#file', {
		chunk: true,
      createImageThumbnails: false,
      addRemoveLinks: true,
      url: "{{ route('admin.contests.upload') }}",
      headers: {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
	  },
	  maxFiles: 1,
	  acceptedFiles: '.mp3',
	  dictDefaultMessage : 'Click here to upload or Drop file here (mp3 only)'
	});


	drop.on('complete', function(file) {
		if(file.status === 'error'){
			drop.removeFile(file);
			alert("Failed to upload error");
			return;
		}
		var obj = JSON.parse(file.xhr.response);
		$('#upload_id_filename').val(file.name);
		$('#upload_id').val(obj.id);
		drop.removeFile(file);
	});
	</script>

@endPush
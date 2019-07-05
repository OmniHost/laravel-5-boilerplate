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

						<div class="col-md-3 dropzoneimagecontainer">
							<input data-for="id" type="hidden" name="upload_id" id="upload_id" value="{{ $contest ? $contest->upload_id : null }}"/>
							<input data-for="name" type="text" class="form-control" id="upload_id_filename" disabled value="{{ $contest && $contest->upload ? $contest->upload->original : null }}" />
							<div id="file" class="dropzone"></div>
						</div>
					</div>

					<div class="form-group row ">

						<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
								{{ html()->label('Share Image 1')->class('form-control-label')->for('dropzoneimage1') }}
							<input data-for="id" type="hidden" name="image1" id="image1_id" value="{{ $contest ? $contest->image1 : null }}"/>
							<input data-for="name" type="text" class="form-control" id="image1_filename" disabled value="{{ $contest && $contest->image1 ? $contest->imageOne->original : null }}" />
							<div id="image1" class="dropzone"></div>
						</div>


						<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
								{{ html()->label('Share Image 1')->class('form-control-label')->for('dropzoneimage2') }}
							<input data-for="id" type="hidden" name="image2" id="image2_id" value="{{ $contest ? $contest->image2 : null }}"/>
							<input data-for="name" type="text" class="form-control" id="image2_filename" disabled value="{{ $contest && $contest->image2 ? $contest->imageTwo->original : null }}" />
							<div id="image2" class="dropzone"></div>
						</div>


						<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
								{{ html()->label('Share Image 1')->class('form-control-label')->for('dropzoneimage3') }}
							<input data-for="id" type="hidden" name="image3" id="image3_id" value="{{ $contest ? $contest->image3 : null }}"/>
							<input data-for="name" type="text" class="form-control" id="image3_filename" disabled value="{{ $contest && $contest->image3 ? $contest->imageThree->original : null }}" />
							<div id="image3" class="dropzone"></div>
						</div>


						<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
								{{ html()->label('Share Image 1')->class('form-control-label')->for('dropzoneimage4') }}
							<input data-for="id" type="hidden" name="image4" id="image4_id" value="{{ $contest ? $contest->image4 : null }}"/>
							<input data-for="name" type="text" class="form-control" id="image4_filename" disabled value="{{ $contest && $contest->image4 ? $contest->imageFour->original : null }}" />
							<div id="image4" class="dropzone"></div>
						</div>
					</div>

					<div class="form-group row ">

							<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
									{{ html()->label('Blast Image 1')->class('form-control-label')->for('dropzoneimage5') }}
								<input data-for="id" type="hidden" name="shareimage1" id="shareimage1_id" value="{{ $contest ? $contest->shareimage1 : null }}"/>
								<input data-for="name" type="text" class="form-control" id="shareimage1_filename" disabled value="{{ $contest && $contest->shareimage1 ? $contest->shareImageOne->original : null }}" />
								<div id="shareimage1" class="dropzone"></div>
							</div>


							<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
									{{ html()->label('Blast Image 1')->class('form-control-label')->for('dropzoneimage6') }}
								<input data-for="id" type="hidden" name="shareimage2" id="shareimage2_id" value="{{ $contest ? $contest->shareimage2 : null }}"/>
								<input data-for="name" type="text" class="form-control" id="shareimage2_filename" disabled value="{{ $contest && $contest->shareimage2 ? $contest->shareImageTwo->original : null }}" />
								<div id="shareimage2" class="dropzone"></div>
							</div>


							<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
									{{ html()->label('Blast Image 1')->class('form-control-label')->for('dropzoneimage7') }}
								<input data-for="id" type="hidden" name="shareimage3" id="shareimage3_id" value="{{ $contest ? $contest->shareimage3 : null }}"/>
								<input data-for="name" type="text" class="form-control" id="shareimage3_filename" disabled value="{{ $contest && $contest->shareimage3 ? $contest->shareImageThree->original : null }}" />
								<div id="shareimage3" class="dropzone"></div>
							</div>


							<div class="col-md-3 col-sm-6 col-xs-12 dropzoneimagecontainer">
									{{ html()->label('Blast Image 1')->class('form-control-label')->for('dropzoneimage8') }}
								<input data-for="id" type="hidden" name="shareimage4" id="shareimage4_id" value="{{ $contest ? $contest->shareimage4 : null }}"/>
								<input data-for="name" type="text" class="form-control" id="shareimage4_filename" disabled value="{{ $contest && $contest->shareimage4 ? $contest->shareImageFour->original : null }}" />
								<div id="shareimage4" class="dropzone"></div>
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
		var dropDefaults =  {
			chunk: true,
			  createImageThumbnails: false,
			  addRemoveLinks: true,
			  url: "{{ route('admin.contests.upload.mp3') }}",
			  headers: {
				'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
			  },
			  maxFiles: 1,
			  acceptedFiles: '.mp3',
			  dictDefaultMessage : 'Click here to upload or Drop file here (mp3 only)'
		}

		var imageDropVar = JSON.parse(JSON.stringify(dropDefaults));
		imageDropVar.acceptedFiles = '.jpg,.png,.jpeg'
		imageDropVar.url = "{{ route('admin.contests.upload.image') }}";
		imageDropVar.createImageThumbnails = true;
		imageDropVar.dictDefaultMessage = 'Click here to upload or Drop image';


		var onImageDone = function(file) {

		if(file.status === 'error'){
			drop.removeFile(file);
			alert("Failed to upload error");
			return;
		}
		const el = $(this)[0].element.closest('.dropzoneimagecontainer');
		console.log(el);

		var obj = JSON.parse(file.xhr.response);
		$(el).find('[data-for="name"]').val(file.name);
		$(el).find('[data-for="id"]').val(obj.id);
		//drop.removeFile(file);
		}

		var imageDrop = new Dropzone('#image1', imageDropVar).on('complete', onImageDone);
		var imageDrop2 = new Dropzone('#image2', imageDropVar).on('complete', onImageDone);
		var imageDrop3 = new Dropzone('#image3', imageDropVar).on('complete', onImageDone);
		var imageDrop4 = new Dropzone('#image4', imageDropVar).on('complete', onImageDone);

		var shareimageDrop = new Dropzone('#shareimage1', imageDropVar).on('complete', onImageDone);
		var shareimageDrop2 = new Dropzone('#shareimage2', imageDropVar).on('complete', onImageDone);
		var shareimageDrop3 = new Dropzone('#shareimage3', imageDropVar).on('complete', onImageDone);
		var shareimageDrop4 = new Dropzone('#shareimage4', imageDropVar).on('complete', onImageDone);


		var drop = new Dropzone('#file',dropDefaults).on('complete', function(file) {
			onImageDone(file);
			drop.removeFile(file);
		});


		$('.datepicker').datetimepicker({
			format: "YYYY-MM-DD hh:mm a"
		});

	</script>

@endPush
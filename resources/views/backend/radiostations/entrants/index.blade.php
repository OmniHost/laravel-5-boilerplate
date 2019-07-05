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

			<div class="col-sm-7">
			<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
					<button data-toggle="modal" data-target="#groupNotifyModal" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-paper-plane"></i> Send Notification</button>
				</div><!--btn-toolbar-->
			</div>

        </div><!--row-->


        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
							<th>Recording</th>
							<th>
								{{  $sortLink('first_name', 'First Name') }}
							</th>
							<th>{{  $sortLink('last_name', 'Last Name') }}</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>{{  $sortLink('address1', 'Suburb') }}</th>
							<th>{{  $sortLink('address2', 'City') }}</th>
							<th>{{  $sortLink('created_at', 'Created') }}</th>

                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
							<tr>
								<form action="{{ $formLink }}" method="get">
								<th></th>
								<th>
									<input class="form-control" name="filter[first_name]" value="{{ isset($filter['first_name']) ?  $filter['first_name'] : '' }}" />
								</th>
								<th><input class="form-control" name="filter[last_name]" value="{{ isset($filter['last_name']) ?  $filter['last_name'] : '' }}" /></th>
								<th><input class="form-control" name="filter[mobile]" value="{{ isset($filter['mobile']) ?  $filter['mobile'] : '' }}" /></th>
								<th><input class="form-control" name="filter[email]" value="{{ isset($filter['email']) ?  $filter['email'] : '' }}" /></th>
								<th><input class="form-control" name="filter[address1]" value="{{ isset($filter['address1']) ?  $filter['address1'] : '' }}" /></th>
								<th><input class="form-control" name="filter[address2]" value="{{ isset($filter['address2']) ?  $filter['address2'] : '' }}" /></th>
								<th></th>

								<th><button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button></th>
							</form>
							</tr>
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


<div class="modal fade" id="groupNotifyModal" tabindex="-1" role="dialog" aria-labelledby="groupNotifyModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLongTitle">Send Mail Blast</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			 <form id="MailBlastForm">
				 <div class="alert alert-info">Select one or both of the selction options below</div>
					<div class="form-group">
						<label for="recipient-suburb" class="col-form-label">Select Suburb:</label>
							<select name="suburb" type="text" class="form-control" id="recipient-suburb">
								<option value="">All</option>
								@foreach($suburbs as $suburb)
								<option value="{{ $suburb->address1 }}">{{ $suburb->address1 }} ({{ $suburb->total }} Entrants)</option>

								@endforeach;
							</select>
						  </div>

						  <div class="form-group">
								<label for="recipient-initials" class="col-form-label">Select Initials:</label>
									<select name="initials" type="text" class="form-control" id="recipient-initials">
										<option value="">All</option>
										@foreach($initials as $initial)
										<option value="{{ $initial->initials }}">{{ $initial->initials }} ({{ $initial->total }} Entrants)</option>

										@endforeach;
									</select>
								  </div>

								  <div class="form-group">
										<label for="recipient-initials" class="col-form-label">Schedule for:</label>
											<input
											type="text"
											value=""
											id="schedule-sendtime"
											class="form-control datetimepicker_custom"
											name="sendtime" />
										  </div>



			 </form>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  <button type="button" class="btn btn-primary" id="sendmailblast">Send Blast</button>
			</div>
		  </div>
		</div>
	  </div>

@endsection

@push('after-scripts')


	   <script>
$('audio').initAudioPlayer();
$('.datetimepicker_custom').datetimepicker({
	format: "YYYY-MM-DD hh:mm a"
});

$('#sendmailblast').on("click", function() {
	$('#MailBlastForm').find('.alert-danger').remove();
	$('#MailBlastForm').find('.alert-success').remove();
	var $this = $(this);
	$this.attr('disabled', 'disabled');
	var url = '{{ route('admin.entrants.mailblast', [$contestId]) }}';
	var suburb = $('#recipient-suburb').val();
	var initials = $('#recipient-initials').val();
	if(suburb === '' && initials === ''){
		$('#MailBlastForm').prepend('<div class="alert alert-danger">Select either suburb or initials or both</div>');
		$this.attr('disabled', false);
		return false;
	}
	axios.post(url, $('#MailBlastForm').serialize()).then(function(res) {
		$('#MailBlastForm').prepend('<div class="alert alert-success">Your email blast has been scheduled</div>');
		$this.attr('disabled', false);
		$('#MailBlastForm').trigger('reset')
	}).catch(function (error) {
		console.log(error);
		$('#MailBlastForm').prepend('<div class="alert alert-danger">An error has occured, please try again</div>');
	$this.attr('disabled', false);
  });
});

</script>
@endPush
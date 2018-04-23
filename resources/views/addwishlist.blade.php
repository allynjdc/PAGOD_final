@extends('layouts.app')

@push('header_scripts')
<script src=" {{ asset('js/schedule_script.js') }} "></script>
@endpush

@section('content')
 	@include('modal')
	<!-- MIDDLE CONTENT -->
	<div class="container index_container">
		<!-- ROW -->
		<div class="row">
			<!-- Column md 4 -->
			<div class="col-md-4 right_side">
				<!-- CONSTRAINTS PANEL -->
				<div class="panel panel-default panel-shadow">
					<div class="panel-body">
						<div class="btn-group">
							<div class="btn-group-justified">
								<a class="btn but_color" data-toggle="modal" href="#addconstraint"><span class="glyphicon glyphicon-plus"></span> ADD CONSTRAINT</a>
							</div>
							<!-- PRIORITIES -->
							<div class="panel-group priorities" id="accordion">
								<!-- High Priority -->
  								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<!-- <a data-toggle="collapse" data-parent="#accordion" href="#high">High Priority</a> -->
        									<a data-toggle="collapse" href="#high">High Priority<span class="badge pull-right" id="high_badge">0</span></a>
     									</h4>
    								</div>
    								<div id="high" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												<b>No Constraints</b>
      											</p>
      										</div>
      									</div>
    								</div>
    							</div>
    							<!-- Medium Priority -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" href="#medium">Medium Priority<span class="badge pull-right" id="medium_badge">0</span></a>
     									</h4>
    								</div>
    								<div id="medium" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												<b>No Constraints</b>
      											</p>
      										</div>
      									</div>
      								</div>
								</div>
								<!-- Low Priority -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" href="#low">Low Priority<span class="badge pull-right" id="low_badge">0</span></a>
     									</h4>
    								</div>
    								<div id="low" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												<b>No Constraints</b>
      											</p>
      										</div>
      									</div>
    								</div>
								</div>
							</div>
  							<div class="btn-group-justified">
								<a id="generate_btn" class="btn but_color" href="javascript:void(0)"> GENERATE </a>
							</div>
  						</div>
					</div>
				</div>
				<!-- END CONSTRAINTS PANEL -->

			</div>
			<!-- End Column md 4 -->

			<!-- TIME TABLE PANEL -->
			<div class="col-md-8">
				<div class="panel panel-default panel-shadow">
					<div id="schedule-loading"></div>
				</div><!-- END PANEL -->
			</div><!-- END COL -->
				
		</div><!-- END ROW -->
			
	</div><!-- END MIDDLE CONTENT -->
	<script type="text/javascript">
		$("#schedule-loading").jqs({
			mode: "read",
			hour: 12
		});
	</script>
@endsection
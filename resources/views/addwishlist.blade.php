@extends('layouts.app')

@section('content')
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

	<!--- MODAL ADD CONSTRAINTS -->
	<div id="addconstraint" class="modal fade" role="dialog" >
		<div class="modal-dialog">
		  	<div class="modal-content ">
		  		<div class="modal-header">
		  			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  			<h4>NEW CONSTRAINT</h4>
		  		</div>
			    <div class="modal-body">
			    	<form action="" method="POST">
				    	<div class="priority_options">
				        	<p> 
				        		Priority: 
				        		<label class="radio-inline"><input type="radio" name="add_priority" value="high">High</label>
								<label class="radio-inline"><input type="radio" name="add_priority" value="medium">Medium</label>
								<label class="radio-inline"><input type="radio" name="add_priority" value="low">Low</label>
							</p>
				    	</div>
				    	<hr />
			    		<ul id="add_tabs" class="nav nav-tabs">
  							<li class="active" data-tab="addcourserestriction"><a data-toggle="tab" href="#addcourserestriction">Course Restriction</a></li>
  							<li data-tab="addmeetingtime"><a data-toggle="tab" href="#addmeetingtime">Meeting Time</a></li>
						</ul>

						<div class="tab-content">
  							<div id="addcourserestriction" class="tab-pane fade active in">
  								<div class="input-group bootstrap-timepicker timepicker btn_logged">
									<div class="input-group-btn">
										<button data-constraint="mustnothave" type="button" class="btn but_color dropdown-toggle add-constraint-btn" data-toggle="dropdown">Must Not Have <span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu">
											<li role="presentation">
												<a class="add-constraint-item constraint-item" href="javascript:void(0)">Must Have</a>
											</li>
											<li role="presentation">
												<a class="add-constraint-item constraint-item" href="javascript:void(0)">Must Not Have</a>
											</li>
										</ul>
									</div>
									<input name="course" type="text" class="form-control input-small">
						        </div>
  							</div>
  							<div id="addmeetingtime" class="tab-pane fade">
								<div class="input-group bootstrap-timepicker timepicker btn_logged">
									<span class="input-group-addon">Start Time: </span>
									<input id="add-start-time" type="text" class="form-control input-small timepicker3" />
						        </div>

						        <div class="input-group bootstrap-timepicker timepicker btn_logged">
									<span class="input-group-addon">End Time: </span>
									<input id="add-end-time" type="text" class="form-control input-small timepicker3" />
						        </div>
						        <div>
						        	<small><b>NOTE: </b>Inputting the SAME VALUES for START and END TIME will mean that there should be no class on chosen days.</small>
						        </div>
						        <div>
						        	<label class="checkbox-inline"><input type="checkbox" name="days" value="MON">MON</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="TUE">TUE</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="WED">WED</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="THUR">THUR</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="FRI">FRI</label>
						        </div>
  							</div>
						</div>
						<hr />
						<button id="add_constraint" type="submit" class="btn but_color btn_logged">Add</button>
			    		<button type="button" class="btn btn-default btn_logged" data-dismiss="modal">Close</button>
			    	</form>
			    </div>
		    </div>
	    </div>
	</div>
	<!-- END MODAL ADD CONSTRAINTS --> 

	<!--- MODAL REMOVE CONSTRAINTS -->
	<!-- <div id="remove" class="modal fade" role="dialog">
		<div class="modal-dialog">
		  	<div class="modal-content ">
			    <div class="modal-body confirm_panel">
			       <h4> Are you sure you want to remove this? </h4>
			    	<button type="button" class="btn btn-danger remove-constraint" data-dismiss="modal">Remove</button>
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    </div>
		    </div>
	    </div>
	</div> -->
	<!-- END MODAL REMOVE CONSTRAINTS -->

	<!-- MODAL EDIT CONSTRAINTS -->
	<div id="editconstraint" class="modal fade" role="dialog" >
		<div class="modal-dialog">
		  	<div class="modal-content ">
		  		<div class="modal-header">
		  			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  			<h4>EDIT CONSTRAINT</h4>
		  		</div>
			    <div class="modal-body">
			    	<form action="" method="POST">
				    	<div class="priority_options">
				        	<p> 
				        		Priority: 
				        		<label class="radio-inline"><input id="radio_high" type="radio" name="edit_priority" value="high" checked="checked">High</label>
								<label class="radio-inline"><input id="radio_medium" type="radio" name="edit_priority" value="medium">Medium</label>
								<label class="radio-inline"><input id="radio_low" type="radio" name="edit_priority" value="low">Low</label>
							</p>
				    	</div>
				    	<hr />
			    		<ul id="edit_tabs" class="nav nav-tabs">
  							<li class="active" data-tab="editcourserestriction"><a data-toggle="tab" href="#editcourserestriction">Course Restriction</a></li>
  							<li data-tab="editmeetingtime"><a data-toggle="tab" href="#editmeetingtime">Meeting Time</a></li>
  							<!-- <li><a data-toggle="tab" href="#scheduleflow">Schedule Flow</a></li> -->
						</ul>
						<div class="tab-content">
  							<div id="editcourserestriction" class="tab-pane fade in active">
  								<div class="input-group bootstrap-timepicker timepicker btn_logged">
									<div class="input-group-btn">
										<button data-constraint="mustnothave" type="button" class="btn btn-primary dropdown-toggle edit-constraint-btn" data-toggle="dropdown">Must Not Have <span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu">
											<li role="presentation">
												<a class="edit-constraint-item constraint-item" href="javascript:void(0)">Must Have</a>
											</li>
											<li role="presentation">
												<a class="edit-constraint-item constraint-item" href="javascript:void(0)">Must Not Have</a>
											</li>
										</ul>
									</div>
									<input name="edit_course" type="text" class="form-control input-small">
						        </div>
  							</div>
  							<div id="editmeetingtime" class="tab-pane fade">
								<div class="input-group bootstrap-timepicker timepicker btn_logged">
									<span class="input-group-addon">Start Time: </span>
									<input id="edit-start-time" type="text" class="form-control input-small timepicker3" />
						        </div>

						        <div class="input-group bootstrap-timepicker timepicker btn_logged">
									<span class="input-group-addon">End Time: </span>
									<input id="edit-end-time" type="text" class="form-control input-small timepicker3" />
						        </div>
						        <div>
						        	<small><b>NOTE: </b>Inputting the SAME VALUES for START and END TIME will mean that there should be no class on chosen days.</small>
						        </div>
						        <div>
	    							<label class="checkbox-inline"><input type="checkbox" name="days" value="MON">MON</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="TUE">TUE</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="WED">WED</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="THUR">THUR</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="FRI">FRI</label>
						        </div>
							</div><!-- 
							<div id="scheduleflow" class="tab-pane fade">
								<label class="radio-inline"><input type="radio" name="priority" value="block" checked="checked">Block Schedule</label>
								<label class="radio-inline"><input type="radio" name="priority" value="straight">Straight Schedule</label>
								<label class="radio-inline"><input type="radio" name="priority" value="sparse">Sparse Schedule</label>
							</div> -->
						</div>
						<hr />
						<button id="edit_constraint" type="submit" class="btn btn-primary btn_logged">EDIT</button>
			    		<button type="button" class="btn btn-default btn_logged" data-dismiss="modal">Close</button>
			    	</form>
			    </div>
		    </div>
	    </div>
	</div>
	<!-- END MODAL EDIT CONSTRAINTS -->

	<!-- SCHEDULE GENERATE ERROR MODAL -->
	<div id="generate-warning-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-warning">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4><span class="glyphicon glyphicon-warning-sign"></span> GENERATE SCHEDULE</h4>
				</div>
				<div class="modal-body">
					<p>You still haven't added any constraints. Are you sure you want to generate a schedule?</p>
				</div>
				<div class="modal-footer">
					<button id="generate_schedule" type="button" class="btn btn-warning" data-dismiss="modal">GENERATE</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- SCHEDULE GENERATE ERROR MODAL END -->
 
	<script type="text/javascript">
		$("#schedule-loading").jqs({
			mode: "read",
			hour: 12
		});
	</script>
@endsection
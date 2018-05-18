	<!--- MODAL ADD CONSTRAINTS -->
	<div id="addconstraint" class="modal fade" role="dialog" >
		<div class="modal-dialog"> 
		  	<div class="modal-content ">
		  		<div class="modal-header">
		  			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  			<h4>NEW CONSTRAINT</h4>
		  		</div>
			    <div class="modal-body">
			    	<form action="" method="GET">
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
  							<li data-tab="addprefinstructor"><a data-toggle="tab" href="#addprefinstructor">Preferred Instructor</a></li>
  							<li data-tab="addmaxdaily"><a data-toggle="tab" href="#addmaxdaily">Max Daily</a></li>
  							<li data-tab="addmaxstraight"><a data-toggle="tab" href="#addmaxstraight">Max Straight</a></li>
						</ul>
						<div class="tab-content">
  							<div id="addcourserestriction" class="tab-pane fade active in">
  								<div class="input-group bootstrap-timepicker timepicker btn_logged"><!--- input-group-btn but_color -->
									<div class="input-group-btn"> 
										<div class="dropdown">
											<button data-constraint="mustnothave" type="button" class="btn but_color dropdown-toggle add-constraint-btn" data-toggle="dropdown">Must Not Have <span class="caret"></span></button>
											<ul class="dropdown-menu" id="drop" role="menu">
												<li role="presentation" selected>
													<a class="add-constraint-item constraint-item" href="javascript:void(0)">Must Have</a>
												</li>
												<li role="presentation">
													<a class="add-constraint-item constraint-item" href="javascript:void(0)">Must Not Have</a>
												</li>
											</ul>	
										</div>										
									</div>
									<input name="course" type="text" class="form-control input-small">
						        </div>
  							</div>
  							<div id="addmeetingtime" class="tab-pane fade">
  								<div class="input-group btn_logged">
  									<div class="input-group-btn">
  										<button type="button" class="btn but_color">Constraint Type: </button>
  									</div>
  									<select class="form-control" id="add_meetingtime_type">
  										<option value="1">No Class On Day</option>
  										<option value="2">No Class On Time</option>
  										<option value="3">No Class On Day & Time</option>
  										<option value="4">Class Within Range For All Days</option>
  										<option value="5">Class Within Range For Specific Days</option>
  									</select>
  								</div>
								<div class="time_div" style="display: none">
									<div class="input-group bootstrap-timepicker timepicker btn_logged">
										<span class="input-group-addon">Start Time: </span>
										<input id="add-start-time" type="text" class="form-control input-small timepicker3" />
							        </div>
							        <div class="input-group bootstrap-timepicker timepicker btn_logged">
										<span class="input-group-addon">End Time: </span>
										<input id="add-end-time" type="text" class="form-control input-small timepicker3 endtimepicker" />
							        </div>
								</div>
						        <div class="checkbox-days">
						        	<label class="checkbox-inline"><input type="checkbox" name="days" value="M" />MON</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="T" />TUE</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="W" />WED</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="Th" />THUR</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="F" />FRI</label>
						        </div>
  							</div>
  							<div id="addprefinstructor" class="tab-pane fade">
  								<div class="input-group btn_logged">
  									<div class="input-group-btn">
  										<button type="button" class="btn but_color">Preferred Instructor: </button>
  									</div>
  									<select class="form-control" id="add-pref-input">
										@foreach($instructors as $instructor)
										<option value="{{$instructor}}">{{$instructor}}</option>
  										@endforeach
  									</select>
  								</div>
  							</div>
  							<div id="addmaxstraight" class="tab-pane fade">
  								<div class="input-group btn_logged">
									<span class="input-group-addon">Maximum No. of Straight Classes: </span>
									<input id="add-straight-num" type="number" class="form-control" min="1" value="1" />
						        </div>
  							</div>
  							<div id="addmaxdaily" class="tab-pane fade">
  								<div class="input-group btn_logged">
									<span class="input-group-addon">Maximum No. of Daily Classes: </span>
									<input id="add-max-num" type="number" class="form-control" min="1" value="1" />
						        </div>
  							</div>
						</div>
						<hr />
						<button id="add_constraint" type="submit" class="btn but_color btn_logged" disabled="true">Add</button>
			    		<button type="button" class="btn btn-default btn_logged" data-dismiss="modal">Close</button>
			    	</form>
			    </div>
		    </div>
	    </div>
	</div>
	<!-- END MODAL ADD CONSTRAINTS -->

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
  							<li data-tab="editprefinstructor"><a data-toggle="tab" href="#editprefinstructor">Preferred Instructor</a></li>
  							<li data-tab="editmaxdaily"><a data-toggle="tab" href="#editmaxdaily">Max Daily</a></li>
  							<li data-tab="editmaxstraight"><a data-toggle="tab" href="#editmaxstraight">Max Straight</a></li>
						</ul>
						<div class="tab-content">
  							<div id="editcourserestriction" class="tab-pane fade in active">
  								<div class="input-group bootstrap-timepicker timepicker btn_logged">
									<div class="input-group-btn">
										<button data-constraint="mustnothave" type="button" class="btn but_color dropdown-toggle edit-constraint-btn" data-toggle="dropdown">Must Not Have <span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu">
											<li role="presentation">
												<a class="edit-constraint-item constraint-item" href="javascript:void(0)">Must Have</a>
											</li>
											<li role="presentation">
												<a class="edit-constraint-item constraint-item" href="javascript:void(0)">Must Not Have</a>
											</li>
										</ul>
									</div>
									<input name="edit_course" type="text" class="form-control input-small" />
						        </div>
  							</div>
  							<div id="editmeetingtime" class="tab-pane fade">
  								<div class="input-group btn_logged">
  									<div class="input-group-btn">
  										<button type="button" class="btn but_color">Constraint Type: </button>
  									</div>
  									<select class="form-control" id="edit_meetingtime_type">
  										<option value="1">No Class On Day</option>
  										<option value="2">No Class On Time</option>
  										<option value="3">No Class On Day & Time</option>
  										<option value="4">Class Within Range For All Days</option>
  										<option value="5">Class Within Range For Specific Days</option>
  									</select>
  								</div>
								<div class="edit_time_div" style="display: none">
									<div class="input-group bootstrap-timepicker timepicker btn_logged">
										<span class="input-group-addon">Start Time: </span>
										<input id="edit-start-time" type="text" class="form-control input-small timepicker3" />
							        </div>
							        <div class="input-group bootstrap-timepicker timepicker btn_logged">
										<span class="input-group-addon">End Time: </span>
										<input id="edit-end-time" type="text" class="form-control input-small timepicker3" />
							        </div>
								</div>
						        <div class="edit-checkbox-days">
	    							<label class="checkbox-inline"><input type="checkbox" name="days" value="M">MON</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="T">TUE</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="W">WED</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="Th">THUR</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="F">FRI</label>
						        </div>
							</div>
							<div id="editprefinstructor" class="tab-pane fade">
  								<div class="input-group btn_logged">
  									<div class="input-group-btn">
  										<button type="button" class="btn but_color">Preferred Instructor: </button>
  									</div>
  									<select class="form-control" id="edit-pref-input">
										@foreach($instructors as $instructor)
										<option value="{{$instructor}}">{{$instructor}}</option>
  										@endforeach
  									</select>
  								</div>
  							</div>
  							<div id="editmaxstraight" class="tab-pane fade">
  								<div class="input-group btn_logged">
									<span class="input-group-addon">Maximum No. of Straight Classes: </span>
									<input id="edit-straight-num" type="number" class="form-control" min="1" value="1" />
						        </div>
  							</div>
  							<div id="editmaxdaily" class="tab-pane fade">
  								<div class="input-group btn_logged">
									<span class="input-group-addon">Maximum No. of Daily Classes: </span>
									<input id="edit-max-num" type="number" class="form-control" min="1" value="1" />
						        </div>
  							</div>
						</div>
						<hr />
						<button id="edit_constraint" type="submit" class="btn but_color btn_logged" data-dismiss="modal">EDIT</button>
			    		<button type="button" class="btn btn-default btn_logged edit_modal_close" data-dismiss="modal">Close</button>
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
					<button type="button" class="btn btn-default btn_logged" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- SCHEDULE GENERATE ERROR MODAL END -->

	<!-- LOADING MODAL -->
	<div id="loading-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="text-center"> LOADING . . .</h4>
				</div>
				<div class="modal-body">
					<div class="progress">
						<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- LOADING MODAL END -->

	<!-- ERROR LOADING MODAL -->
	<div id="error-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4><span class="glyphicon glyphicon-warning-sign"></span> GENERATE SCHEDULE</h4>
				</div>
				<div class="modal-body">
					Something went wrong in creating your schedule. Please try again.
				</div>
			</div>
		</div>
	</div>
	<!-- LOADING MODAL END -->

	<!-- SUCCESS MODAL -->
	<div id="success-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4><span class="glyphicon glyphicon-ok-circle"></span> GENERATE SCHEDULE</h4>
				</div>
				<div class="modal-body">
					Your schedule is now generated!
				</div>
			</div>
		</div>
	</div>
	<!-- LOADING MODAL END -->

	<!-- ADD CONSTRAINT SUCCESS MODAL -->
	<div id="add-success-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-success">
					<h4><span class="glyphicon glyphicon-ok-circle"></span> ADD CONSTRAINT</h4>
				</div>
				<div class="modal-body">
					Successfully added a constraint!
				</div>
			</div>
		</div>
	</div>
	<!-- LOADING MODAL END -->
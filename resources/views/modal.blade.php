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
						        	<label class="checkbox-inline"><input type="checkbox" name="days" value="M">MON</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="T">TUE</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="W">WED</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="Th">THUR</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="F">FRI</label>
						        </div>
  							</div>
						</div>
						<hr />
						<button id="add_constraint" type="submit" class="btn but_color btn_logged" data-dismiss="modal">Add</button>
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
	    							<label class="checkbox-inline"><input type="checkbox" name="days" value="M">MON</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="T">TUE</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="W">WED</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="Th">THUR</label>
									<label class="checkbox-inline"><input type="checkbox" name="days" value="F">FRI</label>
						        </div>
							</div><!-- 
							<div id="scheduleflow" class="tab-pane fade">
								<label class="radio-inline"><input type="radio" name="priority" value="block" checked="checked">Block Schedule</label>
								<label class="radio-inline"><input type="radio" name="priority" value="straight">Straight Schedule</label>
								<label class="radio-inline"><input type="radio" name="priority" value="sparse">Sparse Schedule</label>
							</div> -->
						</div>
						<hr />
						<button id="edit_constraint" type="submit" class="btn but_color btn_logged">EDIT</button>
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
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4><span class="glyphicon glyphicon-remove-circle"></span> GENERATE SCHEDULE</h4>
				</div>
				<div class="modal-body">
					Something went wrong in creating your schedule. Please try again.
				</div>
			</div>
		</div>
	</div>
	<!-- LOADING MODAL END -->
@extends('layouts.app')

@section('content')
<!-- MIDDLE PART -->
	<div class="container index_container">

		<!-- Column md 4 -->
		<div class="col-md-4 right_side">

			<!-- FOR 4.0, 5.0 and INC -->
			<div class="panel panel-default panel-shadow">
					<div class="panel-body">
							<div class="panel-heading">
								<h3>
									Important Subjects
								</h3>
							</div>					
							<!-- PRIORITIES -->
							<div class="panel-group priorities" id="accordion">
								<!-- INC -->
  								<div class="panel panel-default">
    								<div class="panel-heading important">
      									<h4 class="panel-title">
        									<!-- <a data-toggle="collapse" data-parent="#accordion" href="#high">High Priority</a> -->
        									<a data-toggle="collapse" href="#comply">To Comply (INC)<span class="badge pull-right" id="high_badge">3</span></a>
     									</h4>
    								</div>
    								<div id="comply" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												<b>Eng 10</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												<b>Hum 1</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												<b>Soc Sci 1</b>
      											</p>
      										</div>
      									</div>
    								</div>
    							</div>

								<!-- 4.0 -->
  								<div class="panel panel-default">
    								<div class="panel-heading important">
      									<h4 class="panel-title">
        									<!-- <a data-toggle="collapse" data-parent="#accordion" href="#high">High Priority</a> -->
        									<a class='' data-toggle="collapse" href="#toremove">To Remove (4.0)<span class=" badge pull-right" id="high_badge">1</span></a>
     									</h4>
    								</div>
    								<div id="toremove" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												<b>Comm 3</b>
      											</p>
      										</div>
      									</div>
    								</div>
    							</div>

								<!-- 5.0 -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" href="#retake">To Retake (5.0)<span class="badge pull-right" id="medium_badge">0</span></a>
     									</h4>
    								</div>
    								<div id="retake" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												<b>No Subjects</b>
      											</p>
      										</div>
      									</div>
      								</div>
								</div>	
							</div>				
					</div>
				</div>
				<!-- END CHECK REMAINING GE -->

			<!-- CHECK REMAINING GE -->
			<div class="panel panel-default panel-shadow">
					<div class="panel-body">
							<div class="panel-heading">
								<h3>
									Check Remaining Available GE
								</h3>
							</div>					
							<!-- PRIORITIES -->
							<div class="panel-group priorities" id="accordion">
								<!-- AH -->
  								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<!-- <a data-toggle="collapse" data-parent="#accordion" href="#high">High Priority</a> -->
        									<a data-toggle="collapse" href="#GEah">AH<span class="badge pull-right" id="high_badge">3</span></a>
     									</h4>
    								</div>
    								<div id="GEah" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Comm 3</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Lit 2</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Lit 3</b>
      											</p>
      										</div>
      									</div>
    								</div>
    							</div>

								<!-- Medium Priority -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" href="#GEmst">MST<span class="badge pull-right" id="medium_badge">3</span></a>
     									</h4>
    								</div>
    								<div id="GEmst" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Envi Sci 10</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Nat Sci 1</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Nat Sci 2</b>
      											</p>
      										</div>
      									</div>
      								</div>
								</div>

								<!-- Low Priority -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" href="#GEssp">SSP<span class="badge pull-right" id="low_badge">5</span></a>
     									</h4>
    								</div>
    								<div id="GEssp" class="panel-collapse collapse">
      									<div class="panel-body">
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Hist 2</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Psych 10</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Soc Sci 1</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Soc Sci 10</b>
      											</p>
      										</div>
      										<div class="priority_entry no_entry">
      											<p>
      												&nbsp;<br/>
      												<b>Soc Sci 11</b>
      											</p>
      										</div>
      									</div>
    								</div>
								</div>
							</div>
  							
					</div>
				</div>
				<!-- END CHECK REMAINING GE -->

		</div>
		<!-- End Column md 4 -->

		<!-- Column md 8 -->
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4><strong>FOURTH YEAR</strong> <small class="pull-right">A.Y. 2017-2018</small></h4>
				</div>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Second Semester</th>
								<th>Units</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PI 100</td>
								<td>3.0</td>
								<td>
									<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<tr>
								<td>CMSC 198.2</td>
								<td>3.0</td>
								<td>
									<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<tr>
								<td>
									<div class="dropdown">
										<select class="constraint-btn dropbtn">
											<option selected hidden >CHOOSE ELECTIVE</option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 152 <p>Management Information System</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 170 <p>Introduction to Artificial Intelligence</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Computer Vision</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Data Mining</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Scientific Computer</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Mobile Development</p></a></option>
										</select>
									</div>
								</td>
								<td>3.0</td>
								<td>
									<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<tr>
								<td>
								  	<div class="dropdown">
										<select class="constraint-btn dropbtn">
											<option selected hidden >CHOOSE ELECTIVE</option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 152 <p>Management Information System</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 170 <p>Introduction to Artificial Intelligence</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Computer Vision</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Data Mining</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Scientific Computer</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Mobile Development</p></a></option>
										</select>
									</div>
								</td>
								<td>3.0</td>
								<td>
									<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<tr>
								<td>
									<div class="dropdown">
										<select class="constraint-btn dropbtn">
											<option selected hidden >CHOOSE ELECTIVE</option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 152 <p>Management Information System</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 170 <p>Introduction to Artificial Intelligence</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Computer Vision</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Data Mining</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Scientific Computer</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Mobile Development</p></a></option>
										</select>
									</div>
								</td>
								<td>3.0</td>
								<td>
									<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<tr>
								<td>
									<div class="dropdown">
										<select class="constraint-btn dropbtn">
											<option class="title" selected hidden >CHOOSE ELECTIVE</option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 152 <p>Management Information System</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 170 <p>Introduction to Artificial Intelligence</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Computer Vision</p></a></option>
											<option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Data Mining</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Scientific Computer</p></a></option>
										    <option><a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Mobile Development</p></a></option>
										</select>
									</div>
									<!-- <div class="dropdown">
									  	<p class="constraint-btn dropbtn"> CHOOSE ELECTIVE <span class="caret"></span></p>
									  	<div class="dropdown-content">
									    	 <a class="constraint-item" href="javascript:void(0)">CMSC 152 <p>Management Information System</p></a>
									    	<a class="constraint-item" href="javascript:void(0)">CMSC 170 <p>Introduction to Artificial Intelligence</p></a>
									    	<a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Computer Vision</p></a>
									    	<a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Data Mining</p></a>
									    	<a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Scientific Computer</p></a>
									    	<a class="constraint-item" href="javascript:void(0)">CMSC 197 <p>Mobile Development</p></a>
									  	</div>
									</div>  -->
								</td>
								<td>3.0</td>
								<td>
									<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr class="">
								<td><strong>TOTAL</strong></td>
								<td>17 units</td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div>
					<div class="btn-group btn_logged pull-right">
						<a class="btn but_color" href="/addwishlist"> Send Preference </a>
					</div>
				</div>
			</div>
		</div>
		<!-- END Column md 8 -->
	</div>
	<!-- END MIDDLE PART -->

	<!--- MODAL REMOVE CONSTRAINTS -->
	<div id="remove" class="modal fade" role="dialog">
		<div class="modal-dialog">
		  	<div class="modal-content ">
			    <div class="modal-body confirm_panel">
			        <h4> Are you sure you want to remove this? </h4>
			        <p>&nbsp;</p>
			    	<button type="button" class="btn btn-danger remove-constraint" data-dismiss="modal">Remove</button>
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    </div>
		    </div>
	    </div>
	</div>
	<!-- END MODAL REMOVE CONSTRAINTS -->
@endsection
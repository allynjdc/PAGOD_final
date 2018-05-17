@extends('layouts.app')

@section('content')
	<!-- MIDDLE CONTENT  -->
	<div class="container index_container">

		<div id="app">
	        @include('flash_message')
	    </div>
	    
		<!-- ROW -->
		<div class="row">
			<!-- Column md 4 -->
			<div class="col-md-4 right_side">
				<!-- STUDENT INFORMATION -->
				<div class="panel panel-default panel-shadow panel-profile-index-home">
					<div class="panel-body">
						<img class="cover-img-index img-responsive" alt="cover" src="images/upv.jpg" data-toggle="modal" data-target="#cover-img" />
						<div class="img-dp-index">
							<img class="profile-img-index img-thumbnail img-responsive" alt="profile" src="{{ Auth::user()->profile_picture }}" data-toggle="modal" data-target="#profile-img"/>
						</div>
						<div class="text-name-index">
							<h4><b>{{ Auth::user()->name }}</b></h4>
							<small>{{ Auth::user()->courseName() }}</small>
						</div>
						<!-- <div class="ge-counts col-md-12 text-center">
							<div class="count1 col-md-3 text-center">
								<p><b><a class="anchor_color" href="#electives" data-toggle="modal">Electives</a></b><br> 4 </p>
							</div>
							<div class="count1 col-md-3 text-center">
								<p><b><a class="anchor_color" href="#ah" data-toggle="modal">AH</a></b><br> 5 </p>
							</div>
							<div class="count1 col-md-3 text-center">
								<p><b><a class="anchor_color" href="#mst" data-toggle="modal">MST</a></b><br> 4 </p>
							</div>
							<div class="count1 col-md-3 text-center">
								<p><b><a class="anchor_color" href="#ssp" data-toggle="modal">SSP</a></b><br> 5 </p>
							</div>
						</div> -->
					</div>
				</div>
				<!-- END STUDENT INFORMATION -->

				<!-- BUTTONS PANEL -->
				<div class="panel panel-default panel-shadow">
					<div class="panel-body">
						<div class="btn-group">
							<div class="btn-group-justified btn_logged">
								<a class="btn but_color" href="/addwishlist"> Check Schedule Generator </a>
							</div>
							<div class="btn-group-justified btn_logged">
								<a class="btn but_color" href="/addpreference"> Edit Subject Preferences </a>
							</div>
							<div class="btn-group-justified btn_logged">
								<a class="btn but_color" href="/studyplan"> View Study Plan </a>
							</div>
							<div class="btn-group-justified btn_logged">
								<a class="btn but_color" href="/acadprogress"> View Academic Progress </a>
							</div>
						</div>
					</div>
				</div>
				<!-- END BUTTONS PANEL -->

				<!-- MODAL: electives -->
				<div id="electives" class="modal fade" role="dialog">
					<div class="modal-dialog modal-ge-count">
				  		<div class="modal-heading">
							<p class="title">Electives</p>
						</div>
					    <div class="modal-body confirm_panel">
					       <div class="table-responsive">
								<table class="table">
									<thead>
											<tr>
											<th>COURSE</th>
											<th>TITLE</th>
											<th>UNIT</th>
											</tr>
									</thead>
									<tbody>
											<tr>
									        <td>CMSC 151</td>
									        <td>System Analysis and Design</td>
									        <td>3.0</td>
											</tr>
											<tr>
									        <td>CMSC 162</td>
									        <td>3D Animation</td>
									        <td>3.0</td>
											</tr>
										</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					    </div>
				    </div>
			    </div>
				<!-- END MODAL: electives --> 

				<!-- MODAL: AH -->
				<div id="ah" class="modal fade" role="dialog">
					<div class="modal-dialog modal-ge-count">
				  		<div class="modal-heading">
							<p class="title">GE (AH)</p>
						</div>
					    <div class="modal-body confirm_panel">
					       <div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Eng 2</td>
									        <td>Read Right, Write Right</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Comm 1</td>
									        <td>Communication Skills</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Comm 2</td>
									        <td>Communication Skills 2</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Hum 1</td>
									        <td>Art, Society, and the Individual</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Lit 1</td>
									        <td>Literatures of the Philippines</td>
									        <td>3.0</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
		  				</div>
		  				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					    </div>
				    </div>
			    </div>
				<!-- END MODAL: AH --> 

				<!-- MODAL: MST -->
				<div id="mst" class="modal fade" role="dialog">
					<div class="modal-dialog modal-ge-count">
				  		<div class="modal-heading">
							<p class="title">GE (MST)</p>
						</div>
					    <div class="modal-body confirm_panel">
					       <div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Aqua Sci 1</td>
									        <td>Fish Make Sense</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Aqua Sci 16</td>
									        <td>Fish Beyond Capture</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Bio20</td>
									        <td>Living with Microbes in Sickness and in Health</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Bio 1</td>
									        <td>Understanding Life</td>
									        <td>3.0</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
		  				</div>
		  				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					    </div>
				    </div>
			    </div>
				<!-- END MODAL: MST -->

				<!-- MODAL: SSP -->
				<div id="ssp" class="modal fade" role="dialog">
					<div class="modal-dialog modal-ge-count">
				  		<div class="modal-heading">
							<p class="title">GE (SSP)</p>
						</div>
					    <div class="modal-body confirm_panel">
					       <div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Philo 1</td>
									        <td>Phylosophical Analysis</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Hist 1</td>
									        <td>Philippine History</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Soc Sci 5</td>
									        <td>Understanding Gender</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Soc Sci 2</td>
									        <td>Social, Economic, and Political Thought</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Soc Sci 26</td>
									        <td>People, Places, and Spaces in a Changing World</td>
									        <td>3.0</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
		  				</div>
		  				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					    </div>
				    </div>
			    </div>
				<!-- END MODAL: SSP --> 

			</div>
			<!-- End Column md 4 -->

        	@yield('studinfo')

		    <!-- Scripts -->
		    <script src="{{ asset('js/app.js') }}"></script>

		</div>
	</div>
	<!-- END MIDDLE CONTENT -->

@endsection
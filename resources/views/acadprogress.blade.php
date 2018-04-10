@extends('layouts.studinfo')

@section('studinfo')
<!-- Column md 8 -->
<div class="col-md-8">
	<!-- PROGRESS PANEL -->
	<div class="panel panel-default panel-shadow">
		<div class="panel-body">

			<!-- SUBJECT COURSES -->
			<div class="panel-group course_panel" id="accordion"> 
				<!-- MAJOR COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#major">
								Core Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$ccore}}%">
				      			<span class="sr-only">{{$ccore}} Core Courses</span>
				    		</div>
				  		</div>
					</div>
					<div id="major" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
										@if($ccore > 0)
											@foreach($core as $sub)
				  								<tr>
											        <td>{{$sub[0]}}</td>
											        <td>{{$sub[1]}}</td>
				  								</tr>
			  								@endforeach
			  							@else 
			  								<tr>
										        <td>&nbsp;</td>
										        <td>&nbsp;</td>
				  							</tr>
			  							@endif
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END MAJOR COURSES -->

				<!-- ELECTIVE COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#elec">
								Elective Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$celect}}%">
				      			<span class="sr-only">{{$celect}} Elective Courses</span>
				    		</div>
				  		</div>
					</div>
					<div id="elec" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
										@if($celect > 0)
											@foreach($elect as $sub)
				  								<tr>
											        <td>{{$sub[0]}}</td>
											        <td>{{$sub[1]}}</td>
				  								</tr>
			  								@endforeach
			  							@else
			  								<tr>
										        <td>&nbsp;</td>
										        <td>&nbsp;</td>
				  							</tr>
			  							@endif
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END ELECTIVE COURSES -->

				<!-- GE(AH) COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#geah">
								GE(AH) Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$cah}}%">
				      			<span class="sr-only">{{$cah}} GE(AH)</span>
				    		</div>
				  		</div>
					</div>
					<div id="geah" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
										@if($cah > 0)
											@foreach($ah as $sub)
				  								<tr>
											        <td>{{$sub[0]}}</td>
											        <td>{{$sub[1]}}</td>
				  								</tr>
			  								@endforeach
			  							@else
			  								<tr>
										        <td>&nbsp;</td>
										        <td>&nbsp;</td>
				  							</tr>
			  							@endif
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END GE(AH) COURSES -->

				<!-- GE(MST) COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#gemst">
								GE(MST) Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$cmst}}%">
				      			<span class="sr-only">{{$cmst}} Complete</span>
				    		</div>
				  		</div>
					</div>
					<div id="gemst" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
										@if($cmst > 0)
											@foreach($mst as $sub)
				  								<tr>
											        <td>{{$sub[0]}}</td>
											        <td>{{$sub[1]}}</td>
				  								</tr>
			  								@endforeach
			  							@else
			  								<tr>
										        <td>&nbsp;</td>
										        <td>&nbsp;</td>
				  							</tr>
			  							@endif
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END GE(MST) COURSES -->

				<!-- GE(SSP) COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#gessp">
								GE(SSP) Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$cssp}}%">
				      			<span class="sr-only">{{$cssp}} Complete</span>
				    		</div>
				  		</div>
					</div>
					<div id="gessp" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
										@if($cssp > 0)
											@foreach($ssp as $sub)
				  								<tr>
											        <td>{{$sub[0]}}</td>
											        <td>{{$sub[1]}}</td>
				  								</tr>
			  								@endforeach
			  							@else
			  								<tr>
										        <td>&nbsp;</td>
										        <td>&nbsp;</td>
				  							</tr>
			  							@endif
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END GE(SSP) COURSES -->

				<!-- NON-ACADEMIC COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#pe">
								Non-Academic Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$cpenstp}}%">
				      			<span class="sr-only">{{$cpenstp}} Complete</span>
				    		</div>
				  		</div>
					</div>
					<div id="pe" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
										@if($cpenstp > 0)
											@foreach($open as $sub)
				  								<tr>
											        <td>{{$sub[0]}}</td>
											        <td>{{$sub[1]}}</td>
				  								</tr>
			  								@endforeach
			  							@else
			  								<tr>
										        <td>&nbsp;</td>
										        <td>&nbsp;</td>
				  							</tr>
			  							@endif
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END NON-ACADEMIC COURSES -->

			</div>
		</div>
	</div>
	<!-- END PROGRESS PANEL -->
</div>
<!-- End Column md 8 -->
@endsection
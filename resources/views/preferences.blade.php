@extends('layouts.studinfo')

@section('studinfo1')

<!-- Column md 4 -->
<!-- <div class="col-md-4 right_side"> -->

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
									<a data-toggle="collapse" href="#comply">CORE Courses<span class="badge pull-right" id="high_badge">{{sizeof($core)}}</span></a>
									</h4>
							</div>
							<div id="comply" class="panel-collapse collapse">
									<div class="panel-body">
										@foreach($core as $subj)
										<div class="priority_entry no_entry">
											<p>
												<b>{{strtoupper($subj)}}</b>
											</p>
										</div>
										@endforeach
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
									<a data-toggle="collapse" href="#GEah">AH<span class="badge pull-right" id="high_badge">{{sizeof($ah)}}</span></a>
									</h4>
							</div>
							<div id="GEah" class="panel-collapse collapse">
									<div class="panel-body">
										@foreach($ah as $subj)
										<div class="priority_entry no_entry">
											<p>
												&nbsp;<br/>
												<b>{{strtoupper($subj)}}</b>
											</p>
										</div>
										@endforeach
									</div>
							</div>
						</div>

						<!-- Medium Priority -->
						<div class="panel panel-default">
							<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" href="#GEmst">MST<span class="badge pull-right" id="medium_badge">{{sizeof($mst)}}</span></a>
									</h4>
							</div>
							<div id="GEmst" class="panel-collapse collapse">
									<div class="panel-body">
										@foreach($mst as $subj)
										<div class="priority_entry no_entry">
											<p>
												&nbsp;<br/>
												<b>{{strtoupper($subj)}}</b>
											</p>
										</div>
										@endforeach
									</div>
								</div>
						</div>

						<!-- Low Priority -->
						<div class="panel panel-default">
							<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" href="#GEssp">SSP<span class="badge pull-right" id="low_badge">{{sizeof($ssp)}}</span></a>
									</h4>
							</div>
							<div id="GEssp" class="panel-collapse collapse">
									<div class="panel-body">
										@foreach($ssp as $subj)
										<div class="priority_entry no_entry">
											<p>
												&nbsp;<br/>
												<b>{{strtoupper($subj)}}</b>
											</p>
										</div>
										@endforeach
									</div>
							</div>
						</div>
					</div>
						
			</div>
		</div>
		<!-- END CHECK REMAINING GE -->

<!-- </div> -->
<!-- End Column md 4 -->

@endsection

@section('studinfo') 

<!-- Column md 8 -->
<div class="col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			@if($year == 1)
				<h4><strong>FIRST YEAR</strong> <!-- <small class="pull-right">A.Y. 2017-2018</small> --></h4>
			@elseif($year == 2)
				<h4><strong>SECOND YEAR</strong> <!-- <small class="pull-right">A.Y. 2017-2018</small> --></h4>
			@elseif($year == 3)
				<h4><strong>THIRD YEAR</strong> <!-- <small class="pull-right">A.Y. 2017-2018</small> --></h4>
			@elseif($year == 4)
				<h4><strong>FOURTH YEAR</strong> <!-- <small class="pull-right">A.Y. 2017-2018</small> --></h4>
			@endif
		</div>
		<form role="form" method="GET" action="/submitpreference">
			<div class="table-responsive">					
                {{ csrf_field() }}
				<table class="table table-hover">
					<thead>
						<tr>
							@if($sem == 2)
								<th>Second Semester</th>
							@else
								<th>First Semester</th>
							@endif
							<th>Units</th>
							<th>Lec / Lab</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sfinal as $subj)
						<tr>
							@if(substr_count(strtoupper($subj[2]),"PE")>0||substr_count(strtoupper($subj[2]),"GE")>0||substr_count(strtoupper($subj[2]),"ELECTIVE")>0)
								<td>
									@if(!empty($preferences[$con]))
									<input type="text" name="subject_{{$con = $con+1}}" class="form-control" value="{{$preferences[$con]}}" placeholder="{{$subj[2]}}" />
									@else
									<input type="text" name="subject_{{$con = $con+1}}" class="form-control" placeholder="{{$subj[2]}}" />
									@endif
								</td>
								<td>{{$subj[4]}}
									<input type="hidden" name="unit_{{$con}}" class="form-control" value="{{$subj[4]}}"/>
									<input type="hidden" name="type_{{$con}}" class="form-control" value="{{$subj[3]}}" />
								</td>
								<td>{{$subj[6]}}
									<input type="hidden" name="leclab_{{$con}}" class="form-control" value="{{$subj[6]}}" />
								</td>
							@else
								<td>{{$subj[2]}} <input type="hidden" name="subject_{{$con = $con+1}}" class="form-control" value="{{$subj[2]}}"/> </td>
								<td>{{$subj[4]}}
									<input type="hidden" name="unit_{{$con}}" class="form-control" value="{{$subj[4]}}" />
									<input type="hidden" name="type_{{$con}}" class="form-control" value="{{$subj[3]}}" />
								</td>
								<td>{{$subj[6]}}
									<input type="hidden" name="leclab_{{$con}}" class="form-control" value="{{$subj[6]}}" />
								</td>
							@endif
						</tr>
						@endforeach
						<input type="hidden" name="subject_count" class="form-control" value="{{$con}}" /> 
						<input type="hidden" name="year" class="form-control" value="{{$year}}" /> 
						<input type="hidden" name="sem" class="form-control" value="{{$sem}}" /> 
						
						<!-- <tr>
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
							</td>
							<td>3.0</td>
							<td>
								<a href='#remove' data-toggle='modal' class='anchor_color'><span class="glyphicon glyphicon-remove"></span></a>
							</td>
						</tr> -->
					</tbody>
					<tfoot>
						<td><strong>TOTAL</strong></td>
						<td>{{$sum1}} units</td>
						<td><button class="btn but_color"> Save Preference </button></td>
					</tfoot>
				</table>
				
			</div>
			<!-- <div>
				<div class="btn-group btn_logged pull-right">
					
				</div>
			</div> -->
		</form>
	</div>
</div>
<!-- END Column md 8 -->
@endsection
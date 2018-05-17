@extends('layouts.studinfo')

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
										<td><input type="text" name="subject_{{$con = $con+1}}" class="form-control" placeholder="{{$subj[2]}}" /> </td>
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
								<td><button class="btn but_color"> Send Preference </button></td>
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

@endsection
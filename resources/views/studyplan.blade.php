@extends('layouts.studinfo')

@section('studinfo') 
<!-- Column md 8 -->
<div class="col-md-8 col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="table_text"><strong>FIRST YEAR</strong> <small class="pull-right">A.Y. 2014-2015</small></h4>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>First Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 1 && $row[1] == 1)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] == 1)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum1}} units</td>
						@if($sum1>0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Second Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 1 && $row[1] == 2)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] == 1)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum2}} units</td>
						@if($sum2 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="table_text"><strong>SECOND YEAR</strong> <small class="pull-right">A.Y. 2015-2016</small></h4>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>First Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 2 && $row[1] == 1)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] == 1)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum3}} units</td>
						@if($sum3 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Second Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 2 && $row[1] == 2)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] == 1)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum4}} units</td>
						@if($sum4 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="table_text"><strong>THIRD YEAR</strong> <small class="pull-right">A.Y. 2016-2017</small></h4>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>First Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 3 && $row[1] == 1)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] == 1)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum5}} units</td>
						@if($sum5 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Second Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr> 
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 3 && $row[1] == 2)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] > 0)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum6}} units</td>
						@if($sum6 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		@if($midr > 0)
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Midyear</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				@foreach($mid as $row)
						<tr>
							<td>{{$row[0]}}</td>
							<td>
								@if(is_numeric($row[1]))
									{{$row[1]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span>
								@endif
							</td>
							@if($row[2] > 0)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
				@endforeach
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum9}} units</td>
						@if($sum9 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		@endif
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="table_text"><strong>FOURTH YEAR</strong> <small class="pull-right">A.Y. 2017-2018</small></h4>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>First Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 4 && $row[1] == 1)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] > 0)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum7}} units</td>
						@if($sum7 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Second Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 4 && $row[1] == 2)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] > 0)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum8}} units</td>
						@if($sum8 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	@if($has5th > 0)
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="table_text"><strong>FIFTH YEAR</strong> <small class="pull-right">A.Y. 2017-2018</small></h4>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>First Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 5 && $row[1] == 1)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] > 0)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum10}} units</td>
						@if($sum10 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Second Semester</th>
						<th>Units</th>
						<th>Completion</th>
					</tr>
				</thead>
				<tbody>
				@foreach($final as $row)
					@if($row[0] == 5 && $row[1] == 2)
						<tr>
							<td>{{$row[2]}}</td>
							<td>@if(is_numeric($row[3]))
									{{$row[3]}} units
								@else
									<span class="glyphicon glyphicon-minus"></span> 
								@endif</td>
							@if($row[4] > 0)
							<td><span class="glyphicon glyphicon-ok"></span></td>
							@else
							<td><span class="glyphicon glyphicon-remove"></span></td>
							@endif
						</tr>
					@endif
				@endforeach
				</tbody>
				<tfoot>
					<tr class="bg-success">
						<td><strong>TOTAL</strong></td>
						<td>{{$sum11}} units</td>
						@if($sum11 > 0)
						<td><span class="glyphicon glyphicon-ok"></span></td>
						@else
						<td><span class="glyphicon glyphicon-remove"></span></td>
						@endif
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	@endif
</div>
<!-- END Column md 8 -->	
@endsection
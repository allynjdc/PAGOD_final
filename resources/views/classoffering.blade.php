@extends('layouts.studinfo')

@section('studinfo') 
 
<div class="col-md-8 col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="table_text"><strong>CLASS OFFERINGS</strong> <small class="pull-right">A.Y. {{$final[1][0]}}</small></h4>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table_text">
						<th>Course Name</th>
						<th>Units</th>
						<th>Schedule</th>
						<th>Instructor</th>
					</tr>
				</thead>
				<tbody>
					@foreach($final as $col)
					<tr>
						<td>{{strtoupper($col[2])}} - {{$col[3]}}</td>
						<td>{{$col[4]}}</td>
						<td>{{$col[6]}}<br>{{$col[5]}}</td>
						<td>{{$col[7]}}</td>
					</tr>
					@endforeach
					<!-- <tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr> -->
				</tbody>
				<tfoot>
					<tr class="bg-danger">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<!-- <td><strong>TOTAL</strong></td>
						<td> units</td>
						<td><span class="glyphicon glyphicon-ok"></span></td>
						<td><span class="glyphicon glyphicon-remove"></span></td> -->
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>


@endsection
@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('js/LoadingModal/css/jquery.loadingModal.css') }}">
@endpush

@push('header_scripts')
<script src=" {{ asset('js/schedule_script.js') }} "></script>
@endpush

@section('content')
    @include('modal')
	<!-- MIDDLE CONTENT -->
	<div class="container index_container">

        <div id="app">
            @if($restart == 1)
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>You recently updated your preferences, please press the generate button again to update your schedule.</strong>
            </div>
            @endif
        </div>
        <div class="warning-message-div">
            @if(Auth::user()->constraints_changed == 1)
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>There were some changes with your constraints please generate your schedule again.</strong>
            </div>
            @endif
        </div>

		<!-- ROW -->
		<div class="row">
			<!-- Column md 4 -->
			<div class="col-md-4 right_side">
				<!-- CONSTRAINTS PANEL -->

                @include('constraints')

				<div class="panel panel-default panel-shadow">
					<div class="panel-body">
						<div class="btn-group">
							<div class="btn-group-justified">
								<a class="btn but_color" data-toggle="modal" href="#addconstraint"><span class="glyphicon glyphicon-plus"></span> ADD CONSTRAINT</a>
							</div>
							<!-- PRIORITIES -->
							<div class="panel-group priorities" id="accordion">
                                <!-- Preferred Subjects -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-target="#preferredsubjects">Preferred Subjects<span class="badge pull-right" id="preferred_badge">{{count($constraintPreferred)}}</span></a>
                                        </h4>
                                    </div>
                                    <div>
                                        <div class="panel-body">
                                        @forelse($constraintPreferred as $key=>$constraint)
                                        <div class="preferred_entry @if(!Auth::user()->need_restart && $constraint['included']) @if($constraint['not_violated']) bg-danger @else bg-success @endif @endif" id="preferred_{{$key+1}}">
                                            <p>
                                                <b>{{$constraint['text']}}</b>
                                            </p>
                                        </div>
                                        @empty
                                        <div class="preferred_entry no_entry">
                                            <p>
                                                <b>No Constraints</b>
                                            </p>
                                        </div>
                                        @endforelse
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Preferred Subjects -->
								<!-- High Priority -->
  								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<!-- <a data-toggle="collapse" data-parent="#accordion" href="#high">High Priority</a> -->
        									<a data-toggle="collapse" data-target="#high">High Priority<span class="badge pull-right" id="high_badge">{{count($constraintHigh)}}</span></a>
     									</h4>
    								</div>
    								<div id="high" class="panel-collapse collapse @if(count($constraintHigh) >= 1) in @endif">
      									<div class="panel-body">
                                        @forelse($constraintHigh as $key=>$constraint)
                                        <div class="priority_entry @if(!Auth::user()->need_restart && $constraint['included']) @if($constraint['not_violated']) bg-danger @else bg-success @endif @endif" id="high_{{$key+1}}">
                                            <p>
                                                <a class="edit-constraint pull-left" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit pull-right"></span></a>
                                                <a class="remove-constraint pull-left" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove pull-right"></span></a>
                                                <b>{{ $constraint["text"] }}</b>
                                            </p>
                                        </div>
                                        <script type="text/javascript">
                                            var days = "{{$constraint['days']}}".split(" ");
                                            var constraintObject = {
                                                id: "high_{{$key+1}}",
                                                constraint_type: "{{$constraint["constraint_type"]}}",
                                                priority: "{{$constraint['priority']}}",
                                                musthave: "{{$constraint['musthave']}}",
                                                start_time: "{{$constraint['start_time']}}",
                                                end_time: "{{$constraint['end_time']}}",
                                                course: "{{$constraint['course']}}".toUpperCase(),
                                                instructor: "{{$constraint['instructor']}}",
                                                days: days,
                                                maxnum: parseInt("{{$constraint['maxnum']}}")
                                            };
                                            $("#high_{{$key+1}}").data(constraintObject);
                                        </script>
                                        @empty
                                        <div class="priority_entry no_entry">
                                            <p>
                                                <b>No Constraints</b>
                                            </p>
                                        </div>
                                        @endforelse
      									</div>
    								</div>
    							</div>
    							<!-- Medium Priority -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" data-target="#medium">Medium Priority<span class="badge pull-right" id="medium_badge">{{count($constraintMed)}}</span></a>
     									</h4>
    								</div>
    								<div id="medium" class="panel-collapse collapse @if(count($constraintMed) >= 1) in @endif">
      									<div class="panel-body">
      										@forelse($constraintMed as $key=>$constraint)
                                            <div class="priority_entry @if(!Auth::user()->need_restart && $constraint['included']) @if($constraint['not_violated']) bg-danger @else bg-success @endif @endif" id="medium_{{$key+1}}">
                                                <p>
                                                    <a class="edit-constraint pull-left" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit"></span></a>
                                                    <a class="remove-constraint pull-left" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove"></span></a>
                                                    <b>{{ $constraint["text"] }}</b>
                                                </p>
                                            </div>
                                            <script type="text/javascript">
                                                var days = "{{$constraint['days']}}".split(" ");
                                                var constraintObject = {
                                                    id: "medium_{{$key+1}}",
                                                    constraint_type: "{{$constraint["constraint_type"]}}",
                                                    priority: "{{$constraint['priority']}}",
                                                    musthave: "{{$constraint['musthave']}}",
                                                    start_time: "{{$constraint['start_time']}}",
                                                    end_time: "{{$constraint['end_time']}}",
                                                    course: "{{$constraint['course']}}".toUpperCase(),
                                                    instructor: "{{$constraint['instructor']}}",
                                                    days: days,
                                                    maxnum: parseInt("{{$constraint['maxnum']}}")
                                                };
                                                $("#medium_{{$key+1}}").data(constraintObject);
                                            </script>
                                            @empty
                                            <div class="priority_entry no_entry">
                                                <p>
                                                    <b>No Constraints</b>
                                                </p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
								<!-- Low Priority -->
								<div class="panel panel-default">
    								<div class="panel-heading">
      									<h4 class="panel-title">
        									<a data-toggle="collapse" data-target="#low">Low Priority<span class="badge pull-right" id="low_badge">{{count($constraintLow)}}</span></a>
     									</h4>
    								</div>
    								<div id="low" class="panel-collapse collapse @if(count($constraintLow) >= 1) in @endif">
      									<div class="panel-body">
      										@forelse($constraintLow as $key=>$constraint)
                                            <div class="priority_entry @if(!Auth::user()->need_restart && $constraint['included']) @if($constraint['not_violated']) bg-danger @else bg-success @endif @endif" id="low_{{$key+1}}">
                                                <p>
                                                    <a class="edit-constraint pull-left" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit pull-right"></span></a>
                                                    <a class="remove-constraint pull-left" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove pull-right"></span></a>
                                                    <b>{{ $constraint["text"] }}</b>
                                                </p>
                                            </div>
                                            <script type="text/javascript">
                                                var days = "{{$constraint['days']}}".split(" ");
                                                var constraintObject = {
                                                    id: "low_{{$key+1}}",
                                                    constraint_type: "{{$constraint["constraint_type"]}}",
                                                    priority: "{{$constraint['priority']}}",
                                                    musthave: "{{$constraint['musthave']}}",
                                                    start_time: "{{$constraint['start_time']}}",
                                                    end_time: "{{$constraint['end_time']}}",
                                                    course: "{{$constraint['course']}}".toUpperCase(),
                                                    instructor: "{{$constraint['instructor']}}",
                                                    days: days,
                                                    maxnum: parseInt("{{$constraint['maxnum']}}")
                                                };
                                                $("#low_{{$key+1}}").data(constraintObject);
                                            </script>
                                            @empty
                                            <div class="priority_entry no_entry">
                                                <p>
                                                    <b>No Constraints</b>
                                                </p>
                                            </div>
                                            @endforelse
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
    <script type="text/javascript">
        $("#schedule-loading").jqs({
            mode: "read",
            hour: 12
        });
    </script>
    @if (count($schedule) > 0)
    <script type="text/javascript">
        @foreach($schedule as $key => $subject)
            @foreach($subject["sessions"] as $index=>$session)
                @foreach($session["days"] as $i => $day)
                    $("#schedule-loading").jqs('import',[
                        {
                            day: {{$day}},
                            periods: [
                                ["{{$session["start"]}}", "{{$session["end"]}}", ("{{$subject["coursename"]}}").toUpperCase()+" - "+("{{$subject["leclab"]}}").toUpperCase()+"<br />Section "+("{{$subject["section"]}}").toUpperCase()+"<br />"+("{{$subject["instructor"]}}").toUpperCase()]
                            ]
                        }
                    ]);
                @endforeach
            @endforeach
        @endforeach
    </script>
    @endif
@endsection
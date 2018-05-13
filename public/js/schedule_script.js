$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('input[name="_token"]').val()
    }
});

$(document).ready(function(){
	$(document).on("click", "#add_constraint", addConstraint);
	$(document).on("click", "#edit_constraint", editConstraint);
    $(document).on("click", "#generate_btn", generateSchedule);
    $(document).on("click", "#generate_schedule", generateSchedule);
	$(document).on("click", ".remove-constraint", removeConstraint);
	$(document).on("click", ".edit-constraint", editModalOpen);
    $(document).on("click", ".constraint-item", changeBtnName);
    $('[data-toggle="tooltip"]').tooltip();
    $(function(){
    	$('.timepicker3').datetimepicker({
    		format: 'LT',
    	});
    	$('.timepicker3').val('8:00 AM');
    });
    $('#add-end-time').on('dp.change', function(e){
    	restrictTime(e, '#add-end-time', '#add-start-time')
    });

	$('#edit-end-time').on('dp.change', function(e){
		restrictTime(e, '#edit-end-time', '#edit-start-time')
	});
});

function restrictTime(e, end_picker, pair_picker){
	// chosen time for end_time
	var end_time = timeToSeconds($(end_picker).val());
	// chosen time for start_time
	var start_time = timeToSeconds($(pair_picker).val());
	console.log("start_time: "+start_time);
	console.log("end_time: "+end_time);
	if (end_time < start_time){
		$(end_picker).val($(pair_picker).val());
	}
}
function timeToSeconds(time) {
	var mer = time.split(" ")[1];
	time = time.split(" ")[0];
    time = time.split(/:/);
    if (mer.toLowerCase() == "PM".toLowerCase() && parseInt(time[0]) < 12){
    	return (time[0] + 12) * 3600 + time[1] * 60;
    }else if (mer.toLowerCase() == "AM".toLowerCase() && parseInt(time[0]) == 12){
    	return (time[0] - 12) * 3600 + time[1] * 60;
    }
    return time[0] * 3600 + time[1] * 60;
}

function saveConstraints(){
	var constraint_entries = $(".priority_entry:not(.no_entry)");
	var constraints = [];
	$.each(constraint_entries, function(key, entry){
		var constraint_type = $(entry).data("constraint_type");
		var musthave = 0;
		var mustnothave = 0;
		var no_class = 0;
		var meeting_time = 0;
		var subject = "";
		var days = "";
		var start = "";
		var end = "";
		var priority = $(entry).data("priority")[0].toUpperCase();
		if (constraint_type == "meetingtime"){
			var toggle_text = "No Classes from "+$(entry).data("start_time")+" to "+$(entry).data("end_time")+" on "+$(entry).data("days").join(", ");
			var possible_text = $(entry).find('b').text();
			if ($(entry).data("start_time") == $(entry).data("end_time")){
				no_class = 1;
			}else if (toggle_text.toLowerCase() == possible_text.toLowerCase()){
				no_class = 1;
				start = $(entry).data("start_time");
				end = $(entry).data("end_time");
			}else{
				meeting_time = 1;
				start = $(entry).data("start_time");
				end = $(entry).data("end_time");
			}
			days = $(entry).data("days").join(" ");
		}else{
			if ($(entry).data("musthave") == "musthave"){
				musthave = 1;
				mustnothave = 0;
			}else{
				mustnothave = 1;
				musthave = 0;
			}
			subject = $(entry).data("course");
		}
		var constraint = {
			meeting_time: meeting_time,
			no_class: no_class,
			musthave: musthave,
			mustnothave: mustnothave,
			subject: subject,
			days: days,
			start: start,
			end: end,
			priority: priority,
		}
		constraints.push(constraint);
	});
	$.ajax({
		method: 'POST',
		url: '/saveconstraints',
		data: {constraints: constraints},
		dataType: 'json',
		success: function(data){
			console.log(data);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function Subject(){
	this.start_time = null;
	this.end_time = null;
	// monday is first day
	this.days = [];
	this.section = null;
	this.units = 0
	this.lecLab = null;
	this.courseName = null;
	this.instrutor = null;
	this.setDays = function(indexArray){
		this.days = indexArray;
	}

	this.setLecLab = function(value){
		this.lecLab = value;
	}

	this.setUnits = function(units){
		this.units = units;
	}

	this.setTime = function(start_time, end_time){
		this.start_time = start_time;
		this.end_time = end_time;
	}

	this.setCourseName = function(courseName){
		this.courseName = courseName;
	}

	this.setInstructor = function(instructor){
		this.instructor = instructor;
	}

	this.setSection = function(section){
		this.section = section;
	}
}

function returnIndex(day){
	var days = ["M", "T", "W", "Th", "F", "S"];
	return days.indexOf(day);
}

function convertToTime(decimalTime){
	var stringTime = "";
	var hourPart = Math.floor(decimalTime);
	var minutePart = decimalTime % 1;
	var timeOfDay = "am";
	if (hourPart - 12 >= 0){
		stringTime += (hourPart - 12);
		timeOfDay = "pm";
	}else{
		stringTime += hourPart;
		timeOfDay = "am";
	}
	if ((stringTime+"").length < 2){
		stringTime = "0"+stringTime;
	}
	stringTime += ":";
	minutePart = minutePart * 60;
	if ((minutePart+"").length < 2){
		minutePart = minutePart + "0";
	}
	stringTime += (minutePart + timeOfDay);
	return stringTime;
}

function showSchedule(){
	console.log("running show schedule");
	loadingSchedModal();
	$.ajax({
		method: 'GET',
		url: "/acquireschedule",
		processData: false,
		contentType: false,
		success: function(data){
			$("#schedule-loading").jqs("reset");
			if (data != "NONE") {
				var subjectArray = [];
				$.each(data, function(key, course){
					// course = JSON.parse(course);
					for (var i = course["sessions"].length - 1; i >= 0; i--) {
						var days = course["sessions"][i]["days"].split(" ");
						var start = course["sessions"][i]["start"];
						var end = course["sessions"][i]["end"];
						for (var i = days.length - 1; i >= 0; i--) {
							days[i] = returnIndex(days[i]);
						}
						var subject = {
							courseName: course["courseName"].toUpperCase(),
							leclab: course["leclab"],
							units: course["units"],
							section: course["section"],
							days: days,
							start_time: convertToTime(start),
							end_time: convertToTime(end),
							instructor: course["instructor"]
						}
						subjectArray.push(subject);
					}
				});
				subjObjList = [];
				for (var i = subjectArray.length - 1; i >= 0; i--) {
					subjObj = new Subject();
					subjObj.setCourseName(subjectArray[i].courseName);
					subjObj.setTime(subjectArray[i].start_time, subjectArray[i].end_time);
					subjObj.setDays(subjectArray[i].days);
					subjObj.setUnits(subjectArray[i].units);
					subjObj.setLecLab(subjectArray[i].leclab);
					subjObj.setInstructor(subjectArray[i].instructor);
					subjObj.setSection(subjectArray[i].section);
					subjObjList.push(subjObj);
				}

				for (var i = subjObjList.length - 1; i >= 0; i--) {
					subjectDays = subjObjList[i].days;
					for (var j = subjectDays.length - 1; j >= 0; j--) {
						$("#schedule-loading").jqs('import',[
							{
								day: subjectDays[j],
								periods: [
									[subjObjList[i].start_time, subjObjList[i].end_time, (subjObjList[i].courseName+" - "+subjObjList[i].lecLab).toUpperCase()]
								]
							}
						]);
					}
				}
				$("#success-modal").modal();
				$('body').loadingModal('hide');
				$('body').loadingModal('destroy');
			}
		},
		error:function(data){
			console.log(data.responseText);
			$("#error-modal").modal();
			$('body').loadingModal('hide');
			$('body').loadingModal('destroy');
		},
		complete:function(){
			clearInterval(showSchedule);
		}
	})
}

function generateSchedule(e){
	// e.preventDefault();
	if(e.target.id == "generate_btn"){
		if($(".no_entry").length == 3){
			$("#generate-warning-modal").modal("show");
			return false;
		}
	}
	calculateModal();
	$.ajax({
		method: 'POST',
		url: "/generateschedule",
		processData: false,
		contentType: false,
		success:function(data){
			var violated_constraints = data;
			var constraint_entries = $(".priority_entry:not(.no_entry)");
			for (var i = constraint_entries.length - 1; i >= 0; i--) {
				for (var j = violated_constraints.length - 1; j >= 0; j--) {
					if (violated_constraints[j]["name"].toLowerCase() == $(constraint_entries[i]).find("b").text().toLowerCase()){
						$(constraint_entries[i]).addClass("bg-danger");
					}else{
						$(constraint_entries[i]).addClass("bg-success");
					}
				}
			}
			loadingSchedModal();
			var procShowSchedule = setInterval(showSchedule(), 1000);
		},
		error:function(error){
			console.log(error.responseText);
			$('body').loadingModal('hide');
			$('body').loadingModal('destroy');
			$("#error-modal").modal();
		}
	});
}

function calculateModal(){
	$('body').loadingModal({
		position: 'auto',
		text: 'Calculating your schedule...<br />This may take a while',
		color: '#fff',
		opacity: '0.7',
		backgroundColor: 'rgb(162,162,162)',
		animation: 'circle'
	});
}

function loadingSchedModal(){
	$('body').loadingModal('animation', 'cubeGrid')
			.loadingModal('backgroundColor', 'rgb(162,162,162)')
			.loadingModal('text','Your schedule is now generated.<br/>Please wait while your schedule is being loaded.');
}

function hideEditModal(){
	console.log("at hide edit modal");
	$("#edit_tabs > li").removeClass("active");
	$("#editcourserestriction").removeClass("active");
	$("#editcourserestriction").removeClass("in");
	$("#editmeetingtime").removeClass("active");
	$("#editmeetingtime").removeClass("in");
	$("#edit_tabs > li[data-tab=editcourserestriction]").addClass("active");
	$("#editcourserestriction").addClass("active");
	$("#editcourserestriction").addClass("in");
	$("input:checkbox[name=days]").prop("checked", false);
	$("input:radio[name=edit_priority]").prop("checked", false);
	$("input:checkbox[name=edit-no-class-toggle]").prop("checked", false);
}

function changeBtnName(){
	var text = $(this).text()
	var data_text = text.toLowerCase();
	data_text = data_text.replace(" ", "");
	if($(this).hasClass("add-constraint-item")){
		$(".add-constraint-btn").html(text+" <span class='caret'></span>");
		$(".add-constraint-btn").attr("data-constraint", data_text);
	}else{
		$(".edit-constraint-btn").html(text+" <span class='caret'></span>");
		$(".edit-constraint-btn").attr("data-constraint", data_text);
	}
}

function editModalOpen(){
	var constraint_type = $(this).parent().parent().data("constraint_type");
	var priority = $(this).parent().parent().data("priority");
	var musthave = $(this).parent().parent().data("musthave");
	var course = $(this).parent().parent().data("course");
	var start_time = $(this).parent().parent().data("start_time");
	var end_time = $(this).parent().parent().data("end_time");
	var days = $(this).parent().parent().data("days");
	$("#edit_constraint").attr("data-constraint", $(this).parent().parent().data("id"));
	$("#edit_constraint").attr("data-prev-priority", priority);
	if(constraint_type == "meetingtime"){
		// close course restriction tab
		$("#edit_tabs > li[data-tab=editcourserestriction]").removeClass("active");
		$("#editcourserestriction").removeClass("active");
		$("#editcourserestriction").removeClass("in");
		// open meeting time tab
		$("#edit_tabs > li[data-tab=edit"+constraint_type+"]").addClass("active");
		$("#edit"+constraint_type).addClass("active");
		$("#edit"+constraint_type).addClass("in");
		$("#edit-start-time").val(start_time);
		$("#edit-end-time").val(end_time);
		var toggle_text = "No Classes from "+start_time+" to "+end_time+" on "+days.join(", ");
		var to_edit_text = $(this).parent().parent().find('b').text();
		if ((start_time != end_time) && (toggle_text.toLowerCase() == to_edit_text.toLowerCase())){
			$("input:checkbox[name=edit-no-class-toggle]").prop("checked", true);
		}
		$("#editmeetingtime input:checkbox[name=days]").each(function(){
			for (var i = days.length - 1; i >= 0; i--) {
				if(days[i] == $(this).val()){
					$(this).prop("checked", true);
				}
			}
		});
	}else{
		var constraint_btn_html = "Must Not Have";
		if(musthave == "musthave"){
			constraint_btn_html = "Must Have";
		}
		$(".edit-constraint-btn").html(constraint_btn_html+" <span class='caret'></span>");
		$(".edit-constraint-btn").attr("data-constraint", musthave);
		$("input[name=edit_course]").val(course);
	}
	$("#radio_"+priority).prop("checked", true);
}

function editConstraint(e){
	console.log("at edit constraint");
	e.preventDefault();
	var text = "";
	var musthave = "";
	var start_time = "";
	var end_time = "";
	var course = $("#editcourserestriction > div > input:text[name=edit_course]").val();
	if($("#edit_tabs > .active").attr("data-tab") == "editcourserestriction"){
		constraint_type = "courserestriction";
		text = "Must Not Have"
		musthave = $(".edit-constraint-btn").attr("data-constraint");
		if(musthave == "musthave"){
			text = "Must Have";
		}
		text += (" "+$("#editcourserestriction > div > input:text[name=edit_course]").val());
	}else{
		constraint_type = "meetingtime";
		start_time = $("#edit-start-time").val();
		end_time = $("#edit-end-time").val();
		text = "Classes must start from "+start_time+" to "+end_time;
		if(start_time == end_time){
			text = "No Classes";
		}else if (start_time != end_time && ($('input:checkbox[name=edit-no-class-toggle]:checked').length > 0)){
			text = "No Classes from "+start_time+" to "+end_time;
		}
		var selected = [];
		$("#editmeetingtime > div > label > input:checkbox[name=days]:checked").each(function(){
			selected.push($(this).val());
		});
		if(selected.length){
			text += " on ";
			for (var i = 0; i < selected.length; i++) {
				text += selected[i];
				if(i != selected.length-1){
					text += ", ";
				}
			}
		}
	}
	constraintObject = {
		id: $("#edit_constraint").attr("data-constraint"),
		constraint_type: constraint_type,
		priority: $(".priority_options > p > label > input[name=edit_priority]:checked").val(),
		musthave: musthave,
		start_time: start_time,
		end_time: end_time,
		course: course,
		days: selected
	};
	console.log(constraintObject);
	var priority_value = $(".priority_options > p > label > input[name=edit_priority]:checked").val();
	var prev_priority = $("#edit_constraint").attr("data-prev-priority");
	var div_id = $("#edit_constraint").attr("data-constraint");
	$("#"+div_id).html('<p>'+
						'<b>'+text+'</b>'+
						'<a class="remove-constraint" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove pull-right"></span></a>'+
						'<a class="edit-constraint" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit pull-right"></span></a>'+
					'</p>');
	if(priority_value != prev_priority){
		console.log(priority_value+": "+prev_priority);
		new_div_id = priority_value+"_"+($("#"+priority_value+" > .panel-body > .priority_entry").length+1);
		constraintObject.id = new_div_id;
		newDiv = $("#"+div_id).remove();
		newDiv.attr("id", new_div_id);
		newDiv.data(constraintObject);
		$("#"+prev_priority+"_badge").html($("#"+prev_priority+" > .panel-body > .priority_entry").length);
		if ($("#"+priority_value+" > .panel-body > .no_entry").length){
			$("#"+priority_value+" > .panel-body").html(newDiv);
			$("#"+priority_value+"_badge").html(1);
		}else{
			$("#"+priority_value+" > .panel-body").append(newDiv);
			$("#"+priority_value+"_badge").html($("#"+priority_value+" > .panel-body > .priority_entry").length);
		}

		if($("#"+prev_priority+" > .panel-body > .priority_entry").length == 0){
			$("#"+prev_priority+" > .panel-body").html(
					'<div class="priority_entry no_entry">'+
						'<p>'+
							'<b>No Constraints</b>'+
						'</p>'+
					'</div>'
				);
		}

		$("#"+priority_value).addClass("in");
	}else{
		$("#"+div_id).data(constraintObject);
	}
	saveConstraints();
	hideEditModal();
}

function addConstraint(e){
	e.preventDefault();
	var text = "";
	var constraint_type = 0;
	var musthave = "";
	var start_time = "";
	var end_time = "";
	if($("#add_tabs > .active").attr("data-tab") == "addcourserestriction"){
		constraint_type = "courserestriction";
		text = "Must Not Have"
		musthave = $(".add-constraint-btn").attr("data-constraint");
		if(musthave == "musthave"){
			text = "Must Have";
		}
		text += (" "+$("#addcourserestriction > div > input:text[name=course]").val());
	}else{
		constraint_type = "meetingtime"
		start_time = $("#add-start-time").val();
		end_time = $("#add-end-time").val();
		text = "Classes must start from "+start_time+" to "+end_time;
		if (start_time == end_time){
			text = "No Classes";
		}else if (start_time != end_time && ($('input:checkbox[name=add-no-class-toggle]:checked').length > 0)){
			text = "No Classes from "+start_time+" to "+end_time;
		}
		var selected = [];
		$("#addmeetingtime > div > label > input:checkbox[name=days]:checked").each(function(){
			selected.push($(this).val());
		});
		if(selected.length){
			text += " on ";
			for (var i = 0; i < selected.length; i++) {
				text += selected[i];
				if(i != selected.length-1){
					text += ", ";
				}
			}
		}
	}
	var priority_value = "#"+$("input:radio[name=add_priority]:checked").val();
	var constraint_num = ($(priority_value+" > .panel-body > .priority_entry").length)+1;
	if($(priority_value+" > .panel-body > .no_entry").length){
		constraint_num = 1;
	}
	constraintObject = {
		id: $("input:radio[name=add_priority]:checked").val()+"_"+(constraint_num),
		constraint_type: constraint_type,
		priority: $("input:radio[name=add_priority]:checked").val(),
		musthave: musthave,
		start_time: start_time,
		end_time: end_time,
		course: $("#addcourserestriction > div > input:text[name=course]").val(),
		days: selected
	};
	var newDiv = '<div class="priority_entry" id="'+$("input:radio[name=add_priority]:checked").val()+'_'+(constraint_num)+'">'+
					'<p>'+
						'<b>'+text+'</b>'+
						'<a class="remove-constraint" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove pull-right"></span></a>'+
						'<a class="edit-constraint" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit pull-right"></span></a>'+
					'</p>'+
				'</div>';
	if ($(priority_value+" > .panel-body > .no_entry").length){
		$(priority_value+" > .panel-body").html(newDiv);
		$(priority_value+"_badge").html(1);
	}else{
		$(priority_value+" > .panel-body").append(newDiv);
		$(priority_value+"_badge").html($(priority_value+" > .panel-body > .priority_entry").length);
	}
	$(priority_value+" > .panel-body > .priority_entry:last-child").data(constraintObject);
	$(priority_value).addClass("in");
	addConstraintReset();
}

function addConstraintReset(){
	$(".add-constraint-btn").html("Must Not Have <span class='caret'></span>");
	$("input:radio[name=add_priority]").removeAttr("checked");
	$("#addmeetingtime > div > label > input:checkbox[name=days]").removeAttr("checked");
	$("#addcourserestriction > div > input:text[name=course]").val("");
	$("#add-start-time").val("");
	$("#add-end-time").val("");
	$("#add_tabs > li[data-tab=addmeetingtime]").removeClass("active");
	$("#addmeetingtime").removeClass("active");
	$("#addmeetingtime").removeClass("in");
	if(!$("#add_tabs > li[data-tab=addcourserestriction]").hasClass("active")){
		$("#add_tabs > li[data-tab=addcourserestriction]").addClass("active");
		$("#addcourserestriction").addClass("active");
		$("#addcourserestriction").addClass("in");
	}
	$("#addconstraint").modal('hide');
	$('body').removeClass('modal-open');
	$('.modal-backdrop').remove();
	$('.timepicker3').val('8:00 AM');
	saveConstraints();
}

function removeConstraint(){
	var priority = $(this).parent().parent().parent().parent()[0].id;
	$(this).closest(".priority_entry").remove();
	$("#"+priority+"_badge").html($("#"+priority+" > .panel-body > .priority_entry").length);
	if($("#"+priority+" > .panel-body > .priority_entry").length == 0){
		$("#"+priority+" > .panel-body").html(
				'<div class="priority_entry no_entry">'+
					'<p>'+
						'<b>No Constraints</b>'+
					'</p>'+
				'</div>'
			);
	}
	saveConstraints();
}
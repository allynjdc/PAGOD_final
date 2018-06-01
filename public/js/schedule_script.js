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
		$("#add-success-modal").on('show.bs.modal', function(){
			var myModal = $(this);
			clearTimeout(myModal.data('hideInterval'));
			myModal.data('hideInterval', setTimeout(function(){
				myModal.modal('hide');
			}, 1500));
		});
	});
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
    $(function(){
    	$('.timepicker3').datetimepicker({
    		format: 'LT',
    	});
    	$('.timepicker3').val('8:00 AM');
    	$('.endtimepicker').val('9:00 AM');
    });
    $('#add-end-time').on('dp.change', function(e){
    	restrictTime(e, '#add-end-time', '#add-start-time')
    });
	$('#edit-end-time').on('dp.change', function(e){
		restrictTime(e, '#edit-end-time', '#edit-start-time')
	});
	var radio_buttons = $("input[name=add_priority]");
	for (var i = radio_buttons.length - 1; i >= 0; i--) {
		radio_buttons[i].onclick = function(){
			$('#add_constraint').prop('disabled', false);
		}
	}
	$("#add_meetingtime_type").on("change", chooseConstraint);
	$("#edit_meetingtime_type").on("change", editChooseConstraint);
	$(".edit_modal_close").on("click", hideEditModal);
});

function restrictTime(e, end_picker, pair_picker){
	// chosen time for end_time
	var end_time = timeToSeconds($(end_picker).val());
	// chosen time for start_time
	var start_time = timeToSeconds($(pair_picker).val());
	console.log("start_time: "+start_time);
	console.log("end_time: "+end_time);
	if (end_time <= start_time){
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
		var instructor = "";
		var maxdaily = 0;
		var maxstraight = 0;
		var maxnum = 0;
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
		}else if (constraint_type == "courserestriction"){
			if ($(entry).data("musthave") == "musthave"){
				musthave = 1;
				mustnothave = 0;
			}else{
				mustnothave = 1;
				musthave = 0;
			}
			subject = $(entry).data("course");
		}else if (constraint_type == "prefinstructor"){
			instructor = $(entry).data("instructor");
		}else if (constraint_type == "maxstraight"){
			maxstraight = 1;
			maxnum = $(entry).data("maxnum");
		}else if (constraint_type == "maxdaily"){
			maxdaily = 1;
			maxnum = $(entry).data("maxnum");
		}
		var constraint = {
			meeting_time: meeting_time,
			no_class: no_class,
			musthave: musthave,
			mustnothave: mustnothave,
			maxstraight: maxstraight,
			maxdaily: maxdaily,
			subject: subject,
			days: days,
			start: start,
			end: end,
			instructor: instructor,
			maxnum: maxnum,
			priority: priority,
		}
		constraints.push(constraint);
	});
	if (constraints.length == 0 ){
		constraints = [""]
	}
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
	$.ajax({
		method: 'GET',
		url: "/acquireschedule",
		processData: false,
		contentType: false,
		success: function(data){
			console.log(data);
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
									[subjObjList[i].start_time, subjObjList[i].end_time, (subjObjList[i].courseName+" - "+subjObjList[i].lecLab).toUpperCase()+"<br />Section "+subjObjList[i].section]
								]
							}
						]);
					}
				}
				$("#success-modal").modal();
				$('body').loadingModal('hide');
				$('body').loadingModal('destroy');
				for(i=0; i<10000; i++)
			    {
			        window.clearInterval(i);
			    }
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
		timeout: 0,
		success:function(data){
			console.log(data);
			var procShowSchedule = setInterval(showSchedule, 10000);
			var procRetrieveViolated = setInterval(showViolated, 10000);
			loadingSchedModal();
		},
		error:function(a,b,c){
			console.log(a);
			console.log(b);
			console.log(c);
			$('body').loadingModal('hide');
			$('body').loadingModal('destroy');
			$("#error-modal").modal();
			for(i=0; i<10000; i++)
		    {
		        window.clearInterval(i);
		    }
		},
		complete:function(){
		},
	});
}

function showViolated(){
	console.log("running show violated");
	$.ajax({
		method: 'GET',
		url: "/acquireviolated",
		processData: false,
		contentType: false,
		success: function(data){
			console.log(data);
			if(data!="NONE"){
				var violated_constraints = data;
				var constraint_entries = $(".priority_entry:not(.no_entry)");
				var preferred_entries = $(".preferred_entry:not(.no_entry)");
				$(constraint_entries).removeClass("bg-danger");
				$(constraint_entries).removeClass("bg-success");
				if (violated_constraints.length){
					for (var i = constraint_entries.length - 1; i >= 0; i--) {
						for (var j = violated_constraints.length - 1; j >= 0; j--) {
							if (violated_constraints[j].toLowerCase() == $(constraint_entries[i]).find("b").text().toLowerCase()){
								$(constraint_entries[i]).addClass("bg-danger");
							}else{
								$(constraint_entries[i]).addClass("bg-success");
							}
						}
					}
					for (var i = preferred_entries.length - 1; i >= 0; i--) {
						for (var j = violated_constraints.length - 1; j >= 0; j--){
							if (violated_constraints[j].toLowerCase() == $(preferred_entries[i]).find("b").text().toLowerCase()){
								$(preferred_entries[i]).addClass("bg-danger");
							}else{
								$(preferred_entries[i]).addClass("bg-success");
							}
						}
					}
				}else{
					$(constraint_entries).addClass("bg-success");
				}
				for(i=0; i<10000; i++)
			    {
			        window.clearInterval(i);
			    }
			}
		},
		error: function(data){
			console.log(data);
			for(i=0; i<10000; i++)
		    {
		        window.clearInterval(i);
		    }
		},
		complete:function(){
			clearInterval(showViolated);
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
	$("#editprefinstructor").removeClass("active");
	$("#editprefinstructor").removeClass("in");
	$("#editmaxstraight").removeClass("active");
	$("#editmaxstraight").removeClass("in");
	$("#editmaxdaily").removeClass("active");
	$("#editmaxdaily").removeClass("in");
	$("#edit_tabs > li[data-tab=editcourserestriction]").addClass("active");
	$("#editcourserestriction").addClass("active");
	$("#editcourserestriction").addClass("in");
	$("input:checkbox[name=days]").prop("checked", false);
	$("input:radio[name=edit_priority]").prop("checked", false);
	// $("#edit_meetingtime_type option").prop("selected", false);
	// $("#edit_meetingtime_type :first-child").prop("selected", true);
	$("#edit-max-num").val("1");
	$("#edit-straight-num").val("1");
	$("#edit-pref-input option").removeAttr("selected");
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
	var instructor = $(this).parent().parent().data("instructor");
	var maxnum = $(this).parent().parent().data("maxnum");
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
		$("#edit_meetingtime_type option").prop("selected", false);
		console.log(start_time+" "+end_time);
		if (days.length == 5){
			if (toggle_text.toLowerCase() == to_edit_text.toLowerCase()){
				$("#edit_meetingtime_type option[value='2']").prop("selected", true);
				$(".edit_time_div").css("display", "block");
				$(".edit-checkbox-days").css("display", "none");
			}else{
				$("#edit_meetingtime_type option[value='4']").prop("selected", true);
				$(".edit_time_div").css("display", "block");
				$(".edit-checkbox-days").css("display", "none");
			}
		}
		else{
			if(toggle_text.toLowerCase() == to_edit_text.toLowerCase()){
				$("#edit_meetingtime_type option[value='3']").prop("selected", true);
				$(".edit_time_div").css("display", "block");
				$(".edit-checkbox-days").css("display", "block");
			}
			else if (start_time == end_time){
				$("#edit_meetingtime_type option[value='1']").prop("selected", true);
				$(".edit_time_div").css("display", "none");
				$(".edit-checkbox-days").css("display", "block");
			}else{
				$("#edit_meetingtime_type option[value='5']").prop("selected", true);
				$(".edit_time_div").css("display", "block");
				$(".edit-checkbox-days").css("display", "block");
			}
		}
		$("#editmeetingtime input:checkbox[name=days]").each(function(){
			for (var i = days.length - 1; i >= 0; i--) {
				if(days[i] == $(this).val()){
					$(this).prop("checked", true);
				}
			}
		});
	}else if(constraint_type == "prefinstructor"){
		$("#edit_tabs > li[data-tab=editcourserestriction]").removeClass("active");
		$("#editcourserestriction").removeClass("active");
		$("#editcourserestriction").removeClass("in");
		$("#edit_tabs > li[data-tab=edit"+constraint_type+"]").addClass("active");
		$("#edit"+constraint_type).addClass("active");
		$("#edit"+constraint_type).addClass("in");
		$("#edit-pref-input option").prop("selected", false);
		$("#edit-pref-input option[value='"+instructor+"']").prop("selected", true);
		console.log($("#edit-pref-input option:selected").val());
	}else if(constraint_type == "maxstraight"){
		$("#edit_tabs > li[data-tab=editcourserestriction]").removeClass("active");
		$("#editcourserestriction").removeClass("active");
		$("#editcourserestriction").removeClass("in");
		$("#edit_tabs > li[data-tab=edit"+constraint_type+"]").addClass("active");
		$("#edit"+constraint_type).addClass("active");
		$("#edit"+constraint_type).addClass("in");
		$("#edit-straight-num").val(maxnum);
	}else if(constraint_type == "maxdaily"){
		$("#edit_tabs > li[data-tab=editcourserestriction]").removeClass("active");
		$("#editcourserestriction").removeClass("active");
		$("#editcourserestriction").removeClass("in");
		$("#edit_tabs > li[data-tab=edit"+constraint_type+"]").addClass("active");
		$("#edit"+constraint_type).addClass("active");
		$("#edit"+constraint_type).addClass("in");
		$("#edit-max-num").val(maxnum);
	}else if(constraint_type == "courserestriction"){
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
	var instructor = "";
	var maxnum = 0;
	if($("#edit_tabs > .active").attr("data-tab") == "editcourserestriction"){
		constraint_type = "courserestriction";
		text = "Must Not Have"
		musthave = $(".edit-constraint-btn").attr("data-constraint");
		if(musthave == "musthave"){
			text = "Must Have";
		}
		text += (" "+$("#editcourserestriction > div > input:text[name=edit_course]").val());
	}else if ($("#edit_tabs > .active").attr("data-tab") == "editmeetingtime"){
		constraint_type = "meetingtime";
		start_time = $("#edit-start-time").val();
		end_time = $("#edit-end-time").val();
		text = "Classes must start from "+start_time+" to "+end_time;
		if(start_time == end_time){
			text = "No Classes";
		}else if (start_time != end_time && ($("#edit_meetingtime_type").val() == 3 || $("#edit_meetingtime_type").val() == 2)){
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
	}else if ($("#edit_tabs > .active").attr("data-tab") == "editprefinstructor"){
		constraint_type = "prefinstructor";
		text = "Preferred instructor is ";
		instructor = $("#edit-pref-input").val();
		text += instructor;
	}else if ($("#edit_tabs > .active").attr("data-tab") == "editmaxstraight"){
		constraint_type = "maxstraight";
		text = "Maximum Number of Straight Classes must be ";
		maxnum = $("#edit-straight-num").val();
		text += maxnum;
	}else if ($("#edit_tabs > .active").attr("data-tab") == "editmaxdaily"){
		constraint_type = "maxdaily";
		text = "Maximum Number of Daily Classes must be ";
		maxnum = $("#edit-max-num").val();
		text += maxnum;
	}
	constraintObject = {
		id: $("#edit_constraint").attr("data-constraint"),
		constraint_type: constraint_type,
		priority: $(".priority_options > p > label > input[name=edit_priority]:checked").val(),
		musthave: musthave,
		start_time: start_time,
		end_time: end_time,
		course: course,
		instructor: instructor,
		days: selected,
		maxnum: maxnum
	};
	var priority_value = $(".priority_options > p > label > input[name=edit_priority]:checked").val();
	var prev_priority = $("#edit_constraint").attr("data-prev-priority");
	var div_id = $("#edit_constraint").attr("data-constraint");
	$("#"+div_id).removeClass("bg-success");
	$("#"+div_id).removeClass("bg-danger");
	$("#"+div_id).html('<p>'+
						'<a class="edit-constraint pull-left" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit"></span></a>'+
						'<a class="remove-constraint pull-left" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove"></span></a>'+
						'<b>'+text+'</b>'+
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
	var priority_value = "#"+$("input:radio[name=add_priority]:checked").val();
	var instructor = "";
	var maxnum = 0;
	if($("#add_tabs > .active").attr("data-tab") == "addcourserestriction"){
		constraint_type = "courserestriction";
		text = "Must Not Have"
		musthave = $(".add-constraint-btn").attr("data-constraint");
		if(musthave == "musthave"){
			text = "Must Have";
		}
		text += (" "+$("#addcourserestriction > div > input:text[name=course]").val());
	}else if($("#add_tabs > .active").attr("data-tab") == "addmeetingtime"){
		var meeting_type = $("#add_meetingtime_type").val();
		constraint_type = "meetingtime";
		start_time = $("#add-start-time").val();
		end_time = $("#add-end-time").val();
		text = "Classes must start from "+start_time+" to "+end_time;
		if (meeting_type == 1){
			text = "No Classes";
			start_time = "8:00 AM";
			end_time = "8:00 AM";
		}else if (meeting_type == 2 || meeting_type == 3){
			text = "No Classes from "+start_time+" to "+end_time;
		}
		var selected = ["M", "T", "W", "Th", "F"];
		if (meeting_type == 1 || meeting_type == 3 || meeting_type == 5){
			selected = [];
			$("#addmeetingtime > div > label > input:checkbox[name=days]:checked").each(function(){
				selected.push($(this).val());
			});
		}
		if(selected.length){
			text += " on ";
			for (var i = 0; i < selected.length; i++) {
				text += selected[i];
				if(i != selected.length-1){
					text += ", ";
				}
			}
		}
	}else if($("#add_tabs > .active").attr("data-tab") == "addprefinstructor"){
		constraint_type = "prefinstructor";
		text = "Preferred instructor is ";
		instructor = $("#add-pref-input").val();
		text += instructor;
	}else if($("#add_tabs > .active").attr("data-tab") == "addmaxstraight"){
		constraint_type = "maxstraight";
		text = "Maximum Number of Straight Classes must be ";
		maxnum = $("#add-straight-num").val();
		text += maxnum;
	}else if($("#add_tabs > .active").attr("data-tab") == "addmaxdaily"){
		constraint_type = "maxdaily";
		text = "Maximum Number of Daily Classes must be ";
		maxnum = $("#add-max-num").val();
		text += maxnum;
	}
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
		instructor: instructor,
		days: selected,
		maxnum: maxnum
	};
	var newDiv = '<div class="priority_entry" id="'+$("input:radio[name=add_priority]:checked").val()+'_'+(constraint_num)+'">'+
					'<p>'+
						'<a class="edit-constraint pull-left" data-toggle="modal" href="#editconstraint"><span class="glyphicon glyphicon-edit"></span></a>'+
						'<a class="remove-constraint pull-left" data-toggle="modal"  href="#remove" ><span class="glyphicon glyphicon-remove"></span></a>'+
						'<b>'+text+'</b>'+
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

function chooseConstraint(){
	var meeting_type = $("#add_meetingtime_type").val();
	if(meeting_type == 1){
		$(".time_div").css("display", "none");
		$(".checkbox-days").css("display", "block");
	}else if (meeting_type == 2){
		$(".time_div").css("display", "block");
		$(".checkbox-days").css("display", "none");
	}else if (meeting_type == 3){
		$(".time_div").css("display", "block");
		$(".checkbox-days").css("display", "block");
	}else if (meeting_type == 4){
		$(".time_div").css("display", "block");
		$(".checkbox-days").css("display", "none");
	}else if (meeting_type == 5){
		$(".time_div").css("display", "block");
		$(".checkbox-days").css("display", "block");
	}
}

function editChooseConstraint(){
	var meeting_type = $("#edit_meetingtime_type").val();
	if(meeting_type == 1){
		$(".edit_time_div").css("display", "none");
		$(".edit-checkbox-days").css("display", "block");
	}else if (meeting_type == 2){
		$(".edit_time_div").css("display", "block");
		$(".edit-checkbox-days").css("display", "none");
	}else if (meeting_type == 3){
		$(".edit_time_div").css("display", "block");
		$(".edit-checkbox-days").css("display", "block");
	}else if (meeting_type == 4){
		$(".edit_time_div").css("display", "block");
		$(".edit-checkbox-days").css("display", "none");
	}else if (meeting_type == 5){
		$(".edit_time_div").css("display", "block");
		$(".edit-checkbox-days").css("display", "block");
	}
}

function addConstraintReset(){
	$(".add-constraint-btn").html("Must Not Have <span class='caret'></span>");
	$("input:radio[name=add_priority]").removeAttr("checked");
	$("#addmeetingtime > div > label > input:checkbox[name=days]").removeAttr("checked");
	$("#addcourserestriction > div > input:text[name=course]").val("");
	$("#add-start-time").val("");
	$("#add-end-time").val("");
	$("#add-straight-num").val("1");
	$("#add-max-num").val("1");
	$("#add_tabs > li[data-tab=addmeetingtime]").removeClass("active");
	$("#addmeetingtime").removeClass("active");
	$("#addmeetingtime").removeClass("in");
	$("#add_tabs > li[data-tab=addprefinstructor]").removeClass("active");
	$("#addprefinstructor").removeClass("active");
	$("#addprefinstructor").removeClass("in");
	$("#add_tabs > li[data-tab=addmaxstraight]").removeClass("active");
	$("#addmaxstraight").removeClass("active");
	$("#addmaxstraight").removeClass("in");
	$("#add_tabs > li[data-tab=addmaxdaily]").removeClass("active");
	$("#addmaxdaily").removeClass("active");
	$("#addmaxdaily").removeClass("in");
	if(!$("#add_tabs > li[data-tab=addcourserestriction]").hasClass("active")){
		$("#add_tabs > li[data-tab=addcourserestriction]").addClass("active");
		$("#addcourserestriction").addClass("active");
		$("#addcourserestriction").addClass("in");
	}
	// $("#addconstraint").modal('hide');
	// $('body').removeClass('modal-open');
	// $('.modal-backdrop').remove();
	$("#add-success-modal").modal('show');
	$('.timepicker3').val('8:00 AM');
	$('.endtimepicker').val('9:00 AM');
	$('#add_constraint').prop('disabled', true);
	$("#add_meetingtime_type option").removeAttr("selected");
	$("#add_meetingtime_type option[value=1]").attr("selected", true);
	$(".time_div").css("display", "none");
	$(".checkbox-days").css("display", "block");
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
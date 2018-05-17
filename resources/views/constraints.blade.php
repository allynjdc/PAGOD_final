
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

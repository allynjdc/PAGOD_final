@extends('layouts.studinfo')

@section('studinfo')
<!-- TIME TABLE PANEL -->
    <div class="col-md-8">
        <div class="panel panel-default panel-shadow">
            <div class="panel-body">
                <div id="schedule-loading"></div>
            </div> <!-- END PANEL-BODY -->
        </div> <!-- END PANEL -->
    </div> <!-- END COL -->
<!-- END ROW -->

<script type="text/javascript">
        $("#schedule-loading").jqs({
            mode: "read",
            hour: 12,
            data: [
                {
                    "day": 0,
                    "periods":[
                        ["9am","10am", "CMSC 198.1 - Lec"],
                        ["10am", "11:30am", "CMSC 142 - Lec"],
                        ["11:30am", "12:30pm", "CMSC 192 - Lec"],
                        ["1pm", "2pm", "CMSC 137 - Lec"]
                    ]
                },
                {
                    "day": 1,
                    "periods":[
                        ["9am","10am", "CMSC 162 - Lec"],
                        ["1pm", "2:30pm", "CMSC 151 - Lec"],
                        ["2:30pm", "4pm", "Lit 1 - Lec"]
                    ]
                },
                {
                    "day": 2,
                    "periods":[
                        ["8am", "11am", "CMSC 137 - Lab"],
                        ["2pm", "5pm", "CMSC162 - Lab"]
                    ]
                },
                {
                    "day": 3,
                    "periods":[
                        ["9am","10am", "CMSC 198.1 - Lec"],
                        ["10am", "11:30am", "CMSC 142 - Lec"],
                        ["11:30am", "12:30pm", "CMSC 192 - Lec"],
                        ["1pm", "2pm", "CMSC 137 - Lec"]
                    ]
                },
                {
                    "day": 4,
                    "periods":[
                        ["9am","10am", "CMSC 162 - Lec"],
                        ["1pm", "2:30pm", "CMSC 151 - Lec"],
                        ["2:30pm", "4pm", "Lit 1 - Lec"]
                    ]
                }
            ]
        });
    </script>
@endsection

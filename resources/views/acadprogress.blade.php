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
								Major Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:77%">
				      			<span class="sr-only">17 / 22 Major Courses</span>
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
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>CMSC 11</td>
									        <td>Introduction to Computer Science</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 21</td>
									        <td>Fundamentals of Programming</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 56</td>
									        <td>Discrete Mathematical Structures in Computer Science 1</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 22</td>
									        <td>Fundamentals of Object-oriented Programming</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 57</td>
									        <td>Discrete Mathematical Structures in Computer Science 2</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 123</td>
									        <td>Data Structures</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 130</td>
									        <td>Logic Design &amp; Digital Computer Circuits</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 127</td>
									        <td>File Processing &amp; Database Systems</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 128</td>
									        <td>Software Engineering 1</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 131</td>
									        <td>Introduction to Computer Organization &amp; Machine Level Programming</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 141</td>
									        <td>Automata &amp; Language Theory</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 124</td>
									        <td>Design and Implementation of Programming Languages</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 125</td>
									        <td>Operating Systems</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 126</td>
									        <td>Web Engineering</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 129</td>
									        <td>Software Engineering 2</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 132</td>
									        <td>Computer Architecture</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 195</td>
									        <td>Practicum</td>
									        <td>3.0</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END MAJOR COURSES -->

				<!-- REQUIRED COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#required">
								Required Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:89%">
				      			<span class="sr-only">8 / 9 Required Courses</span>
				    		</div>
				  		</div>
					</div>
					<div id="required" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Math 17</td>
									        <td>College Algebra</td>
									        <td>5.0</td>
		  								</tr>
		  								<tr>
									        <td>Math 100</td>
									        <td>Introduction to Calculus</td>
									        <td>4.0</td>
		  								</tr>
		  								<tr>
									        <td>Physics 51</td>
									        <td>General Physics 1</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Physics 51.1</td>
									        <td>General Physics 1 Laboratory</td>
									        <td>1.0</td>
		  								</tr>
		  								<tr>
									        <td>Physics 52</td>
									        <td>General Physics 2</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Physics 52.1</td>
									        <td>General Physics 2 Laboratory</td>
									        <td>1.0</td>
		  								</tr>
		  								<tr>
									        <td>Stat 105</td>
									        <td>Introduction to Statistical Analysis </td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Eng 10</td>
									        <td>Writing of Scientific Papers</td>
									        <td>3.0</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END REQUIRED COURSES -->

				<!-- ELECTIVE COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#elec">
								Elective Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:33%">
				      			<span class="sr-only">2 / 6 Elective Courses</span>
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
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>CMSC 151</td>
									        <td>System Analysis and Design</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>CMSC 162</td>
									        <td>3D Animation</td>
									        <td>3.0</td>
		  								</tr>
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
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:80%">
				      			<span class="sr-only">4 / 5 GE(AH)</span>
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
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Eng 2</td>
									        <td>Read Right, Write Right</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Comm 1</td>
									        <td>Communication Skills</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Comm 2</td>
									        <td>Communication Skills 2</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Hum 1</td>
									        <td>Art, Society, and the Individual</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Lit 1</td>
									        <td>Literatures of the Philippines</td>
									        <td>3.0</td>
		  								</tr>
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
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				      			<span class="sr-only">4 / 4 Complete</span>
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
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Aqua Sci 1</td>
									        <td>Fish Make Sense</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Aqua Sci 16</td>
									        <td>Fish Beyond Capture</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Bio20</td>
									        <td>Living with Microbes in Sickness and in Health</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Bio 1</td>
									        <td>Understanding Life</td>
									        <td>3.0</td>
		  								</tr>
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
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				      			<span class="sr-only">5 / 5 Complete</span>
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
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>Philo 1</td>
									        <td>Phylosophical Analysis</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Hist 1</td>
									        <td>Philippine History</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Soc Sci 5</td>
									        <td>Understanding Gender</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Soc Sci 2</td>
									        <td>Social, Economic, and Political Thought</td>
									        <td>3.0</td>
		  								</tr>
		  								<tr>
									        <td>Soc Sci 26</td>
									        <td>People, Places, and Spaces in a Changing World</td>
									        <td>3.0</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END GE(SSP) COURSES -->

				<!-- PE COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#pe">
								PE Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				      			<span class="sr-only">4 / 4 Complete</span>
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
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>PE 1</td>
									        <td>Foundations of Physical Fitness</td>
									        <td>(2.0)</td>
		  								</tr>
		  								<tr>
									        <td>PE 2</td>
									        <td>Badminton</td>
									        <td>(2.0)</td>
		  								</tr>
		  								<tr>
									        <td>PE 2</td>
									        <td>Table Tennis</td>
									        <td>(2.0)</td>
		  								</tr>
		  								<tr>
									        <td>PE 3</td>
									        <td>Camping</td>
									        <td>(2.0)</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END PE COURSES -->

				<!-- NSTP COURSES -->
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h4>
							<a class="anchor_color" data-toggle="collapse" href="#nstp">
								NSTP Courses
							</a>
						</h4>
						<div class="progress">
				    		<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				      			<span class="sr-only">2 / 2 Complete</span>
				    		</div>
				  		</div>
					</div>
					<div id="nstp" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
		  								<tr>
		    								<th>COURSE</th>
		    								<th>TITLE</th>
		    								<th>UNIT</th>
		  								</tr>
									</thead>
									<tbody>
		  								<tr>
									        <td>NSTP 1</td>
									        <td>CWTS</td>
									        <td>(3.0)</td>
		  								</tr>
		  								<tr>
									        <td>NSTP 2</td>
									        <td>CWTS</td>
									        <td>(3.0)</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
						</div>									
					</div>						  		
				</div>
				<!-- END NSTP COURSES -->

			</div>
		</div>
	</div>
	<!-- END PROGRESS PANEL -->
</div>
<!-- End Column md 8 -->
@endsection
<?php
$F_NAME=$COMPANY_DATA['f_name'];
$L_NAME=$COMPANY_DATA['l_name'];
 $fname=$F_NAME[0];
 $lname=$L_NAME[0];
 ?>



<div class="wrapper">
		<!--sidebar-wrapper-->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div class="">
					<img src="../img/logo/logo_white.png" class="logo-icon-2" alt="" />
				</div>
				<div>
					<h4 class="logo-text">Project Wize</h4>
				</div>
				<a href="javascript:;" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
				</a>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="dashboard">
						<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li>
					<a href="companydetails">
						<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
						</div>
						<div class="menu-title">Company Details</div>
					</a>
				</li>
				<li>
					<a class="has-arrow" href="#">
						<div class="parent-icon icon-color-10"><i class="bx bx-spa"></i>
						</div>
						<div class="menu-title">Project Managers</div>
					</a>
					<ul>
						<li> <a href="projectmanager?token=3"><i class="bx bx-right-arrow-alt"></i>All</a>
						</li>
						<li> <a href="projectmanager?token=2"><i class="bx bx-right-arrow-alt"></i>Blocked</a>
						</li>
						<li> <a href="projectmanager?token=1"><i class="bx bx-right-arrow-alt"></i>Unblocked</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="#">
						<div class="parent-icon icon-color-11"><i class="bx bx-repeat"></i>
						</div>
						<div class="menu-title">Projects</div>
					</a>
					<ul>
						<li> <a href="project?token=3"><i class="bx bx-right-arrow-alt"></i>All</a>
						</li>
						<li> <a href="project?token=4"><i class="bx bx-right-arrow-alt"></i>Completed</a>
						</li>
						<li> <a href="project?token=2"><i class="bx bx-right-arrow-alt"></i>Hold</a>
						</li>
						<li> <a href="project?token=1"><i class="bx bx-right-arrow-alt"></i>Active</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="#">
						<div class="parent-icon icon-color-11"><i class="bx bx-repeat"></i>
						</div>
						<div class="menu-title">Users</div>
					</a>
					<ul>
						<li> <a href="users?token=3"><i class="bx bx-right-arrow-alt"></i>All</a>
						</li>
						<li> <a href="users?token=2"><i class="bx bx-right-arrow-alt"></i>Blocked</a>
						</li>
						<li> <a href="users?token=1"><i class="bx bx-right-arrow-alt"></i>Unblocked</a>
						</li>
						<li> <a href="invitedusers"><i class="bx bx-right-arrow-alt"></i>Invited</a>
						</li>
					</ul>
				</li>
            <li>
					<a href="logout">
						<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
						</div>
						<div class="menu-title">Logout</div>
					</a>
				</li>
				
			</ul>
		</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   
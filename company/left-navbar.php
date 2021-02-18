<?php
$F_NAME=$COMPANY_DATA['f_name'];
$L_NAME=$COMPANY_DATA['l_name'];
 $fname=$F_NAME[0];
 $lname=$L_NAME[0];
 ?>
 
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
         <div class="user-panel">
            <div class="image">
                  <div id="imgArea" class="pull-left image"> 
                     <div class="profileImage"><?=ucfirst($FNAME[0]).ucfirst($LNAME[0])?></div>
                  </div>
            </div>
            <div class="pull-left info">
               <p style="margin-left: 5px; margin-top: 7px;">Company Admin</p>
               <p style="margin-left: 5px;"><?=ucfirst($COMPANY_DATA['f_name']);?> <?=ucfirst($COMPANY_DATA['l_name']);?></p>
            </div>
         </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
         <li class="header">MAIN NAVIGATION</li>
         <li>
            <a href="dashboard">
               <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
         </li>
         
         <li>
            <a href="companydetails">
               <i class="fa fa-dashboard"></i> <span>Company Details</span>
            </a>
         </li>

         <li class="treeview">
            <a href="#">
            <i class="fa fa-user-plus"></i>
            <span>Project Managers</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="projectmanager?token=3"><i class="fa fa-circle-o"></i>All Project Managers</a></li>
               <li><a href="projectmanager?token=2"><i class="fa fa-circle-o"></i>Blocked</a></li>
               <li><a href="projectmanager?token=1"><i class="fa fa-circle-o"></i>Unblocked </a></li>
            </ul>
         </li>

         <li class="treeview">
            <a href="#">
            <i class="fa fa-tasks"></i>
            <span>Projects</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="project?token=3"><i class="fa fa-circle-o"></i>All Projects</a></li>
               <li><a href="project?token=4"><i class="fa fa-circle-o"></i>Completed</a></li>
               <li><a href="project?token=2"><i class="fa fa-circle-o"></i>Hold</a></li>
               <li><a href="project?token=1"><i class="fa fa-circle-o"></i>Active</a></li>
            </ul>
         </li>

         
         <li class="treeview">
            <a href="#">
            <i class="fa fa-user"></i>
            <span>Users</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="users?token=3"><i class="fa fa-circle-o"></i>All Users</a></li>
               <li><a href="users?token=2"><i class="fa fa-circle-o"></i>Blocked</a></li>
               <li><a href="users?token=1"><i class="fa fa-circle-o"></i>Unblocked </a></li>
               <li><a href="invitedusers"><i class="fa fa-circle-o"></i>Invited </a></li>
            </ul>
         </li>

         <li>
            <a href="logout">
               <i class="fa fa-sign-out"></i><span>Logout</span>
               </a>
         </li>
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   
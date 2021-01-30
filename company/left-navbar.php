 <?php
 $name=explode(' ',$COMPANY_DATA['com_name']);
 $fname=$name[0];
 $lname=$name[1];
 ?>
 <style>
   #profileImage {
  width: 60px;
  height: 48;
  background: #25383C;
  font-size: 35px;
  color: #fff;
  text-align: center;
  line-height: 60px;
  border-radius: 50%;
}
#name{
   margin-top: 6px;
   margin-left: 4px;
}
 </style>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="image">
            <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
               <div id="imgArea" class="pull-left image"> 
                  <div class="profileImage"><?=ucfirst($FNAME[0]).ucfirst($LNAME[0])?></div>
                  <div class="progressBar">
                     <div class="bar"></div>
                     <div class="percent">0%</div>
                  </div>
                  <div id="imgChange"><span><i class="fa fa-edit"></i></span>
                     <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                  </div>
               </div>
            </form>
         </div>
         <div class="pull-left info" id="name">
            <p><?=ucfirst($COMPANY_DATA['f_name']);?> <?=ucfirst($COMPANY_DATA['l_name']);?></p>
             <p><?=ucfirst($COMPANY_DATA['com_name']);?></p>
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
   
 
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="image">
            <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
               <div id="imgArea" class="pull-left image">
                  <img src="<?=$COMPANY_DATA['logo']?>" width="48" height="48" >
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
         <div class="pull-left info">
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
            <i class="fa fa-tasks"></i>
            <span>Projects</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="project?token=3"><i class="fa fa-circle-o"></i>All Projects</a></li>
               <li><a href="project?token=2"><i class="fa fa-circle-o"></i>Hold</a></li>
               <li><a href="project?token=1"><i class="fa fa-circle-o"></i>Active</a></li>
            </ul>
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
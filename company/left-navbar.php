 
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
           

           <li class="treeview">
            <a href="#">
            <i class="fa fa-building fw"></i>
            <span>Companies</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="companies?token=3"><i class="fa fa-circle-o"></i>All Companies</a></li>
               <li><a href="companies?token=2"><i class="fa fa-circle-o"></i>Blocked</a></li>
               <li><a href="companies?token=1"><i class="fa fa-circle-o"></i>Unblocked </a></li>
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
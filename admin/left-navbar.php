<?php 
   $id=$_SESSION['id'];
   if(isset($_GET['status']) && !empty($_GET['status']))
    {
        $status = $_GET['status'];
    }
   $sql = "select * from vendors where id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while ($row = $result->fetch_assoc()) 
        {
            $details[] = $row;
        }
    } ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="image">
            <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
               <div id="imgArea" class="pull-left image">
                  <img src="<?=$data[0]['user_pic'];?>" width="48" height="48" >
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
            <p><?=$data[0]['garage_name'];?></p>
             <p><?=$data[0]['owner_name'];?></p>
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
           
<!--
           <li class="treeview">
            <a href="#">
            <i class="fa fa-shopping-cart fw"></i>
            <span>Stock Record</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            
            <ul class="treeview-menu">
               <li><a href="stock"><i class="fa fa-circle-o"></i>View / Edit Stock</a></li>
               <li><a href="add_stock_products"><i class="fa fa-circle-o"></i>Add Stock Product</a></li>
            </ul>
         </li>
-->
          
          <li>
           <a href="members">
                <i class="fa fa-user"></i>Members
            </a>
         </li>
          <li>
           <a href="companies">
                <i class="fa fa-user"></i>Companies
            </a>
         </li>
          
         <li>
           <a href="logout">
                <i class="fa fa-sign-out"></i>Log Out
            </a>
         </li>
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>
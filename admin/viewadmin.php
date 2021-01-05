<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            $sql="delete from com_admins where id=$id";
            if($conn->query($sql))
            {
                $resSubject=true;   
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['block']))
        {
            $id=$_POST['block'];
            $sql="update com_admins set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['unblock']))
        {
            $id=$_POST['unblock'];
            $sql="update com_admins set status=1 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
    }
    if(isset($_GET['token']))
    {   
        $token=$_GET['token'];
        $sql="select *  from com_admins where c_id=$token";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $admininfo[] = $row;
            }      
        }

        $sql= "select * from companies where id=$token";
        $result=$conn->query($sql);
        if($result->num_rows)
        {
            $row=$result->fetch_assoc();
            $comdata=$row;
        }
    }
        
    
 
?>

<style>
    .box-body{
	overflow: auto!important;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Company Details
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <!-- <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button>  -->
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br>
    <section class="content">
        <?php
            if(isset($resSubject))
            {
        ?>
                <div class="alert alert-success"><strong>Success!</strong> your request successfully updated.</div> 
        <?php
            }
            else if(isset($errorSubject))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorSubject?></div> 
        <?php
                
            }
        ?>
        <?php
            if(isset($comdata))
            {
        ?>
            <div>
            <div class="row">
                    <div class="col-md-4 "  >
                    <!-- Widget: user widget style 2 -->
                        <div class="card card-widget widget-user-2 shadow-sm">
              <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src=".\uploades\medium\4421609810300.jpg" alt="User Avatar">
                                </div>
                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username"><?=$comdata['com_name']?></h3>
                                <h5 class="widget-user-desc"><?=$comdata['address']?>-<?=$comdata['post']?></h5>
                            </div>
                            <div class="card-footer p-0" style="background-color: white; ">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Registration Number <span class="float-right badge bg-blue"><?=$comdata['reg_num']?></span>
                                     </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        Zip Code <span class="float-right badge bg-DeepSkyBlue"></span>
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        Vat <span class="float-right badge bg-green"><?=$comdata['vat']?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                        Registration Date <span class="float-right badge bg-red">
                                            <?php $date=date_create($detail['time_stamp']);
                                                echo date_format($date,"M d Y"); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
            <!-- /.widget-user -->
          </div>
            <?php
            }
            ?>
            </div>
            </div>
                
            <br>
            <h2>Admin Details</h2>
            <div class="box">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>Serial Number</th>
                             <th>First Name</th>
                             <th>Last Name</th>
                             <th>Email</th>
                             <th>Registration Date</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <?php
                        
                            if(isset($admininfo)) 
                            {
                                $i = 1;
                                foreach($admininfo as $detail) 
                                {    
                    ?>
                    <tr> 
                        <td style=" text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                        <td style=" text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 
                        <td style=" text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td>  
                        <td style=" text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>  
                        <td style=" text-align: center; " id="time_stamp<?=$i?>"><?php $date=date_create($detail['time_stamp']);
                        echo date_format($date,"M d Y");?></td>   
                        <td>
                            <form method="post">
                                <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                                <?php
                                if($detail['status']==1)
                                {
                                    ?>
                                    <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['id']?>">
                                        <i class="fa fa-ban">Block</i>
                                    </button>
                                    <?php
                                }
                                else if($detail['status']==0)
                                {
                                    ?>
                                    <button  class="btn btn-success" type="submit" name="unblock" value="<?=$detail['id']?>">
                                        <i class="fa fa-check">Unblock</i>
                                    </button>
                                    <?php
                                }
                                ?>
                            </form>
                        </td>
                    </tr>
                    <?php
                        $i++;            
                        }
                    }
                    ?>
                    </tbody>
                </table>            
            </div>
            <!-- /.box-footer-->
        </div>    
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
    <div class="control-sidebar-bg"></div>
 
<?php
    require_once 'js-links.php';
?> 



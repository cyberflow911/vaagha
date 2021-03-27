<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if(isset($_POST['add']))
        {
            $f_name = $_POST['fn'];
            $l_name = $_POST['ln'];
            $email = $_POST['em'];
            $password = md5($_POST['pss']);
            if(isset($_GET['token']))
            {   
                $token=$_GET['token'];
            }
            $sql="insert into com_admins(c_id, f_name, l_name, email, password, status) values('$token', '$f_name', '$l_name', '$email', '$password', '1')";
            if($conn->query($sql))
            {
                $resSubject=true;
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

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
        if(isset($_POST['delete2']))
        {
            $id=$_POST['delete2'];
            $sql="delete from projects where id=$id";
            if($conn->query($sql))
            {
                $resSubject=true;   
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }
        if(isset($_POST['delete3']))
        {
            $id=$_POST['delete3'];
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
        if(isset($_POST['delete4']))
        {
            $id=$_POST['delete4'];
            $sql="delete from users where id=$id";
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
        if(isset($_POST['block3']))
        {
            $id=$_POST['block3'];
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
        if(isset($_POST['block4']))
        {
            $id=$_POST['block4'];
            $sql="update users set status=0 where id=$id";
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
        if(isset($_POST['unblock3']))
        {
            $id=$_POST['unblock3'];
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
        if(isset($_POST['unblock4']))
        {
            $id=$_POST['unblock4'];
            $sql="update users set status=1 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['hold']))
        {
            $id=$_POST['hold'];
            $sql="update projects set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resSubject = "true";
            }
            else
            {
                $errorSubject=$conn->error;
            }
        }

        if(isset($_POST['active']))
        {
            $id=$_POST['active'];
            $sql="update projects set status=1 where id=$id";
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
        $sql="select *  from com_admins where c_id='$token' and type=1";
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
        
        $sql="SELECT count(id) as count from com_admins where c_id='$token' and type =1";
        if($result=$conn->query($sql))
        {
            if($result->num_rows>0)
            {
                $row=$result->fetch_assoc(); 
                $ca_count=$row['count']; 
            }
        }
        $sql="SELECT count(id) as count from com_admins where c_id='$token' and type=2";
        if($result=$conn->query($sql))
        {
            if($result->num_rows>0)
            {
                $row=$result->fetch_assoc(); 
                $pm_count=$row['count']; 
            }
        }
        $sql="SELECT count(id) as count from projects where cm_id='$token'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows>0)
            {
                $row=$result->fetch_assoc(); 
                $p_count=$row['count']; 
            }
        }
        $sql="SELECT count(id) as count from users where com_id='$token'";
        if($result=$conn->query($sql))
        {
            if($result->num_rows>0)
            {
                $row=$result->fetch_assoc(); 
                $u_count=$row['count']; 
            }
        }

        $sql="select * from projects where cm_id='$token'";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $projects[] = $row;
            }      
        }
    
        $sql="select * from com_admins where c_id='$token' and type=2";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $projectmanager[] = $row;
            }      
        }
        
        $sql="select * from users where com_id='$token'";
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $users[] = $row;
            }      
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
                    <div class="col-md-4" style="margin-top: 30px;" >
                    <!-- Info Boxes Style 2 -->
                        <div class="info-box mb-3 bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-building"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Company Admins</span>
                                <span class="info-box-number"><?=$ca_count?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-green">
                            <span class="info-box-icon"><i class="fa fa-tasks"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Projects</span>
                                <span class="info-box-number"><?=$p_count?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top: 30px;" >
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-red">
                            <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
                            <div class="info-box-content" style="color: white;">
                                <span class="info-box-text">Project Managers</span>
                                <span class="info-box-number"><?=$pm_count?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-blue">
                            <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>
                            <div class="info-box-content" style="color: white;">
                                <span class="info-box-text" >Users</span>
                                <span class="info-box-number"><?=$u_count?></span>
                            </div>
                            <!-- /.info-box-content -->   
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
            </div>
                
            <br>
            <section class="content-header">
                <h1>
                    Admin Details
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <div class="pull-right">
                            <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 
                        </div>
                    </li>
                </ol>
            </section>
            <br>
            <div class="box">
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr style="background-color: #212529; color: white;">
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
    <section class="content-header">
        <h1>
            Projects
        </h1>
    </section>
    <br>
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #212529; color: white;">
                            <th>Serial Number</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>Incentive</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <?php
                        
                            if(isset($projects)) 
                            {
                                $i = 1;
                                foreach($projects as $detail) 
                                {    
                    ?>
                    <tr> 
                        <td style=" text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                        <td style=" text-align: center; " id="title<?=$i?>"><?=$detail['title'];?></td> 
                        <td style=" text-align: center; " id="description<?=$i?>"><?=$detail['description'];?></td>  
                        <td style=" text-align: center; " id="start_date<?=$i?>"><?=$detail['start_date'];?></td>  
                        <td style=" text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                        <td>
                            <form method="post">
                                <button  class="btn btn-danger" type="submit" name="delete2" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                                <?php
                                if($detail['status']==1)
                                {
                                    ?>
                                    <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">
                                        <i class="fa fa-ban">Hold</i>
                                    </button>
                                    <?php
                                }
                                else if($detail['status']==0)
                                {
                                    ?>
                                    <button  class="btn btn-success" type="submit" name="active" value="<?=$detail['id']?>">
                                        <i class="fa fa-check">Active</i>
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
        </div>    
        <section class="content-header">
            <h1>
                Project Managers
            </h1>
        </section>
        <br>
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #212529; color: white;">
                            <th>Serial Number</th>
                            <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <?php
                        
                            if(isset($projectmanager)) 
                            {
                                $i = 1;
                                foreach($projectmanager as $detail) 
                                {    
                    ?>
                    <tr> 
                        <td style=" text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                        <td style=" text-align: center; " id="f_name<?=$i?>"><?=$detail['f_name'];?></td> 
                        <td style=" text-align: center; " id="l_name<?=$i?>"><?=$detail['l_name'];?></td> 
                        <td style=" text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                        <td>
                            <form method="post">
                                <button  class="btn btn-danger" type="submit" name="delete3" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                                <?php
                                if($detail['status']==1)
                                {
                                    ?>
                                    <button  class="btn btn-warning" type="submit" name="block3" value="<?=$detail['id']?>">
                                        <i class="fa fa-ban">Block</i>
                                    </button>
                                    <?php
                                }
                                else if($detail['status']==0)
                                {
                                    ?>
                                    <button  class="btn btn-success" type="submit" name="unblock3" value="<?=$detail['id']?>">
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
        </div>    
        <section class="content-header">
            <h1>
                Users
            </h1>
        </section>
        <br>
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr style="background-color: #212529; color: white;">
                            <th>Serial Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    <?php
                        
                            if(isset($users)) 
                            {
                                $i = 1;
                                foreach($users as $detail) 
                                {    
                    ?>
                    <tr> 
                        <td style=" text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                        <td style=" text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td> 
                        <td style=" text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td>  
                        <td style=" text-align: center; " id="m_num<?=$i?>"><?=$detail['m_num'];?></td>
                        <td style=" text-align: center; " id="address<?=$i?>"><?=$detail['address'];?></td>
                        <td>
                            <form method="post">
                                <button  class="btn btn-danger" type="submit" name="delete4" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                                <?php
                                if($detail['status']==1)
                                {
                                    ?>
                                    <button  class="btn btn-warning" type="submit" name="block4" value="<?=$detail['id']?>">
                                        <i class="fa fa-ban">Block</i>
                                    </button>
                                    <?php
                                }
                                else if($detail['status']==0)
                                {
                                    ?>
                                    <button  class="btn btn-success" type="submit" name="unblock4" value="<?=$detail['id']?>">
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
        </div>    
        
    </section>
</div>

    <!-- /.content -->



<div class="modal fade" id="modal-default">
    <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add Admin</q></h4>
        </div>
        <form method="post">
           <div class="modal-body">
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>First Name</label><br>   
                            <input type="text"  id="fn" name="fn" class="form-control" required>  
                        </div> 
                   </div>
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Last Name</label><br>   
                            <input type="text"  id="ln" name="ln" class="form-control"  required>  
                        </div> 
                   </div>
                </div>  
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Email</label><br>   
                            <input type="text"  id="em" name="em" class="form-control"  required>  
                        </div> 
                   </div>
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Password</label><br>   
                            <input type="text"  id="pss" name="pss" class="form-control"  required>  
                        </div> 
                   </div>
                </div>
                </div>  
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
            </div>
        </form>
    </div>          
</div>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
    <div class="control-sidebar-bg"></div>
    
<?php
    require_once 'js-links.php';
?> 



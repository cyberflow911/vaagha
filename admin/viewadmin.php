<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
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

        // if(isset($_POST['block']))
        // {
        //     $id=$_POST['block'];
        //     $sql="update com_admins set status=0 where id=$id";
        //     if($conn->query($sql))
        //     {
        //         $resSubject = "true";
        //     }
        //     else
        //     {
        //         $errorSubject=$conn->error;
        //     }
        // }
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?=$comdata['com_name']?>
                                     </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Registration Number</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                       <?=$comdata['reg_num']?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?=$comdata['address']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            <?php
            }
            ?>
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
                             <th>Company Name</th>
                             <th>Time Stamp</th>
                             <th>Status</th>
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
                        <td style=" text-align: center; " id="com_name<?=$i?>"><?=$detail['com_name'];?></td>   
                        <td style=" text-align: center; " id="time_stamp<?=$i?>"><?=$detail['time_stamp'];?></td>
                        <td style=" text-align: center; " id="status<?=$i?>"><?=$detail['status'];?></td>     
                        <td>
                            <form method="post">
                                <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                                <button  class="btn btn-danger" type="submit" name="block" value="<?=$detail['id']?>">
                                    <i class="fa fa-trash-o">Block</i>
                                </button>
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



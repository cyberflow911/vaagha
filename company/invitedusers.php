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
            $sql = "delete from users where id=$id";
            
            if($conn->query($sql))
            {
                $resMember=true;   
            }
            else
            {
                $errorMember=$conn->error;
            }
        } 
        if(isset($_POST['add']))
        {
            $email=$_POST['email'];
            $project=$_POST['project'];
            $pmanager=$_POST['pmanager'];
            $sql="select pm_id from projects where id='$project'";
            $sql="insert into users(pm_id, com_id, p_id, email, status) values('$pmanager', '$COMPANY_ID', '$project', '$email', '2')";
            if($conn->query($sql))
            {
                $resMember = "true"; 
            }
            else
            {
                $errorMember=$conn->error;
            } 
        } 
    }
    
    $sql="select * from users where status='2' and com_id='$COMPANY_ID'";    
    if($result =  $conn->query($sql))
    {
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $users[] = $row;
            }
        }

    }
    $sql="select * from projects where cm_id='$COMPANY_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $p_name[] = $row;
        }
    }
    $sql="select * from projectmanager where com_id='$COMPANY_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $pm_name[] = $row;
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
        <h1 style="font-weight: 900;">
            <?=$title?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button>
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br> <br>
    <section class="content">
        <?php
            if(isset($resMember))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div> 
        <?php
            }
            else if(isset($errorMember))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorMember?></div> 
        <?php
                
            }
        ?>
      
            <div class="box">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                            <th>S.No.</th>
                            <th>Email id</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> 
 
                    
                     <?php 
                            if (isset($users)) 
                            {
                                $i = 1;
                                foreach ($users as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                         <td>
                                        <form method="post">
                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                <i class="fa fa-trash-o"></i> Delete
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
<div class="modal fade" id="modal-default">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"> Add New User</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Email</label><br>   
                                    <input type="text"  id="email" name="email" class="form-control"  required>  
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Projects</label><br> 
                                    <select name="project" id="project" class="form-control">
                                        <option value=""></option>
                                    <?php
                                        if(isset($p_name))
                                        {
                                            foreach($p_name as $data)
                                            {          
                                                  
                                    ?>
                                                    <option value="<?=$data['id']?>"><?=$data['title']?></option>
                                    <?php
                                               
                                            }
                                        }
                                    ?>  
                                    </select> 
                                </div>  
                            </div>
                            
                        </div> 
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Project Managers</label><br> 
                                    <select name="pmanager" id="pmanager" class="form-control">
                                        <option value=""></option>
                                    <?php
                                        if(isset($pm_name))
                                        {
                                            foreach($pm_name as $data)
                                            {          
                                               
                                    ?>
                                                    <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                    <?php
                                               
                                            }
                                        }
                                    ?>  
                                    </select> 
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
        <!-- /.modal-content -->
    </div>
          


          

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>




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
            $sql = "delete from projectmanager where id=$id";
            
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
            $name=$_POST['name'];
            $num=$_POST['num'];
            $email=$_POST['email'];
            $pss=md5($_POST['pss']);
            $sql="insert into projectmanager(com_id, name, m_num, password, email,status) values('$COMPANY_ID', '$name','$num', '$pss', '$email','1')";
            if($conn->query($sql))
            {
                $resMember = "true";  
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
            
        if(isset($_POST['edit']))
        {  
            $name=$_POST['ename'];
            $num=$_POST['enum'];
            $email=$_POST['eemail'];
            $id=$_POST['eid'];
            
            $sql="update projectmanager set name='$name', m_num='$num', email='$email'  where id='$id'";
            if($conn->query($sql))
            {
                $resMember  = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }

        if(isset($_POST['block']))
        {
            $id=$_POST['block'];
            $sql="update projectmanager set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resMember = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        if(isset($_POST['unblock']))
        {
            $id=$_POST['unblock'];
            $sql="update projectmanager set status=1 where id=$id";
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

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token = $_GET['token'];
        switch ($token) {
            case '1':
                $sql="select * from projectmanager where com_id='$COMPANY_ID' and status=1";
                $title ="Unblocked Project Managers";
                break;
            case  "2":
                $sql="select * from projectmanager where com_id='$COMPANY_ID' and status=0";
                $title ="Blocked Project Managers";
                break; 
            case "3": 
                $sql="select * from projectmanager where com_id='$COMPANY_ID'";
                $title="Project Managers";
                break;
            default:
                $title="INVALID REQUEST";
                break;
        }
        
        $result =  $conn->query($sql);
        if($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $projectmanager[] = $row;
            }
        }

    }
    else{
        $title="INVALID REQUEST";
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
      <br>
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
                             <th>Name</th>
                             <th>Email</th>
                             <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
 
                    
                     <?php 
                            if (isset($projectmanager)) 
                            {
                                $i = 1;
                                foreach ($projectmanager as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="name<?=$i?>"><?=$detail['name'];?></td> 
                                         <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                         <td style="  text-align: center; " id="num<?=$i?>"><?=$detail['m_num'];?></td>
                                         <td>
                                             <form method="post">
                                                <button name="confirm" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-edit"  onclick="setEditValues(<?=$detail['id'] ?>,<?=$i?>)" value="<?=$detail['id'] ?>">
                                                            <i class="fa fa-edit">Edit</i>
                                                </button>
                                                <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                            <i class="fa fa-trash-o"></i> Delete
                                                </button>
                                                <?php
                                                    if($detail['status']==1)
                                                    {
                                                ?>
                                                    <button  class="btn btn-warning" type="submit" name="block" value="<?=$detail['id']?>">
                                                                <i class="fa fa-ban ">Block</i>
                                                    </button>
                                                <?php
                                                    }else if($detail['status']==0)
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

                         
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"> Add New Project Manager</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Name</label><br>   
                                    <input type="text"  id="name" name="name" class="form-control" required>  
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Email</label><br>   
                                    <input type="text"  id="email" name="email" class="form-control"  required>  
                                </div> 
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Phone Number</label><br>   
                                    <input type="text"  id="num" name="num" class="form-control"  required>  
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Password</label><br>   
                                    <input type="password"  id="pss" name="pss" class="form-control"  required>  
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

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Details</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Name</label><br>   
                                    <input type="text"  id="ename" name="ename" class="form-control" required>  
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Email</label><br>   
                                    <input type="hidden" name="eid" id ="eid"/>
                                    <input type="text"  id="eemail" name="eemail" class="form-control"  required>  
                                </div> 
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Phone Number</label><br>   
                                    <input type="text"  id="enum" name="enum" class="form-control"  required>  
                                </div> 
                            </div>
                        </div>  
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
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

<script>
    function setEditValues(id,count)
    {
        $("#eid").val(id); 
        $("#ename").val($("#name"+count).html());
        $("#eemail").val($("#email"+count).html());
        $("#enum").val($("#num"+count).html());
    }  
</script>

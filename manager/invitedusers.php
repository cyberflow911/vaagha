<?php
   require_once 'header.php';
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
            $sql="select com_id from projectmanager where id='$MANAGER_ID'";
            if($result = $conn->query($sql))
            {
                if($result->num_rows)
                {
                    $cid  = $result->fetch_assoc();  
                }   
            }
            $comid=$cid['com_id'];
            $sql="insert into users(pm_id, com_id, p_id, email, status) values('$MANAGER_ID', '$comid', '$project', '$email', '2')";
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
    
    $sql="select * from users where status='2' and pm_id='$MANAGER_ID'";    
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
    $sql="select * from projects where pm_id='$MANAGER_ID'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $p_name[] = $row;
        }
    }
?>

<style>
    .box-body{
	overflow: auto!important;
}
</style>
<div class="page-wrapper">
	<div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Invited Users</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ml-auto">
                    <div class="btn-group">
                    <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 
                    </div>
                </div>
            </div>
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
					<!--end breadcrumb-->
            <div class="card radius-15">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #212529; color: white;">
                                <tr>
                                    <th scope="col" style="text-align: center;">S.No.</th>
                                    <th scope="col" style="text-align: center;">Email id</th>
                                    <th scope="col" style="text-align: center;">Action</th>
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
                                                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><?=$i?></td> 
                                                <td style="  text-align: center; " id="email<?=$i?>"><?=$detail['email'];?></td> 
                                                <td>
                                                <form method="post">
                                                    <center><button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </button></center>
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
            </div>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title" style="font-size: 18px;">Add New User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Email</label><br>   
                                            <input type="text" style="font-size: 16px;" id="email" name="email" class="form-control"  required>  
                                        </div> 
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Projects</label><br> 
                                            <select name="project" style="font-size: 16px;" id="project" class="form-control">
                                                <option value=""></option>
                                            <?php
                                                if(isset($p_name))
                                                {
                                                    foreach($p_name as $data)
                                                    {          
                                                        if($data['title']!=$user_details['title'])
                                                        {
                                                            
                                            ?>
                                                            <option value="<?=$data['id']?>"><?=$data['title']?></option>
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>  
                                            </select> 
                                        </div>  
                                    </div>
                                    
                                </div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"style="margin-top:10; width: 60px; height: 30px; font-size: 16px;">Close</button>
                                <button type="submit" name="add" class="btn btn-primary" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>




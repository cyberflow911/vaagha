<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id']; 
    if(isset($_GET['token'])&& !empty($_GET['token']))
    { 
        $token=$_GET['token'];
        if(isset($_POST['add']))
        {
            $u_id=$_POST['uid'];
            $incentive=$_POST['incentive'];
            $i=0;
            $sql="insert into group_users(g_id, u_id, status) values";
            foreach($u_id as $data)
            {
                $sql .= "('$token', '$data',  1),";
                $i++;
            }
                $sql=rtrim($sql, ',');
            if($conn->query($sql))
            {
                $resMember = true;
            }
            else
            {
                $errorMember = $conn->error;
            }
        }

        $sql = "SELECT * from users where pm_id='$MANAGER_ID'";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $users[]=$row;
                }
                
            }   
        }
        
        $sql="select p_id from group_details where id='$token'";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                    $pid = $row;
                
            }   
        }
        $p_id=$pid['p_id'];
        
        if(isset($_POST['invite']))
        {
            $email=$_POST['email'];
            $sql="insert into users(p_id, pm_id, com_id, email, status) value('$p_id','$MANAGER_ID', '$MANAGER_COMID', '$email', 2)";
            if($result = $conn->query($sql))
            {
                $iid= $conn->insert_id;
                $sql="insert into group_users(g_id, u_id, status) values('$token', '$iid', 3)";
                if($conn->query($sql))
                {
                    $resMember = true;
                }
                else
                {
                    $errorMember = $conn->error;
                }
               
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
    }
    else
    {
        echo "Invalid Request";
    }   
?>
<style>
    .box-body{
	overflow: auto!important;
}
</style>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
          Group Details
        </h1>
    </section>
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
        
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Users</label><br>   
                                <select class="form-control selectpicker" name="uid[]" id="userSelect" multiple data-live-search="true">
                                <?php
                                    if(isset($users))
                                    { 
                                        $selected=" ";
                                        foreach($users as $data)
                                        {
                                            
                                ?>
                                            <option value=<?=$data['id']?> ><?=$data['name']?> - <?=$data['email']?></option>
                                            

                                            
                                <?php
                                        }
                                    }
                                ?>
                                    
                                </select> 
                            </div> 
                            
                        </div> 
                    </div>
                    
                                    
                        <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
                    <br><br>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Invite User</label><br> 
                                <input type="text"  id="email" name="email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="invite" class="btn btn-primary" >Invite</button>
                        
                </form>
         

    </section>
</div>
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>
<script>
 $(document).ready(function()
    {
        $("#userSelect").selectpicker(); 
    });
   
</script>


<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if(isset($_POST['add']))
        {
            $title=$_POST['title'];
            $description=$_POST['description'];
            $start_date=$_POST['start_date'];
            $incentive=$_POST['incentive'];
            $sql="select com_id from projectmanager where id='$MANAGER_ID'";
            if($result = $conn->query($sql))
            {
                if($result->num_rows)
                {
                    $cid  = $result->fetch_assoc();  
                }   
            }
            $comid=$cid['com_id'];
            $sql="insert into projects(pm_id, cm_id,  title, description, start_date, incentive, status) values('$MANAGER_ID', '$comid', '$title', '$description', 'start_date', '$incentive', '1')";
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
            $title=$_POST['title'];
            $description=$_POST['description'];
            $start_date=$_POST['start_date'];
            $incentive=$_POST['incentive'];
            if(isset($_GET['token'])&& !empty($_GET['token']))
            {
                $token=$_GET['token'];
            }
            $sql="update projects set start_date='$start_date', pm_id='$MANAGER_ID', title='$title', description='$description', incentive='$incentive'  where id='$token'";
            if($conn->query($sql))
            {
                $resMember  = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }     
    }

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        $sql = "select p.* from projects p where p.id=$token";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $project_details  = $result->fetch_assoc();  
            }   
        }
        else
        {
            $errorMember=$conn->error;
        }
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
          Project Details
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
        
                <form method="post">
                    <div class="row">
                        
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Project Title</label><br>   
                                <input type="text"  id="title" name="title" class="form-control" value="<?=$project_details['title']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Start Date</label><br> 
                                <input type="text"  id="start_date" name="start_date" class="form-control" value="<?=$project_details['start_date']?>" required>  
                            </div> 
                        </div>

                    </div>  
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label style="margin-left:5px">Project Description</label><br> 
                                <textarea type="text"  id="description" name="description" class="form-control" style="resize: vertical;height:150px" required>  <?=$project_details['description']?> </textarea> 
                            </div> 
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Incentive</label><br> 
                                <input type="text"  id="incentive" name="incentive" class="form-control" value="<?=$project_details['incentive']?>" required>  
                            </div> 
                        </div>
                    </div>
        
                        <?php
                                if(isset($project_details))
                                {
                        ?>
                                        <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
                            <?php
                                }
                                else
                                {
                            ?>
                                        
                                        <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
                        <?php
                                }
                        ?>
                
                    
                </form>
         

    </section>
</div>
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>


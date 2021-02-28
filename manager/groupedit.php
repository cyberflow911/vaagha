<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if(isset($_GET['token'])&& !empty($_GET['token']))
    { 
        $token=$_GET['token'];
        if(isset($_POST['edit']))
        {  
            $name=$_POST['name'];
            $recruiter=$_POST['recruiter'];
            $user_count=$_POST['user_count'];
            $incentive=$_POST['incentive'];
            $email=$_POST['email'];
            $venue=$_POST['venue'];
            $sql="update group_details set user_count='$user_count', name='$name', recruiter='$recruiter', incentive='$incentive',email='$email',venue='$venue'  where id='$token'";
            if($conn->query($sql))
            {
                $resMember = true; 
            }
            else
            {
                $errorMember=$conn->error;
            }
        }  
        
        $sql = "select * from group_details where id=$token";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $group_details  = $result->fetch_assoc();  
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
        
                <form method="post" >
                    <div class="row">
                        
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Name</label><br>   
                                <input type="text"  id="name" name="name" class="form-control" value="<?=$group_details['name']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Recruiter</label><br> 
                                <input type="text"  id="recruiter" name="recruiter" class="form-control" value="<?=$group_details['recruiter']?>" required>  
                            </div> 
                        </div>

                    </div> 
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Incentive</label><br> 
                                <input type="text"  id="incentive" name="incentive" class="form-control" value="<?=$group_details['incentive']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Total Users</label><br> 
                                <input type="text"  id="user_count" name="user_count" class="form-control" value="<?=$group_details['user_count']?>" required>
                            </div> 
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Venue</label><br> 
                                <input type="text"  id="venue" name="venue" class="form-control" value="<?=$group_details['venue']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Email</label><br> 
                                <input type="email"  id="email" name="email" class="form-control" value="<?=$group_details['email']?>" required>
                            </div> 
                        </div> 
                    </div>
                    
                    <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
                         
                
                    
                </form>
         

    </section>
</div>
<div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>



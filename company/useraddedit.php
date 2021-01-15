<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['add']))
        {
            $email=$_POST['email'];
            $pmanager=$_POST['pmanager'];
            $project=$_POST['project'];
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
            
        if(isset($_POST['edit']))
        {  
            $email=$_POST['email'];
            $pmanager=$_POST['pmanager'];
            $project=$_POST['project'];
            $name=$_POST['name'];
            $address=$_POST['address'];
            $m_num=$_POST['m_num'];
            if(isset($_GET['token'])&& !empty($_GET['token']))
            {
                $token=$_GET['token'];
            }
            $sql="update users set pm_id='$pmanager', name='$name', email='$email', p_id='$project', m_num='$m_num', address='$address'  where id='$token'";
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
        $sql = "select u.*, pm.name as pmname, pm.id as pmid, p.title, p.id as pid from users u, projects p, projectmanager pm where u.id='$token' and u.pm_id=pm.id and u.p_id=p.id and u.status!=2";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $user_details  = $result->fetch_assoc();  
            }
             
        }
        else
        {
            $errorMember=$conn->error;
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
    $sql="select * from projects where cm_id='$COMPANY_ID'";
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

<div class="content-wrapper">

    <section class="content-header">
        <h1>
        User Details
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
                                <label>Email</label><br>   
                                <input type="email"  id="email" name="email" class="form-control" value="<?=$user_details['email']?>" required>  
                            </div> 
                        </div>
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Project Manager</label><br> 
                                <select name="pmanager" id="pmanager" class="form-control">
                                <option value="<?=$user_details['pmid']?>"><?=$user_details['pmname']?></option>
                                <?php
                                    if(isset($pm_name))
                                    {
                                        foreach($pm_name as $data)
                                        {          
                                            if($data['name']!=$user_details['pmname'])
                                            {
                                                
                                ?>
                                                <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                <?php
                                            }
                                        }
                                    }
                                ?>  
                                </select> 
                            </div> 
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-5"> 
                            <div class="form-group">
                                <label>Projects</label><br> 
                                <select name="project" id="project" class="form-control">
                                <option value="<?=$user_details['pid']?>"><?=$user_details['title']?></option>
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
                    
        
                        <?php
                                if(isset($user_details))
                                {
                        ?>
                                        <div class="col-md-5"> 
                                            <div class="form-group">
                                                <label>Address</label><br>   
                                                <input type="text"  id="address" name="address" class="form-control" value="<?=$user_details['address']?>" required>  
                                            </div> 
                                        </div> 
                                    </div>         
                                    <div class="row">
                                        <div class="col-md-5"> 
                                            <div class="form-group">
                                                <label>Name</label><br>   
                                                <input type="text"  id="name" name="name" class="form-control" value="<?=$user_details['name']?>" required>  
                                            </div> 
                                        </div>
                                        <div class="col-md-5"> 
                                            <div class="form-group">
                                                <label>Phone Number</label><br>   
                                                <input type="text"  id="m_num" name="m_num" class="form-control" value="<?=$user_details['m_num']?>" required>  
                                            </div> 
                                        </div>
                                    </div>    
                                    <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
                            <?php
                                }
                                else
                                {
                            ?>
                                    </div>
                                        
                                        <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
                        <?php
                                }
                        ?>
                
                    
                </form>
         

    </section>
</div>




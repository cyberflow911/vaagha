<?php
    require_once 'header.php';
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
            
        if(isset($_GET['token'])&& !empty($_GET['token']))
        {
            $token=$_GET['token'];
            if(isset($_POST['edit']))
            {  
                $email=$_POST['email'];
                $pmanager=$_POST['pmanager'];
                $project=$_POST['project'];
                $name=$_POST['name'];
                $address=$_POST['address'];
                $m_num=$_POST['m_num'];
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
    }

    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token=$_GET['token'];
        $sql = "select u.*, pm.f_name as pmname, pm.id as pmid, p.title, p.id as pid from users u, projects p, com_admins pm where u.id='$token' and u.pm_id=pm.id and u.p_id=p.id and u.status!=2";
        if($result = $conn->query($sql))
        {
            if($result->num_rows)
            {
                $user_details  = $result->fetch_assoc();  
            }
             
        }
    }
    
    $sql="select * from com_admins where c_id='$COMPANY_ID' and type=2";
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
<div class="page-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">User Details</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
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
            <form method="post" enctype="multipart/form-data">
                <div class="card radius-15 border-lg-top-primary">
                    <div class="card-body p-5">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Email</label><br>   
                                        <input type="email" style="font-size: 16px;"  id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" class="form-control" value="<?=$user_details['email']?>" required>  
                                    </div> 
                                </div>
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Project Manager</label><br> 
                                        <select name="pmanager" id="pmanager" style="color:black; font-size: 16px;"  class="form-control">
                                        <?php
                                            if(isset($pm_name))
                                            {
                                                foreach($pm_name as $data)
                                                {          
                                                    if($data['id']==$user_details['pmid'])
                                                    {
                                                        $select="selected";
                                                    }
                                                        
                                        ?>
                                                        <option value="<?=$data['id']?>" <?=$selected?>><?=$data['f_name']?> <?=$data['l_name']?></option>
                                        <?php
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
                                        <select name="project" id="project" style="font-size: 16px;"  class="form-control">
                                        <option value="<?=$user_details['pid']?>"><?=$user_details['title']?></option>
                                        <?php
                                            if(isset($p_name))
                                            {
                                                foreach($p_name as $data)
                                                {          
                                                    if($data['title']==$user_details['title'])
                                                    {
                                                        $select="selected";
                                                    }
                                                        
                                        ?>
                                                        <option value="<?=$data['id']?>" <?=$selected?>><?=$data['title']?></option>
                                        <?php
                                                    
                                                }
                                            }
                                        ?>  
                                        </select> 
                                    </div> 
                                </div> 
                            </div>
                    
        
                <?php
                        if(isset($user_details))
                        {
                ?>
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Address</label><br>   
                                        <input type="text" style="font-size: 16px;"  id="address" name="address" class="form-control" value="<?=$user_details['address']?>" required>  
                                    </div> 
                                </div> 
                            </div>         
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Name</label><br>   
                                        <input type="text"  id="name" name="name" style="font-size: 16px;"  class="form-control" value="<?=$user_details['name']?>" required>  
                                    </div> 
                                </div>
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Phone Number</label><br>   
                                        <input type="text" style="font-size: 16px;"  id="m_num" name="m_num" class="form-control" value="<?=$user_details['m_num']?>" required>  
                                    </div> 
                                </div>
                            </div>    
                            <button type="submit" name="edit" style="width: 60px; height: 30px; font-size: 16px;" class="btn btn-primary" value="">Edit</button>
                    <?php
                        }
                        else
                        {
                    ?>
                            <button type="submit" name="add" style="width: 60px; height: 30px; font-size: 16px;" class="btn btn-primary" value="">Add</button>

                                
                <?php
                        }
                ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'js-links.php';
?>
<script>
    function ValidateEmail(mail) 
    {
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(myForm.emailAddr.value))
    {
        return (true)
    }
        alert("You have entered an invalid email address!")
        return (false)
    }
</script>





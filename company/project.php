<?php
    require_once 'header.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=$_POST['delete'];
            $sql = "delete from projects where id=$id";
            
            if($conn->query($sql))
            {
                $resMember=true;   
            }
            else
            {
                $errorMember=$conn->error;
            }
        }  
        if(isset($_POST['hold']))
        {
            $id=$_POST['hold'];
            $sql="update projects set status=0 where id=$id";
            if($conn->query($sql))
            {
                $resMember = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }

        if(isset($_POST['active']))
        {
            $id=$_POST['active'];
            $sql="update projects set status=1 where id=$id";
            if($conn->query($sql))
            {
                $resMember = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        if(isset($_POST['completed']))
        {
            $id=$_POST['completed'];
            $sql="update projects set status=2 where id=$id";
            if($conn->query($sql))
            {
                $resMember = "true";
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        if ( isset($_POST["submit"]) ) 
        {

            if ( isset($_FILES["file"])) 
            {
                //if there was an error uploading the file
                if ($_FILES["file"]["error"] > 0) 
                {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                }
                else 
                {
                    
                    //if file already exists
                    if (file_exists("upload/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                    }
                    else 
                    {
                        //Store file in directory "upload" with the name of "uploaded_file.txt"
                        $storagename = "uploaded_file.txt";
                        move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $storagename);
                    }
                }
            } 
            else 
            {
                echo "No file selected <br />";
            }
            $row=1;
            if ( isset($storagename) && (($handle = fopen("uploads/" . $storagename , r )) !== FALSE) ) 
            {

                $sql = "insert into projects(title,project_reference,description,pm_id, incentive,participants,group_num,start_date,termandcondition) values";
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
                {
                    if($row==1)
                    {
                        $row++;
                        continue;
                        
                    }
                    $num = count($data);

                    $row++;
                    // $sql.="('".implode($data,"','")."'),";
                    $sql.="(";
                    if($data[10]=="yes"||$data[10]=="Yes"||$data[10]=="YES"||$data[10]=="YEs"||$data[10]=="YeS"||$data[10]=="yeS"||$data[10]=="yeS")
                    {
                        $data[10]=1;
                    }
                    else
                    {
                        $data[10]=2;
                    }
                    $sql2="SELECT id FROM com_admins WHERE email='$data[5]'";
                    $res =  $conn->query($sql2);
                    if($res->num_rows)
                    {
                        while($r = $res->fetch_assoc())
                        {
                            $pmid = $r['id'];
                        }
                    }
                    $data[5]=$pmid;
                    for ($c=0; $c < $num; $c++) 
                    {
                        if($c==3||$c==4)
                        {
                            continue;
                        }
                        $sql .=  "'$data[$c]'," ;
                    }
                    $sql = rtrim($sql,",");
                    $sql .="),";
                }
                $sql = rtrim($sql,",");
                if($conn->query($sql))
                {
                    $insert_id = $conn->insert_id;
                    $pms = "'".implode($insert_id,"','")."'";
                    $sql3="update projects set cm_id='$COMPANY_ID' where id in ($pms)" ;
                    if($conn->query($sql3))
                    {
                        $resMember="true";
                    }
                    else
                    {
                        $errorMember=$conn->error;
                    }
                }
                else
                {
                    $errorMember=$conn->error;
                }

                fclose($handle);
            }
        }
          
    }
    if(isset($_GET['token'])&&!empty($_GET['token']))
    {
        $token = $_GET['token'];
        switch ($token) {
            case '1':
                $sql="select p.* from projects p where p.cm_id='$COMPANY_ID' and p.status = 1";
                $title ="Active Projects";
                break;
            case  "2":
                $sql="select p.* from projects p where p.cm_id='$COMPANY_ID' and p.status = 0";
                $title ="Projects on Hold";
                break; 
            case "3": 
                $sql="select p.* from projects p where p.cm_id='$COMPANY_ID'";
                $title="Projects";
                break;
            case "4": 
                $sql="select p.* from projects p where p.cm_id='$COMPANY_ID' and p.status=2";
                $title="Completed Projects";
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
                $projects[] = $row;
            }
        }

    }
    else
    {
        $title="INVALID REQUEST";
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
                <div class="breadcrumb-title pr-3"><?=$title?></div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="dashboard"><i class='bx bx-home-alt'></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <button class="btn btn-primary" style="font-size: 14px; padding: 10px; margin-left: 150px;" data-toggle="modal" data-target="#modal-default"><i class="fa fa-user-plus"></i>Bulk Upload Projects</button><br>
                <form method="get" action="uploads/project_template.xlsx">
                <button class="btn btn-primary" style="font-size: 14px; padding: 10px; margin-left: 50px;" ><i class="fa fa-download"></i>Download Bulk Upload Template</button><br></form>
                <div class="ml-auto">
                    <div class="btn-group">
                        <a href="projectdetails" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                        
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
        <br>
        
        <br>
            <div class="box">
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead style="background-color: #212529; color: white;">
                            <tr>
                             <th>S.No.</th>
                             <th>Project Title</th>
                             <th>Project Description</th>
                             <th>Start Date</th>
                             <th>Incentive</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody> 
 
                    
                     <?php 
                            if (isset($projects)) 
                            {
                                $i = 1;
                                foreach ($projects as $detail) 
                                {     
                     ?> 
                                     <tr> 
                                         <td style="  text-align: center; " id="serialNo<?=$i?>"><?=$i?></td> 
                                         <td style="  text-align: center; " id="title<?=$i?>"><?=$detail['title'];?></td> 
                                         <td style="  text-align: center; " id="description<?=$i?>"><?=$detail['description'];?></td>
                                         <td style="  text-align: center; " id="start_date<?=$i?>"><?=$detail['start_date'];?></td>
                                         <td style="  text-align: center; " id="incentive<?=$i?>"><?=$detail['incentive'];?></td>
                                         <td>
                                             <form method="post">
                                            <a href="projectdetails?token=<?=$detail['id']?>" class="btn btn-success" value="<?=$detail['id']?>"> <i class="fa fa-edit">Edit</i> </a>
                                            <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </button>
                                        <?php
                                            if($detail['status']==1)
                                            { 
                                        ?>
                                                <button  class="btn btn-secondary" type="submit" name="completed" value="<?=$detail['id']?>">
                                                        <i class="fa fa-check-square ">&nbspComplete</i>
                                                    </button>
                                                <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">
                                                    <i class="fa fa-ban"></i> Hold
                                                </button>  
                                        <?php
                                            }
                                            else if($detail['status']==0)
                                            {
                                        ?>
                                                <button  class="btn btn-secondary" type="submit" name="completed" value="<?=$detail['id']?>">
                                                        <i class="fa fa-check-square ">&nbspComplete</i>
                                                    </button>
                                                <button  class="btn btn-info" type="submit" name="active" value="<?=$detail['id']?>">
                                                    <i class="fa fa-check"></i> Active
                                                </button>
                                        <?php
                                            }
                                            else if($detail['status']==2)
                                            {
                                        ?>
                                                <button  class="btn btn-warning" type="submit" name="hold" value="<?=$detail['id']?>">
                                                    <i class="fa fa-ban"></i> Hold
                                                </button>    
                                                <button  class="btn btn-info" type="submit" name="active" value="<?=$detail['id']?>">
                                                    <i class="fa fa-check"></i> Active
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
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add CSV File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <label>Select File</label><br>   
                                <input type="file" name="file" style="font-size: 16px;" id="file" class="form-control"  required>  
                            </div> 
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top:10; width: 90px; height: 30px; font-size: 16px;">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary" style="margin-top:10; width: 60px; height: 30px; font-size: 16px;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


  

<?php
    require_once 'js-links.php';
?>





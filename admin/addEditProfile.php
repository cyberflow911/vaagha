<?php
    require_once 'header.php';
    require_once 'navbar.php';

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['submit']))
        {
            $garage_name = test_input($_POST['gname']);
            $owner_name = test_input($_POST['oname']);
            $garage_type = test_input($_POST['gtype']);
            $mobile_no = test_input($_POST['mno']);
            $address = test_input($_POST['address']);
            $pincode = test_input($_POST['pin']);
            $state = test_input($_POST['state']);
            $city = test_input($_POST['city']);
            $govt1 = test_input($_POST['gvt1']);
            $govt2 = test_input($_POST['gvt2']);
            $years = test_input($_POST['years']);
            $months = test_input($_POST['months']);
            $services = test_input($_POST['services']);
            $mechanics = test_input($_POST['mechanics']);
            $area = test_input($_POST['area']);
            $area = round($area,2);
            $height = test_input($_POST['height']);
            $width = test_input($_POST['width']);
            
            if(!empty($_POST['edit']))
            {
                $eid = test_input($_POST['edit']); 
                if(isset($_POST['brands']))
                {
                    $sql = "delete from vendor_brand_list where vendor_id=$eid";
                    $conn->query($sql);
                    foreach ($_POST['brands'] as $bid) 
                    {
                        $sql = "insert into vendor_brand_list(brand_id, vendor_id) values ($bid, $eid)";
                        $conn->query($sql);   
                    }
                }           
                if(isset($_FILES['extra']))  
                {
                    $status = upload_images($_FILES['extra'],$conn,'vendor_garage_images','vendor_id','images',$eid, 'extra');
                } 
                if($status)
                {
                    $success=true;
                }
                else
                {
                    $error="Image Uploading Problem Occured!";
                }
                if(!empty($_FILES['images1']["name"]))
                {
                    $file= $_FILES['images1']["name"];
                    $govt1_pic = upload_image2($file,$conn,'vendors','govt_pic1',$eid,'images1');
                    if($govt1_pic != 'err')
                    { 
                        $success=true;
                    }
                    else
                    {
                        $error=true;
                    }
                }
                
                if(!empty($_FILES['images2']["name"]))
                {
                    $file= $_FILES['images2']["name"];
                    
                    $govt2_pic = upload_image2($file,$conn,'vendors','govt_pic2',$eid,'images2');
                    if($govt2_pic != 'err')
                    { 
                        $success=true;
                    }
                    else
                    {
                        $error=true;
                    }
                }

                if(!empty($_FILES['front1']["name"]))
                {
                    $file= $_FILES['front1']["name"];
                    $p_id = test_input($_POST['gp1']);
                    $pic = upload_image2($file,$conn,'vendor_garage_images','images',$p_id,'front1');
                    if($pic != 'err')
                    { 
                        $success=true;
                    }
                    else
                    {
                        $error=true;
                    }
                }

                if(!empty($_FILES['front2']["name"]))
                {
                    $file= $_FILES['front2']["name"];
                    $p_id = test_input($_POST['gp2']);
                    $pic = upload_image2($file,$conn,'vendor_garage_images','images',$p_id,'front2');
                    if($pic != 'err')
                    { 
                        $success=true;
                    }
                    else
                    {
                        $error=true;
                    }
                }

                if(!empty($_FILES['back3']["name"]))
                {
                    $file= $_FILES['back3']["name"];
                    $p_id = test_input($_POST['gp3']);
                    $pic = upload_image2($file,$conn,'vendor_garage_images','images',$p_id,'back3');
                    if($pic != 'err')
                    { 
                        $success=true;
                    }
                    else
                    {
                        $error=true;
                    }
                }

                if(!empty($_FILES['back4']["name"]))
                {
                    $file= $_FILES['back4']["name"];
                    $p_id = test_input($_POST['gp4']);
                    $pic = upload_image2($file,$conn,'vendor_garage_images','images',$p_id,'back4');
                    if($pic != 'err')
                    { 
                        $success=true;
                    }
                    else
                    {
                        $error=true;
                    }
                }

                if(isset($_POST['pass']))
                {
                    $password = test_input($_POST['pass']);
                    $password = md5($password);
                    $cpassword = test_input($_POST['cpass']);
                    $cpassword = md5($cpassword);
                    if($password == $cpassword)
                    {
                        $sql="update vendors set garage_name='$garage_name', owner_name='$owner_name', garage_type='$garage_type', mobile_no='$mobile_no', address='$address', pincode='$pincode', state='$state', city='$city', govt_id1='$govt1', govt_id2='$govt2', work_years='$years', work_months='$months', services_per_day='$services', mechanics_no='$mechanics', garage_area='$area', board_height='$height', board_width='$width', password='$password' where id=".$eid;   
                        if($conn->query($sql))
                        { 
                                $success=true;
                        }
                        else
                        {
                            $error=true;
                        } 
                    }
                    else
                    {
                        $error=true;   
                    }
                    
                }
                else
                {
                    $sql="update vendors set garage_name='$garage_name', owner_name='$owner_name', garage_type='$garage_type', mobile_no='$mobile_no', address='$address', pincode='$pincode', state='$state', city='$city', govt_id1='$govt1', govt_id2='$govt2', work_years='$years', work_months='$months', services_per_day='$services', mechanics_no='$mechanics', garage_area='$area', board_height='$height', board_width='$width' where id=".$eid;

                    if($conn->query($sql))
                    { 
                            $success=true;
                    }
                    else
                    {
                        $error=true;
                    }  
                }
            }
            else
            {   
                $password = test_input($_POST['pass']);
                $password = md5($password);
                $cpassword = test_input($_POST['cpass']);
                $cpassword = md5($cpassword);
                if($password == $cpassword)
                {               
                    $sql="insert into vendors(garage_name, owner_name, garage_type, mobile_no, address, pincode, state, city, govt_id1, govt_id2, work_years, work_months, services_per_day, mechanics_no, garage_area, board_height, board_width, password, status) values('$garage_name','$owner_name','$garage_type','$mobile_no','$address','$pincode','$state','$city','$govt1','$govt2','$years','$months','$services','$mechanics','$area','$height','$width','$password', 'verified')";

                    if($conn->query($sql))
                    { 
                        $id=$conn->insert_id;
                        $file1= $_FILES['images1']["name"];
                        $file2= $_FILES['images2']["name"];
                        $govt1_pic = upload_image2($file1,$conn,'vendors','govt_pic1',$id,'images1');
                        $govt2_pic = upload_image2($file2,$conn,'vendors','govt_pic2',$id,'images2');
                        if($govt1_pic != 'err' && $govt2_pic != 'err')
                        { 
                            if(isset($_POST['brands']))
                            {
                                foreach ($_POST['brands'] as $bid) 
                                {
                                    $sql = "insert into vendor_brand_list(brand_id, vendor_id) values ($bid, $id)";
                                    $conn->query($sql);
                                }
                            }
                            $success=true;
                        }
                        else
                        {
                            $error=true;
                        }
                        if(!empty($_FILES['front1']["name"]))
                        {
                            $file= $_FILES['front1']["name"];
                            $pic = upload_img($file,$conn,'vendor_garage_images','images',$id,'front1', 'front1');
                            if($pic != 'err')
                            { 
                                $success=true;
                            }
                            else
                            {
                                $error= true;
                            }
                        }

                        if(!empty($_FILES['front2']["name"]))
                        {
                            $file= $_FILES['front2']["name"];
                            $pic = upload_img($file,$conn,'vendor_garage_images','images',$id,'front2', 'front2');
                            if($pic != 'err')
                            { 
                                $success= true;
                            }
                            else
                            {
                                $error= true;
                            }
                        }

                        if(!empty($_FILES['back3']["name"]))
                        {
                            $file= $_FILES['back3']["name"];
                            $pic = upload_img($file,$conn,'vendor_garage_images','images',$id,'back3', 'back3');
                            if($pic != 'err')
                            { 
                                $success=true;
                            }
                            else
                            {
                                $error= true;
                            }
                        }

                        if(!empty($_FILES['back4']["name"]))
                        {
                            $file= $_FILES['back4']["name"];
                            $pic = upload_img($file,$conn,'vendor_garage_images','images',$id,'back4','back4');
                            if($pic != 'err')
                            { 
                                $success=true;
                            }
                            else
                            {
                                $error= true;
                            }
                        }

                        if(isset($_FILES['images']))  
                        {
                            $status = upload_images($_FILES['images'],$conn,'vendor_garage_images','vendor_id','images',$id, 'images');
                        } 
                        if($status)
                        {
                            $success=true;
                        }
                        else
                        {
                            $error="Image Uploading Problem Occured!";
                        }
                    }
                    else
                    {
                        $error= true;
                    }
                }  
            }  
        } 
    }
    require_once 'left-navbar.php';

function upload_img($files,$conn,$table,$column,$id,$image,$type)
{
    $uploadedFile = 'err';
    if(!empty($_FILES[$image]["type"]))
    {
        $fileName = time().'_'.str_replace(' ', '',$_FILES[$image]['name']);
        $valid_extensions = array("jpeg", "jpg", "png","bmp","JPG");
        $temporary = explode(".", $_FILES[$image]["name"]);
        $file_extension = end($temporary);
        if((($_FILES[$image]["type"] == "image/png") || ($_FILES[$image]["type"] == "image/bmp") || ($_FILES[$image]["type"] == "image/jpg") || ($_FILES[$image]["type"] == "image/JPG") || ($_FILES[$image]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES[$image]['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                if(isset($table))
                {
                    $sql="insert into $table($column, type, vendor_id) values ('$targetPath','$type',$id)";
                    if($conn->query($sql)===true)
                    {
                        return $uploadedFile;
                    }
                    else
                    {
                        echo $fileName;
                        unlink("uploads/".$fileName);
                        return 'err';
                    }
                }
                return $uploadedFile;
            }
            else
            {
                $uploadedFile="err";
                 return $uploadedFile;
            }
        }
        else
        {
            $uploadedFile="err";
            return $uploadedFile;
        }
       
    }
    else
    {
            $uploadedFile="err";
            return $uploadedFile;
    }
}

    if(isset($_GET['token']) && !empty($_GET['token']))
    {
        $vid = $_GET['token'];
    }

    $garage_name = "";
    $owner_name = "";
    $garage_type = "";
    $mobile_no = "";
    $address = "";
    $pincode = "";
    $state = "";
    $city = "";
    $govt1 = "";
    $govt1_pic = "";
    $govt2 = "";
    $govt2_pic = "";
    $years = "";
    $months = "";
    $services = "";
    $mechanics = "";
    $area = 0.0;
    $height = "";
    $width = "";
    $password = "";
    $brands=[];
    $count = 0;

    if(isset($vid))
    {
        $sql = "select * from vendors where id=".$vid;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $vendor[] = $row;
                $garage_name = $row['garage_name'];
                $owner_name = $row['owner_name'];
                $garage_type = $row['garage_type'];
                $mobile_no = $row['mobile_no'];
                $address = $row['address'];
                $pincode = $row['pincode'];
                $state = $row['state'];
                $city = $row['city'];
                $govt1 = $row['govt_id1'];
                $govt1_pic = $row['govt_pic1'];
                $govt2 = $row['govt_id2'];
                $govt2_pic = $row['govt_pic2'];
                $years = $row['work_years'];
                $months = $row['work_months'];
                $services = $row['services_per_day'];
                $mechanics = $row['mechanics_no'];
                $area = $row['garage_area'];
                $height = $row['board_height'];
                $width = $row['board_width'];
                $password = $row['password'];
            }
        }
        $sql = "select * from vendor_brand_list where vendor_id=".$vid;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                $brands[] = $row['brand_id'];
            }
        }
        $sql = "select * from vendor_garage_images where vendor_id=".$vid. " order by id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                $g_images[] = $row;
            }
        }
    }

    $sql = "select distinct(state) as state from statesandcity";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            $states[] = $row;
        }
    }
    $sql = "select * from statesandcity";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            $cities[] = $row;
        }
    }

    $sql = "select * from brand order by id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            $brand[] = $row;
        }
    }

?>

<style type="text/css">
    .bs-searchbox .form-control 
    {
        margin-left: 0px;
    }
    .form-group img
    {
        width: 200px;
        height: 160px;
    }
    .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) 
    {
        width: -webkit-fill-available;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <?php
        if(isset($vid))
        {
    ?>
        <h1>
            Edit Vendor Info
        </h1> 
    <?php
        }
        else        
        {
    ?>
        <h1>
            Add Vendor Info
        </h1>
    <?php
        }
    ?>
       
    </section>

    <!-- Main content -->
    <br>
    <section class="content" style="padding:0px">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-lg-12 col-md-12 col-sm-12 col-md-sm-12 col-md-xs-12">
                    <div class="card">
                        <div class="body" style="font-size: 12px !important;">
                            <?php
                                if(isset($success))
                                {
                            ?>
                                    <div class="alert alert-success"><strong>Success! </strong> your request successfully updated.</div> 
                            <?php
                                }
                                else if(isset($error))
                                {
                            ?>
                                    <div class="alert alert-danger"><strong>Error! </strong>Due to some reason.</div> 
                            <?php
                                }
                            ?>
                                
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-list"></i> Basic Info</h3>
                                </div>
                                <div class="box-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <!--BASIC INFO-->
                                        <div class="row">
                                            <div class="col-xs-6 form-group">
                                                <label>Garage Name </label>
                                                <input class="form-control" type="text" name="gname" value="<?=$garage_name;?>" required>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>Owner Name </label>
                                                <input class="form-control" type="text" name="oname" value="<?=$owner_name;?>" required minlength='3'>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>Mobile No </label>
                                                <input class="form-control" type="number" name="mno" value="<?=$mobile_no;?>" required>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>Garage Type</label>
                                                <select class="form-control" name="gtype" id="gtype" required>
                                                    <option value="2 wheeler" selected>2 wheeler</option>
                                                    <option value="4 wheeler">4 wheeler</option>
                                                    <option value="2,4 wheeler">2,4 wheeler</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>State</label>
                                                <select class="form-control" name="state" id="state" required>
                                                    <?php
                                                        if(isset($states))
                                                        {
                                                            foreach ($states as $s) 
                                                            {
                                                    ?>
                                                            <option value="<?=$s['state']?>"><?=$s['state']?></option>
                                                    <?php
                                                            }
                                                        }       
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>City</label>
                                                <select class="form-control" name="city" id="city" required>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-xs-6 form-group" >
                                                <label>Pincode</label>
                                                <input class="form-control" type="text" name="pin" value="<?=$pincode;?>" required>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="address" rows="3" required style="resize: none"><?=$address;?></textarea>
                                            </div>
                                            
                                            <!--GOVERNMENT PICTURES-->
                                            <div class="col-xs-6 form-group" style="font-size: 10px;">
                                                <label class="col-md-12">Government ID Proof 1</label>
                                            <?php
                                                if(isset($vid))
                                                {
                                            ?>
                                                    <div class="col-md-4 form-group">
                                                        <img src="<?=$govt1_pic?>" id="img1" style="width: 90%;">
                                                    </div>
                                                    <div class="col-md-8 col-sm-6 form-group">
                                                        <select name="gvt1" id="gvt1" class="form-control" required>
                                                            <option value="aadhar_card">Aadhar Card</option>
                                                            <option value="voter_card">Voter Card</option>
                                                            <option value="driving_licence">Driving Licence</option>
                                                            <option value="pan_card">PAN Card</option>
                                                        </select>
                                                        <br/>
                                                        <input type="file" class="form-control" name="images1" id="images1" style="margin-top: 10px;">
                                                    </div>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>      
                                                    <div class="col-md-6 col-sm-6 form-group">
                                                        <select nam e="gvt1" id="gvt1" class="form-control" required>
                                                            <option value="aadhar_card">Aadhar Card</option>
                                                            <option value="voter_card">Voter Card</option>
                                                            <option value="driving_licence">Driving Licence</option>
                                                            <option value="pan_card">PAN Card</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 form-group">
                                                       <input type="file" name="images1" class="form-control" required>
                                                    </div>
                                            <?php
                                                }
                                            ?>    
                                            </div>
                                            <div class="col-xs-6 form-group" style="font-size: 10px;">
                                                <label class="col-md-12">Government ID Proof 2</label>
                                            <?php
                                                if(isset($vid))
                                                {
                                            ?>
                                                    <div class="col-md-4 form-group">
                                                        <img src="<?=$govt2_pic?>" id="img2" style="width: 90%;">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="gvt2" id="gvt2" class="form-control" required>
                                                            <option value="aadhar_card">Aadhar Card</option>
                                                            <option selected value="voter_card">Voter Card</option>
                                                            <option value="driving_licence">Driving Licence</option>
                                                            <option value="pan_card">PAN Card</option>
                                                        </select>
                                                        <br/>
                                                        <input type="file" name="images2" id="images2" class="form-control" style="margin-top: 10px;">
                                                    </div>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                    <div class="col-md-6">
                                                        <select name="gvt2" id="gvt2" class="form-control gvt2" required>
                                                            <option value="aadhar_card">Aadhar Card</option>
                                                            <option selected value="voter_card">Voter Card</option>
                                                            <option value="driving_licence">Driving Licence</option>
                                                            <option value="pan_card">PAN Card</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                       <input type="file" name="images2" class="form-control" required>
                                                    </div>
                                            <?php
                                                }
                                            ?>
                                            </div>
                                            
                                            <!--GARAGE PICS-->
                                            <?php
                                                if(isset($vid))
                                                {
                                            ?>
                                                    <div class="col-md-12 col-sm-12 form-group add_edit" style="clear: both">     
                                            <?php
                                                    if(isset($g_images))
                                                    {
                                                        $i=0;
                                                        foreach ($g_images as $g) 
                                                        {
                                                            $i++;
                                                            if($i==1)
                                                            {
                                            ?>
                                                                <div class="col-md-6 row">
                                                                    <label class="col-md-12">Garage Inside Pics</label>
                                            <?php
                                                            }
                                                            if($i <= 2)
                                                            {
                                                               
                                            ?>
                                                
                                                                <input type="file" class="form-control" name="front<?=$i?>" id="front<?=$i?>" style="display: none; margin-top: 10px;">
                                               
                                                                <div class="col-md-12 form-group" style="margin-bottom:10px">
                                                                    <img src="<?=$g['images']?>" id="pic<?=$i?>">
                                                                    <input type="hidden" name="gp<?=$i?>" value="<?=$g['id']?>"> 
                                                                </div>
                                            
                                            <?php
                                                            }
                                                            else if($i>2 && $i<=4)
                                                            {
                                                                if($i==3)
                                                                {
                                            ?>
                                                                    </div>
                                                                    <div class="col-md-6 row">
                                                                        <label>Garage Outside Pics</label>
                                                                    
                                            <?php
                                                                }

                                            ?>
                                                                <input type="file" class="form-control" name="back<?=$i?>" id="back<?=$i?>" style="display: none; margin-top: 10px;">

                                                                <div class="col-md-12" style="margin-bottom:10px">
                                                                    <img src="<?=$g['images']?>" id="pic<?=$i?>"> 
                                                                    <input type="hidden" name="gp<?=$i?>" value="<?=$g['id']?>"> 
                                                                </div>
                                            <?php
                                                            }
                                                            else
                                                            {
                                                                if($i==5)
                                                                {
                                            ?>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12" style="padding: 10px;">
                                                                        <label>More Garage Pics</label>
                                                                        <button type="button" id="add_pic" onclick="addPic()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                                                        <button type="button" id="remove_pic" onclick="removePic()" class="btn btn-danger" style="margin-left: 15px; display: none">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </div>
                                            <?php
                                                                }
                                                                $count++;
                                            ?>
                                                                <div class="col-md-4 col-sm-4 form-group">
                                                                    <img src="<?=$g['images']?>" id="pic<?=$i?>">
                                                                    <button type="button" name="delete" class="btn btn-danger delete" value="<?=$g['id']?>" style="position: absolute;">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                            <?php
                                                            }
                                                        }
                                                    }
                                            ?>
                                                    </div>     
                                            <?php
                                                }   
                                                else
                                                {    
                                            ?>
                                            <div class="col-md-6 row" style="clear: both">
                                                <br/><label class="col-md-12">Garage Inside Pics </label>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="file" name="front1" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <br/><input class="form-control" type="file" name="front2" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 row">
                                                <br/><label class="col-md-6">Garage Outside Pics </label>
                                                <div class="col-md-12">
                                                    <input class="form-control" type="file" name="back3" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <br/><input class="form-control" type="file" name="back4" required>
                                                </div>
                                            </div>
                                            <div class="garage_pics">
                                                <div class="col-md-12 row">
                                                    <br/>
                                                    <label class="col-md-12">
                                                        More Garage Pics 
                                                        <button type="button" id="add_pics" onclick="addPics()" class="btn btn-primary" style="margin-left: 15px">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" id="remove_pics" onclick="removePics()" class="btn btn-danger" style="margin-left: 15px; display: none">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php   
                                                } 
                                            ?>
                                        </div>
                                        
                                        <!--WORK INFORMATION-->
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><i class="fa fa-list"></i> Work Info</h3>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-xs-6 form-group">
                                                <label>Work Experience Years</label>
                                                <input class="form-control" type="number" name="years" value="<?=$years;?>" required>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>Work Experience Months</label>
                                                <input type="number" class="form-control" name="months" value="<?=$months;?>" required>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>No. of Services/Day</label>
                                                <input type="number" class="form-control" name="services" value="<?=$services;?>" required>
                                            </div>
                                            <div class="col-xs-6 form-group">
                                                <label>No. of Mechanics</label>
                                                <input type="number" class="form-control" required name="mechanics" value="<?=$mechanics;?>">
                                            </div>
                                            <div class="col-xs-12">
                                                <label>Brands Served </label>
                                                <br/>
                                                <select name="brands[]" id="brands" class="form-control selectpicker" multiple="true" data-live-search="true" required style="width: 200px">
                                                    <?php
                                                        if(isset($brand))
                                                        {
                                                            foreach ($brand as $b) 
                                                            {
                                                    ?>
                                                            <option value="<?=$b['id']?>"><?=$b['name']?></option>
                                                    <?php
                                                            }
                                                        }       
                                                    ?>
                                                </select>
                                            </div>
                                        </div><br/>
                                        
                                        <!--BRAND INFO-->
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><i class="fa fa-list"></i> Branding Info</h3>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-xs-12 row">
                                                <label class="col-xs-12">Estimated Size of Sign Board</label><br/>
                                                <div class="col-xs-6" style="clear:both">
                                                    <label>Height</label>
                                                    <input type="number" class="form-control" name="height" value="<?=$height;?>" required>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>Width</label>
                                                    <input type="number" class="form-control" name="width" value="<?=$width;?>" required>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 pull-right">
                                                <br/><label>Garage Wall Painting Area(in sq. ft.)</label>
                                                <input type="number" class="form-control" name="area" step='any' value="<?=$area;?>" style="margin-top: 5px" required>
                                            </div>
                                        </div><br/>
                                        
                                        <!--PASSWORD FORM-->
                                        <?php
                                            if(isset($vid))
                                            {
                                        ?>
                                        <div class="change_pass">
                                            <div class="form-group">
                                                <br/><label>Change Password: </label>
                                                <br/>
                                                <input class="form-check-input" type="radio" name="radio_pass" id="radio_pass" value="no" checked>
                                                <label>No</label>
                                                <input class="form-check-input" type="radio" name="radio_pass" id="radio_pass" value="yes">
                                                <label>Yes</label>
                                            </div><br>
                                        </div>

                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                                <div class="add_pass">
                                                    <div class="form-group">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title"><i class="fa fa-lock"></i> Add Password</h3>
                                                        </div>
                                                        <div class="row new_pass">
                                                            <div class="col-xs-6 form-group">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control" name="pass" required>
                                                            </div>
                                                            <div class="col-xs-6 form-group">
                                                                <label>Confirm Password: </label>
                                                                <input type="password" name="cpass" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                </div>

                                        <?php
                                            }
                                        ?>
                                        <div class="form-group">
                                            <input type="hidden" name="edit" value="<?=$vid?>">
                                            <button class="btn btn-primary" value="1" type="submit" name="submit">Submit</button>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 


<?php
    require_once 'js-links.php';
?>

<script>
    $(document).ready(function() { 
        $('#brands').selectpicker();
});
    $("#gtype").attr('selected',false); 
    $("#gtype option[value='<?=$garage_type?>']").attr('selected',true); 

    $("#state").attr('selected',false); 
    $("#state option[value='<?=$state?>']").attr('selected',true); 

    $("#gvt1").attr('selected',false); 
    $("#gvt1 option[value='<?=$govt1?>']").attr('selected',true); 
    
    $("#gvt2").attr('selected',false); 
    $("#gvt2 option[value='<?=$govt2?>']").attr('selected',true);  

    var id1 = $("#gvt2").attr('selected',true).val();
    $("#gvt1 option[value='"+id1+"']").attr('disabled',true).css('background-color','lightgrey');
 
    var id2 = $("#gvt1").attr('selected',true).val();
    $("#gvt2 option[value='"+id2+"']").attr('disabled',true).css('background-color','lightgrey');

    $("#gvt1").change(function()
    {
        $("#gvt2 option").attr('disabled',false).attr('selected',false).css('background-color','white');
        var id = $("#gvt1").attr('selected',true).val();
        $("#gvt2 option[value='"+id+"']").attr('disabled',true).css('background-color','lightgrey');   
    });

    $("#gvt2").change(function()
    {
        $("#gvt1 option").attr('disabled',false).css('background-color','white');
        var id = $("#gvt2").attr('selected',true).val();
        $("#gvt1 option[value='"+id+"']").attr('disabled',true).css('background-color','lightgrey');   
    });

    var state = '';
    state = $("#state").attr('selected',true).val();
    <?php
        if(isset($cities))
        {
            foreach ($cities as $c) 
            {
    ?>
                if(state == '<?=$c['state']?>')
                    $('#city').append('<option value="<?=$c['city']?>"><?=$c['city']?></option>')    
    <?php
            }
        }       
    ?>
    $("#city").attr('selected',false); 
    $("#city option[value='<?=$city?>']").attr('selected',true); 

    $("#state").change(function()
    {
        $('#city').html('');
        state = $("#state").attr('selected',true).val();
        <?php
            if(isset($cities))
            {
                foreach ($cities as $c) 
                {
        ?>
                    if(state == '<?=$c['state']?>')
                        $('#city').append('<option value="<?=$c['city']?>"><?=$c['city']?></option>')    
        <?php
                }
            }       
        ?>
    });
    
    <?php
        if(isset($brands))
        {
            foreach ($brands as $br) 
            {
    ?>
                $("#brands option[value='<?=$br['brand_id']?>']").attr('selected',true); 
    <?php
            }
        }       
    ?>

    $("input[type='radio']").click(function()
    {
        var radioValue = $("input[name='radio_pass']:checked").val();
        if(radioValue == 'yes')
        {
            $('.change_pass').append(`<div class="row new_pass">
                                        <div class="col-xs-6 form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="pass" required>
                                        </div>
                                        <div class="col-xs-6 form-group">
                                            <label>Confirm Password: </label>
                                            <input type="password" name="cpass" class="form-control" required>
                                        </div>
                                    </div>`);
        }
        else
        {
            $('.new_pass').remove();
        }
    }); 

    $('.add1').click(function()
    {
        $('#images1').css('display','');
    });
    $('.add2').click(function()
    {
        $('#images2').css('display','');
    });
    $('#pic1').click(function()
    {
        $('#front1').trigger('click');
    });
    $('#pic2').click(function()
    {
        $('#front2').trigger('click');
    });
    $('#pic3').click(function()
    {
        $('#back3').trigger('click');
    });
    $('#pic4').click(function()
    {
        $('#back4').trigger('click');
    });
    $('#images1').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img1').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }    
    });

    $('#images2').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img2').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }    
    });
    $('#front1').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pic1').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }    
    });
    $('#front2').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pic2').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }    
    }); 
    $('#back3').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pic3').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }    
    });  
    $('#back4').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pic4').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }    
    });  

    $('.delete').click(function()
    {
        var delete_id = $('.delete').val();
        $.ajax(
        {
            type: 'POST',
            url: 'ajax_vendor.php',
            data: {'delete_id': delete_id},
            success:function(msg)
            {
                alert(msg)
                if(msg != 'error')
                {
                    location.reload();
                }  
            }
        });
    });

    var count = <?=$count?>;
    var temp = <?=$count?>;

    function addPic()
    {
        $('#remove_pic').css('display','');
        count++;
        $('.add_edit').append(`<div class="col-md-6 col-sm-6 form-group extra_pic">
                                    <input type="file" class="form-control" name="extra[]">
                                </div>`);
        if(count>=6)
        {
            $('#add_pic').hide();
        }
    }
    function removePic()
    {
        if(count>0)
        {
            count--;
        }
        if(count<6)
        {
            $('#add_pic').show();
        }
        if(count == temp)
        {
            $('#remove_pic').hide();   
        }
        $('.add_edit .extra_pic').last().remove();
    }
    

    var c=0;
    function addPics()
    {
        
        if(c<6)
        {
            $('.garage_pics').append(`<div class="col-md-6 col-sm-6 form-group pics">
                                        <input type="file" class="form-control" name="images[]"> 
                                      </div>`);
            c++;
        }
        if(c>0)
        {
            $('#remove_pics').css('display','');
        }
    }
    function removePics()
    {
        if(c > 0)
        {
            c--;
            if(c == 0)
            {
                $('#remove_pics').css('display','none');
            }
        }
        $('.garage_pics .pics').last().remove();
    }
</script>
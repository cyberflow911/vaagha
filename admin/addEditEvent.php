<?php
    require_once 'header.php';
    require_once 'navbar.php';
require_once 'left-navbar.php';

    if(isset($_POST['edit'])){
        $name = test_input($_POST['college']);
        $long_description = test_input($_POST['long_description']);
        $map = test_input($_POST['map']);
        $id = $name;
        $fee = test_input($_POST['fee']);
        $f_ids =  $_POST['facilty'];
       
            $f = implode(",",$f_ids);
           $sql = "update college_list set  clg_desc='$long_description',clg_map='$map',f_ids='$f',fee='$fee'  where id = $name";
        if($conn->query($sql))
        { 
            $success = true;    
            if(isset($_FILES['image']) && !empty($_FILES['image']['name'][0]))
            {
                $extension=array("jpeg","jpg","png","gif");
                foreach($_FILES["image"]["tmp_name"] as $key=>$tmp_name) 
                {
                    $file_name=$_FILES["image"]["name"][$key];
                    $file_tmp=$_FILES["image"]["tmp_name"][$key];
                    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                    if(in_array($ext,$extension)) 
                    {
                        $filename=basename($file_name,$ext);
                        $newFileName=$filename.time().".".$ext;
                        if(move_uploaded_file($file_tmp=$_FILES["image"]["tmp_name"][$key],"uploads/".$newFileName))
                        {
                            $sql="insert into clg_img(c_id,image) values('$id','$newFileName')";
                            if($conn->query($sql)===true)
                            {
                                $status=true;
                            }
                            else
                            {
                                $status=false;
                                break;
                            }
                        }
                        else
                        {
                            $status=false;
                            break;
                        }
                    }
                    else 
                    {
                        array_push($error,"$file_name, ");
                    }
                }
                
                if(isset($status))
                {
                    $success = true;
                }
                else
                {
                    $error= "Some Images Are Not Uploaded";
                }
            }
        }else{
            $error = $conn->error;
        }

    }

//    if(isset($_POST['add'])){
//        $name =test_input($_POST['college']);
//        $long_description = test_input($_POST['long_description']); 
//        $f_ids = test_input($_POST['facilty']);
//        $clg_map = test_input($_POST['map']);
//        $f = implode(",",$f_ids);
//        $sql = "insert into college_list(name,clg_desc,clg_map,f_ids) 
//                values('$name','$long_description','$clg_map','$f')";
//        if($conn->query($sql)){
//            $id=$conn->insert_id;
//            if(isset($_FILES['image']))
//            {
//                $extension=array("jpeg","jpg","png","gif");
//                foreach($_FILES["image"]["tmp_name"] as $key=>$tmp_name) 
//                {
//                    $file_name=$_FILES["image"]["name"][$key];
//                    $file_tmp=$_FILES["image"]["tmp_name"][$key];
//                    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
//
//                    if(in_array($ext,$extension)) 
//                    {
//                        $filename=basename($file_name,$ext);
//                        $newFileName=$filename.time().".".$ext;
//                        if(move_uploaded_file($file_tmp=$_FILES["image"]["tmp_name"][$key],"uploads/".$newFileName))
//                        {
//                            $sql="insert into clg_img(c_id,image) values('$id','$newFileName')";
//                            if($conn->query($sql)===true)
//                            {
//                                $status=true;
//                            }
//                            else
//                            {
//                                $status=false;
//                                break;
//                            }
//                        }
//                        else
//                        {
//                            $status=false;
//                            break;
//                        }
//                    }
//                    else 
//                    {
//                        array_push($error,"$file_name, ");
//                    }
//                }
//                
//                if(isset($status))
//                {
//                    $success = true;
//                }
//                else
//                {
//                    $error= "Some Images Are Not Uploaded";
//                }
//            }
//        }else{
//            $error = "Unable To Add Product";
//        }
//        
//        
//    }
//    
    $name="";
  
    $long_description="";
    $required="required";
    $f_ids = '';
    $clg_map = '';
    if(isset($_GET['token']) && !empty($_GET['token']))
    {
       $event_id = test_input($_GET['token']);
       $sql = "Select * from college_list where id = $event_id";
       if($result = $conn->query($sql)){
           if($result->num_rows > 0){
               $data = $result->fetch_assoc();
               $name=$data['name'];
             
               $long_description = $data['clg_desc'];
               $required="";
               $f_ids = $data['f_ids'];
               $clg_map =  $data['clg_map'];
           }
           else{
                $request = "Invalid Request";
            }
       }else{
           $error = true;
       }
    }
    
    if(isset($data))
    {
        $sql="select id,c_id,image from clg_img where c_id=".$_GET['token'];
        $result=$conn->query($sql);
        if($result->num_rows > 0)
        {
            while($row=$result->fetch_assoc())
            {
                $tImages[]=$row;
            }
        }
    }

$sql = "select * from college_list"; 
$result=$conn->query($sql);
if($result->num_rows > 0)
{
    while($row=$result->fetch_assoc())
    {
        $cNames[]=$row;
    }
}

$sql = "select * from clg_facilities"; 
$result=$conn->query($sql);
if($result->num_rows > 0)
{
    while($row=$result->fetch_assoc())
    {
        $cFac[]=$row;
    }
}
    
?>
<div class="card-default content-wrapper card-body ">
<section>
    <?php
        if(isset($success))
        {
        ?>
    <div class="alert alert-success"><strong>Success! </strong> Your Request Successfully Updated.</div>
      <?php
        }
        else if(isset($error))
        {
        ?>
    <div class="alert alert-danger"><strong>Error! </strong>Due to Some Reasons.<?=$error?></div>
    <?php          
        }
        ?>
</section>
<!--Vendor Details-->
<div class="card-header">
    <h3 class="card-title">Event
    <?php 
        if(isset($request))
        {
        ?>
    <span style="color:#d32535">(Invalid Request)</span>
    <?php 
        }
        ?>
    </h3>
</div>
<!-- /.card-header -->
<div class="card-body" style="margin:10px">
    <form method="post" enctype="multipart/form-data" target="_self">
        <div class="row">
           
            
            <div class="col-md-12">
                <label>Select College</label>
                <select id="college" title="Choose one of the following..." class="form-control selectpicker"  data-live-search="true" name="college" > 
                      <?php
                        if(isset($cNames))
                        {
                            foreach($cNames as $sub)
                            {
                        ?>
                                <option value="<?=$sub['id']?>"><?=$sub['name']?></option>
                        <?php
                            }
                        }
                      ?>   
                </select>
            </div>
            
            <div class="col-md-12">
                <label>Select College Facilities</label>
                <select id="facilty" title="Choose one of the following..." class="form-control selectpicker"  data-live-search="true" name="facilty[]" multiple > 
                      <?php
                        if(isset($cFac))
                        {
                            foreach($cFac as $sub)
                            {
                        ?>
                                <option value="<?=$sub['id']?>"><?=$sub['facilty']?></option>
                        <?php
                            }
                        }
                      ?>   
                </select>
                </div>
             
    
            <br>
            <div class="col-md-12">
                <br/><label>Long Description</label>
                <textarea class="form-control" id="long_description" name="long_description" required rows="3" style="resize:none"><?=$long_description?></textarea>
            </div>
            <div class="col-md-12">
                <br/><label>College Map</label>
                <input class="form-control" id="map" name="map" required />  
            </div>
            <div class="col-md-12">
                <br/><label>College Fee</label>
                <input type="number" class="form-control" id="fee" name="fee" required />  
            </div>
            <div class="col-md-12" id='imagesection'>
                <br/><label>Images</label>
                <button type="button" onclick="add_field()" class="btn btn-primary" style="margin-left:7px">
                    <i class="fa fa-plus"></i>
                </button>
                <button type="button" id="rmv_btn" onclick="remove_field()" class="btn btn-danger" style="margin-left:7px; display:none">
                    <i class="fa fa-minus"></i>
                </button>
                <?php
                    if(isset($tImages))
                    {
                ?>
                    <div class="row">
                       <br/>
                        <?php
                            foreach($tImages as $t)
                            {
                        ?>
                        <div class="col-md-3 remove<?=$t['id'];?>">
                            <img class="lazy" src="uploads/lloader.gif" data-src="uploads/<?=$t['image']?>" style="max-width:250px">
                        </div>
                        <div class="col-md-1 remove<?=$t['id'];?>">
                            <button type="button" name="del" class="btn btn-danger delImage" src="<?=$t['image']?>" onclick="delete_image(<?=$t['id'];?>)" value="<?=$t['id'];?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <br/>
                <?php
                    }
                ?>
                
                <div id="all_images" class="row">
                    <div class="col-md-8">
                        <br/>
                        <input type="file" class="form-control" name="image[]" <?=$required?> >
                    </div>
                </div>
                
                
                
               
                
            </div>
            <!-- /.col -->
            <div class="col-md-12">
                <div class="form-group">
                    <br>
 
                            <button type="submit" id="edit" name="edit" value="<?=$data['id'];?>" class="btn btn-primary pull-right" onclick="return confirm('Do you want to save the changes? Y/N')">Save Changes</button>
 
                </div>
                <!-- /.form-group -->
            </div>
        <!-- /.row -->
        </div>
    </form>
</div>
<!-- /.card-body -->
</div>
<?php
 
    require_once 'js-links.php';
    ?>
<script>
      $(document).ready(function(){
        CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');    	
    });
    function add_field()
    {
        var inhtml=`<div class="col-md-8">
                        <br/><input type="file" class="form-control" name="image[]">
                    </div>`;
        
        if($("#all_images div").length == 1)
        {
            $("#rmv_btn").show();
        }
        
        $("#all_images").append(inhtml);
    }  
    
    function remove_field()
    {
        
        if($("#all_images div").length == 1)
        {
            $("#rmv_btn").hide();
        }
        else
        {
            $("#all_images div:last").remove();
            if($("#all_images div").length == 1)
            {
                $("#rmv_btn").hide();
            }
        }
    }
    
    function delete_image(id){
        if(confirm("Do You Really Want To Delete This Image?"))
        {
               $.ajax({
                    type:"POST",
                    url:"$.ajax.php",
                    data:{
                        img_id:id,
                        },
                    contentType: "application/x-www-form-urlencoded",
                    success: function(data){
                          var obj = JSON.parse(data);
                          if(obj.msg=="ok")
                          {
                             window.location.assign(window.location.href);
                          }
                      }
                });
        }
    }
     
</script>
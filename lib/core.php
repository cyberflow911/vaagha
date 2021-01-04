<?php
    session_start();
    require_once'PHPMailer/PHPMailerAutoload.php';
    require_once'config.php';   

//check page setting
function check_page($id,$conn)
{
    $sql="select * from services where link='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
       return true;
    else
    {
        header("location:error.php");
        die();
    }
}
 

 
//check user authpage
function user_auth($page,$type)
{
    if($page!=$type)
        header("location:logout");
   
}

 
 

//login method
    function login($email,$password,$conn,$path)
    {
        $sql="select id from com_admins where email='$email' and password='$password'";
        $res=$conn->query($sql);
        if($res->num_rows > 0)
        {
            $row=$res->fetch_assoc();  
            $id=$row['id']; 
            header("location: $path");
            $_SESSION['com_admin_signed_in']=$email;
            $_SESSION['id']=$id; 
        }
        else
        {
            return false;
    
        }
        return true;
    }
//login method
function master_admin_login($email,$password,$conn,$path)
{
    $sql="select id from master_admin where email='$email' and password='$password'";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc();  
        $id=$row['id']; 
        header("location: $path");
        $_SESSION['master_admin_signed_in']=$email;
        $_SESSION['id']=$id; 
    }
    else
    {
        return false;

    }
    return true;
}
//user login
   function user_login($email,$password,$conn,$user,$path)
    {
         $sql="select email from users where email='$email' and password='$password' and type=$user";
        $res=$conn->query($sql);
        if($res->num_rows > 0)
        {
          $_SESSION['signed_in']=$email;
            setcookie("new",$email, time() + (86400 * 80), "/");   
			setcookie("pass",$password, time() + (86400 * 80), "/");  
            
            if(isset($_SESSION['page']))
            {
                $page_url=$_SESSION['page'];
                unset($_SESSION['page']);
                header("location: home");
            }
            else
            {
              header("location: $path"); 
            }
        }
        else
        return false;
    }
 
 //check for cookie login
    function cookie_login($conn)
    {
        if (!isset($_SESSION['signed_in']))
        {  
            if(isset($_COOKIE["new"]) && isset($_COOKIE["pass"]))
            {
                $email=$_COOKIE["new"];
                $pass=$_COOKIE["pass"];
                $sql= "select email from users where email='$email' and password='$pass'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
	               $_SESSION['signed_in']=$email;
                }
        
            }

        }
    }

//method for auth
    function auth()
    {
        if (!isset($_SESSION['com_admin_signed_in']))
        {
            if($_SERVER['REQUEST_URI']!='/login')
            {
                $_SESSION['page']=$_SERVER['REQUEST_URI'];   
            }
            return false; // IMPORTANT: Be sure to exit here!
        }
        else
        {
            session_regenerate_id(true);
            return true;
        }
    }
    
    
    function master_admin_auth()
    {
        if (!isset($_SESSION['master_admin_signed_in']))
        {
            if($_SERVER['REQUEST_URI']!='/login')
            {
                $_SESSION['page']=$_SERVER['REQUEST_URI'];   
            }
            return false; // IMPORTANT: Be sure to exit here!
        }
        else
        {
            session_regenerate_id(true);
            return true;
        }
    }

 

  
//if user already login
    function auto_redirect($conn)
    {
        if(isset($_SESSION['com_admin_signed_in']))
        {
            $email=$_SESSION['com_admin_signed_in'];
            $sql="select * from com_admins where email='$email'";
            $res=$conn->query($sql);
            if($res->num_rows > 0)
            {
                $row=$res->fetch_assoc(); 
                header("location: dashboard"); 
            }
        }
    }
    
    
    function master_auto_redirect($conn)
    {
        if(isset($_SESSION['master_admin_signed_in']))
        {
            $email=$_SESSION['master_admin_signed_in'];
            $sql="select * from master_admin where email='$email'";
            $res=$conn->query($sql);
            if($res->num_rows > 0)
            {
                $row=$res->fetch_assoc(); 
                header("location: dashboard"); 
            }
        }
    }
//user login redirect
function user_redirect($path)
{
    if(isset($_SESSION['signed_in']))
    {
        header("location: $path");
    }
}

//check token
function check_token($token)
{
    if(!isset($token))
    {
        header("location:404");
    }
}

//change pass
    function change_pass($pass,$npass,$cpass,$conn)
    {
        $email=$_SESSION['signed_in'];
        $getdata="select password from users where email='$email' and password='$pass'";
        $result=$conn->query($getdata);
        if ($result->num_rows > 0) 
        {
            if($npass==$cpass)
            {
                $ss="update users set password='$npass' where email='$email'";
                if($conn->query($ss)===true)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

//user Registration

function registration($f_name,$l_name,$contact,$email,$pass,$type,$conn)
{
   
        $sql="insert into users (email,password,type) values('$email','$pass',$type)";
        if($conn->query($sql)===true)
        {
            $u_id = $conn->insert_id;
            $sql="insert into user_profiles(u_id,f_name,l_name,contact,profile_pic,status) values($u_id,'$f_name','$l_name','$contact','user.png','Enabled')";
            if($conn->query($sql)===true)
            {
               return true;
            }
            else{
                 
               return false;
            }
        }
        else
        {
             return false;
        }
}

function upload_image($files)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.$_FILES['images']['name'];
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
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

function upload_image_cp($files,$path)
{
     $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
         
        
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        $fileName = time().'.'.$file_extension;
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "application/pdf") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = $path.$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
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

//upload file 
function upload_file($files,$conn,$r_id)
{
    $uploadedFile = '';
    if(!empty($_FILES["type"]))
    {
        $fileName = time().'_'.str_replace(' ','-',$_FILES['name']);
        $valid_extensions = array("jpeg", "jpg", "png","pdf","bmp","JPG");
        $temporary = explode(".", $_FILES["name"]);
        $file_extension = end($temporary);
        if((($_FILES["type"] == "image/png") || ($_FILES["type"] == "application/pdf") || ($_FILES["type"] == "image/bmp") || ($_FILES["type"] == "image/jpg") || ($_FILES["type"] == "image/JPG") || ($_FILES["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
				if($_FILES["type"] != "application/pdf")
				{
					$image = imagecreatefromjpeg($targetPath);
            		imagejpeg($image,$targetPath,60);
				}
                $uploadedFile = $fileName;
                $sql="insert into documents_upload(p_id,src) values('$r_id','$uploadedFile')";

                if($conn->query($sql)===true)
                {
                    return "yes";
                }
                else
                {
                    return $conn->error;
                }
            }
        }
    }
}


function upload_imageu($files,$conn,$table,$column,$id) 
{
    $uploadedFile = 'err';
    if(!empty($_FILES['images']["type"]))
    {
        $fileName = time().'_'.str_replace(' ', '',$_FILES['images']['name']);
        $valid_extensions = array("jpeg", "jpg", "png","bmp","JPG");
        $temporary = explode(".", $_FILES['images']["name"]);
        $file_extension = end($temporary);
        if((($_FILES['images']["type"] == "image/png") || ($_FILES['images']["type"] == "image/bmp") || ($_FILES['images']["type"] == "image/jpg") || ($_FILES['images']["type"] == "image/JPG") || ($_FILES['images']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions))
        {
            $sourcePath = $_FILES['images']['tmp_name'];
            $targetPath = "uploads/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                $uploadedFile = $fileName;
                if(isset($table))
                {
                    $sql="update $table set $column='$targetPath' where id=$id";
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

function upload_image2($files,$conn,$table,$column,$id,$image)
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
                    $sql="update $table set $column='$targetPath' where id=$id";
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

// function the show cart details
function cart_view($conn)
{
     $sum=0;
     $total_items=0;
    if(isset($_SESSION["products"]))
    {
        $total_items = count($_SESSION["products"]);
        $ac="";
        if($total_items>0)
        {
           // print_r($_SESSION['products']);
            foreach($_SESSION["products"] as $key=>$product)
            {
                $p_id=$product["product_code"];
                if(isset($p_id))
                {
                    
                    if(isset($product['options']) && !empty($product['options']))
                    {
                        $price=0;
                        foreach($product['options'] as $option)
					    {
					        $sql="select pov.amount from product_options po, product_option_value pov, input_values iv where ";
                            $sql.="pov.p_o_id= po.id and po.p_id=$p_id and po.option_id=iv.option_id and iv.option_value='$option' and ";
                            $sql.="pov.o_value_id=iv.id";
                            
                            
                        //   ec $sql="select amount from product_option_value where o_value_id=(select id from input_values where option_value='$option')";
                            $res=$conn->query($sql);
                            if($row=$res->fetch_assoc())
                            {   
                                $price+=$row['amount'];
                            }
					    }
                    }
                    else
                    {
                        $sql="select price from products where id=$p_id";
                        $res=$conn->query($sql);
                        if($row=$res->fetch_assoc())
                        {   
                            $price=$row['price'];
                        }
                    }
					$op="";
					foreach($product['options'] as $option)
					{
						$op.= "( ".$option." )";
					}
                    $sum=$sum+($price*$product["quantity"]);
                    $name=$product["product_name"];
                    $src=$product['src'];
                    $quantity=$product["quantity"];
                    $code_id=$key;
                    $ac .="<div class='dropdown-product-item'><span class='dropdown-product-remove'><i class='icon-cross' onclick='remove(".$code_id.");'></i></span><a class='dropdown-product-thumb' href='shop-single?token=".str_replace(' ','-',$name)."'><img src=vendor/admin/uploads/".$src." alt='Product' style='max-height:50px'></a>
                      <div class='dropdown-product-info'><a class='dropdown-product-title' href='shop-single?token=".str_replace(' ','-',$name)."' style=font-size:12px>".$name." ".$op."</a> <span class='dropdown-product-details' style=font-size:12px>".$quantity." x ".$price." =  <b>₹ ".$quantity * $price."</b></span></div></div>";
                    }
            }
       
            $cart_item['cart']=$ac;
             $_SESSION["products"][$key]["product_price"]=$price;
        }
        else
        {
         $cart_item['cart']="<center><img src='img/no.png' style='width:80px;height:80px'></center>";
        }
    }
    else
        {
         $cart_item['cart']="<center><img src='img/no.png' style='width:80px;height:80px'></center>";
        }
     $cart_item['items']=$total_items;
    $cart_item['price']="₹ ".$sum;
    return $cart_item;
}

// function for add user cart value in the cart
function login_cart($conn,$id)
{
    //get the data from user account
    $sql="select cart.cart_id as cart_id,cart.product_quantity,products.price,cart.p_id,products.name from products,cart where cart.u_id=$id and products.id=cart.p_id";
    $result=$conn->query($sql);
    if($result->num_rows > 0)
    {
         $x=0;
         while($rows = $result->fetch_assoc()) 
         {
             $new_product[$x]['product_name']=$rows['name'];
             $new_product[$x]['product_code']=$rows['p_id'];
             $new_product[$x]['quantity']=$rows['product_quantity'];
             $new_product[$x]['product_price']=$rows['price'];
             $new_product[$x]['cart_id']=$rows['cart_id'];
             $p_id=$rows['p_id'];
             $cart_id=$rows['cart_id'];
     
             $sql="select * from documents_upload where p_id=$p_id limit 1";
             $res=$conn->query($sql);
             if($res->num_rows > 0)
             {
                 while($row1=$res->fetch_assoc())
                     $new_product[$x]['src']=$row1['src'];
             }
            
       		 $sql="select * from cart_product_options where cart_id=$cart_id";
             $res=$conn->query($sql);
             if($res->num_rows > 0)
             {
                 while($row5=$res->fetch_assoc())
				   $new_product[$x]['options'][$row5['option_name']]=$row5['option_value'];
			 }
            $x++;
          }
     }
    
    //check if user acount cart not empty
    if(isset($new_product))
    {
        //check local session is set or not
        if(!isset($_SESSION["products"]))
        {
            foreach($new_product as $cartdata)
            {
				//push the data in session
                $_SESSION["products"][]=$cartdata;
            }
        }
        else
        {
            if(isset($_SESSION["products"]))
            {
                foreach($new_product as $cartdata)
                {
					$product_code=$cartdata['cart_id'];
					if(in_array($product_code, array_column($_SESSION['products'],'cart_id')))
					{
						foreach($_SESSION['products'] as $k=>$value)
						{
							$cart_id=$cartdata['cart_id'];
							$quantity=$_SESSION["products"][$k]['quantity'];
                        	if($quantity!=$cartdata['quantity'])
                        	{
                            	$sql="update cart set product_quantity=$quantity where cart_id=$cart_id";
                            	if($conn->query($sql)===true)
                            	{   
                                	//unset old item
                            	}
								else
                            	{
                               		echo $conn->error;
                            	}
							}
                    	}
                    } 
					else
                    {
                       	$_SESSION["products"][]=$cartdata;
						break;
                    } 
				}
				
				foreach($_SESSION['products'] as $key=>$pp)
				{
					$c_id=$pp['cart_id'];
					if($c_id=="")
					{
						$quantity=$pp['quantity'];
                		$p_id=$pp['product_code'];
                		$u_id=$id;
                		$sql="insert into cart (u_id,p_id,product_quantity) values($u_id,$p_id,$quantity)";
                		if($conn->query($sql)===true)
                		{
							$last_id = $conn->insert_id;	//update products with new item array
							$_SESSION["products"][$key]['cart_id']=$last_id;
					 		foreach($pp['options'] as $x=>$po)
                    		{
                        		$sql="insert into cart_product_options(cart_id,option_name,option_value) values($last_id,$x,'$po')";
                        		$conn->query($sql);
                    		}
						}
					}	
				}
            }
        }
    }
    else
    {
        if(isset($_SESSION["products"]))
        {
            $result=$_SESSION['products'];
            foreach($result as $key=>$result)
            {
                $quantity=$result['quantity'];
                $p_id=$result['product_code'];
                $u_id=$id;
                $sql="insert into cart (u_id,p_id,product_quantity) values($u_id,$p_id,$quantity)";
                if($conn->query($sql)===true)
                {
                    $last_id = $conn->insert_id;	//update products with new item array
					$_SESSION["products"][$key]['cart_id']=$last_id;
					foreach($result['options'] as $x=>$po)
                    {
                        $sql="insert into cart_product_options(cart_id,option_name,option_value) values($last_id,$x,'$po')";
                        $conn->query($sql);
                    }
                }
				
            } 
        }
    }

    if(isset($new_product))
    {
        return $new_product;
	}
}


//function for forget password.

function forget_pass($conn,$contact)
{
    $sql="select email from users where id=(select u_id from user_profiles where contact='$contact')";
    $res=$conn->query($sql);
    if($res->num_rows > 0)
    {
        $row=$res->fetch_assoc();
		$email=$row['email'];
		return $email;
    }
    else
    {
        return false;
    }
}

//function for change the password
function update_pass($conn,$contact,$pass)
{
    $sql="update users set password='$pass' where id=(select u_id from user_profiles where contact='$contact')";
    if($conn->query($sql)===true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function createDir($path)
{		
	if (!file_exists($path)) 
    {
		$old_mask = umask(0);
		mkdir($path, 0777, TRUE);
		umask($old_mask);
	}
}


//update info for place orders
function update_place_order($conn,$order_id)
{
    $sql="update orders set order_status='placed' where order_id='$order_id'";
    if($conn->query($sql)===true)
    {
		$sql="update order_items set order_item_status='placed' where o_id=(select id from orders where order_id='$order_id')";
    	if($conn->query($sql)===true)
    	{
        	$sql="update payment_log set status='Success' where o_id=(select id from orders where order_id='$order_id')";
        	if($conn->query($sql)===true)
        	{
            	$sql="delete from cart where u_id=(select u_id from orders where order_id='$order_id')";
            	if($conn->query($sql)===true)
            	{
                	unset($_SESSION["products"]);
                	return true;
				}
        	}
        	else
        	{
            	return false;
        	}
		}
		else
		{
			return false;
		}
    }
    else
    {
          return false;
    }
}


function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
	/* read the source image */
	$source_image = FALSE;
	
	if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
		$source_image = imagecreatefromjpeg($path1);
	}
	elseif (preg_match("/png|PNG/", $file_type)) {
		
		if (!$source_image = @imagecreatefrompng($path1)) {
			$source_image = imagecreatefromjpeg($path1);
		}
	}
	elseif (preg_match("/gif|GIF/", $file_type)) {
		$source_image = imagecreatefromgif($path1);
	}		
	if ($source_image == FALSE) {
		$source_image = imagecreatefromjpeg($path1);
	}

	$orig_w = imageSX($source_image);
	$orig_h = imageSY($source_image);
	
	if ($orig_w < $new_w && $orig_h < $new_h) {
		$desired_width = $orig_w;
		$desired_height = $orig_h;
	} else {
		$scale = min($new_w / $orig_w, $new_h / $orig_h);
		$desired_width = ceil($scale * $orig_w);
		$desired_height = ceil($scale * $orig_h);
	}
			
	if ($squareSize != '') {
		$desired_width = $desired_height = $squareSize;
	}

	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	// for PNG background white----------->
	$kek = imagecolorallocate($virtual_image, 255, 255, 255);
	imagefill($virtual_image, 0, 0, $kek);
	
	if ($squareSize == '') {
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
	} else {
		$wm = $orig_w / $squareSize;
		$hm = $orig_h / $squareSize;
		$h_height = $squareSize / 2;
		$w_height = $squareSize / 2;
		
		if ($orig_w > $orig_h) {
			$adjusted_width = $orig_w / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
		}

		elseif (($orig_w <= $orig_h)) {
			$adjusted_height = $orig_h / $wm;
			$half_height = $adjusted_height / 2;
			imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
		} else {
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
		}
	}
	
	if (@imagejpeg($virtual_image, $path2, 90)) {
		imagedestroy($virtual_image);
		imagedestroy($source_image);
		return TRUE;
	} else {
		return FALSE;
	}
}	
function number_to_words($num)
{ 
    $ones = array( 
    1 => "one", 
    2 => "two", 
    3 => "three", 
    4 => "four", 
    5 => "five", 
    6 => "six", 
    7 => "seven", 
    8 => "eight", 
    9 => "nine", 
    10 => "ten", 
    11 => "eleven", 
    12 => "twelve", 
    13 => "thirteen", 
    14 => "fourteen", 
    15 => "fifteen", 
    16 => "sixteen", 
    17 => "seventeen", 
    18 => "eighteen", 
    19 => "nineteen" 
    ); 
    $tens = array( 
    1 => "ten",
    2 => "twenty", 
    3 => "thirty", 
    4 => "forty", 
    5 => "fifty", 
    6 => "sixty", 
    7 => "seventy", 
    8 => "eighty", 
    9 => "ninety" 
    ); 
    $hundreds = array( 
    "hundred", 
    "thousand", 
    "million", 
    "billion", 
    "trillion", 
    "quadrillion" 
    ); //limit t quadrillion 
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i)
    { 
        if($i < 20)
        { 
            $rettxt .= $ones[$i]; 
        }
        elseif($i < 100)
        { 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
        }
        else
        { 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0)
        { 
            $rettxt .= " ".$hundreds[$key]." "; 
        } 
    } 
    if($decnum > 0)
    { 
        $rettxt .= " and "; 
        if($decnum < 20)
        { 
            $rettxt .= $ones[$decnum]; 
        }
        elseif($decnum < 100)
        { 
            $rettxt .= $tens[substr($decnum,0,1)]; 
            $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        } 
    } 
return ucwords($rettxt); 
}

function image_category()
{
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);
    $page = end($link_array);
    switch($page)
    {
        case 'createEditBlog.php':
            return 'Blogs';
    }
     
    
}
// find the vendor commision
function get_commission($conn,$p_id)
{
    $sql="select price,branch_commision,com_type from products where id=$p_id";
    $res=$conn->query($sql);
    $row = $res->fetch_assoc();
    if(strtolower($row['com_type']) == "percentage")
    {
        $commision=$row['price']*$row['branch_commision']/100;
    }
    else
    {
        $commision=$row['branch_commision'];
    }
    return $commision;
}

//function for get discount from coupon code

function coupon_code($coupon_code,$conn)
{
    unset($_SESSION['coupon_code']);
    $sql="select * from coupons where code = '$coupon_code' "; // check coupon code valid
        $res=$conn->query($sql);
        if ($res->num_rows > 0) 
        {
           
            $current_date=date('Y/m/d'); //take date from system
            $row=$res->fetch_assoc();
            $response['id']=$row['id'];
            
            //condition for check coupon dates are valid
            if(strtotime($row['start'])<=strtotime($current_date) && strtotime($row['end'])>=strtotime($current_date) )
            {   
                 
                $sql="select count(*) as per_coupon from coupon_uses where coupon_id = (select id from coupons where code = '$coupon_code') and coupon_status=1";
                $res=$conn->query($sql);
                if($res->num_rows <= $row['percoupon'])  //condition for check coupon per validation
                {
                     $discount_product=array(); //create discount product array
                      $x=0;
                    
                        //take product value from product session
                        if(isset($_SESSION['products']) && !empty($_SESSION['products']))
                        {
                            
                            foreach($_SESSION['products'] as $product)
                            {
                                $p_id=$product['product_code'];
                                
                                // check coupon apply category
                                $sql="select coupon_id from coupon_categories where coupon_id=(select id from coupons where code = '$coupon_code') and m_id in (select id from menus where parent or link in (select link from menus where id in(select m_id from products where id=$p_id)))";
                                $res=$conn->query($sql);
                                if ($res->num_rows > 0) 
                                {
                                    if(!in_array($p_id,$discount_product))
                                    {
                                         $discount_product[$x]=$p_id;
                                            $x++;
                                    }
                                }
                                else
                                {
                                 //check coupon apply products
                                 $sql="select coupon_id from coupon_products where coupon_id=(select id from coupons where code = '$coupon_code') and p_id = $p_id";
                                $res=$conn->query($sql);
                                if ($res->num_rows > 0) 
                                {
                                    if(!in_array($p_id,$discount_product))
                                    {
                                         $discount_product[$x]=$p_id;
                                            $x++;
                                    }
                                }
                                else
                                {
                                     $response['msg']="5";   
                                }
								}
                            }
                        }
                    else
                    {
                        $response['msg']="4";   
                    }
                        
                }
                else
                {
                    $response['msg']="3";
                }
            }
            else
            {
                $response['msg']="2";
            }
        }
        else
        {
               
             $response['msg']="Invalid Coupon Code.";
          
        }
        
        
        if(isset($discount_product))
        {
            $coupan_discount=$row['coupon_discount'];
            $coupon_type=$row['coupon_type'];
    
            $discount=0;
            foreach($discount_product as $ds_product)
            {
                if(isset($_SESSION["products"]))
                {  //if session var already exist
		            foreach($_SESSION['products'] as $x)
                    {
                        if(in_array($ds_product,$x))
                        {
                             //take product price from product session
                            $A= $product_price=$x['product_price']*$x['quantity'];
                            $discount=$discount+$product_price;
                        }
                    }
                }
                //apply coupon _type
            if($coupon_type=='Percentage')
            {
                $total_discount=$discount*$coupan_discount/100;
            }
            else
            {
                $total_discount=$coupan_discount;
            }
            }
            
            //check price is grator then extra
            
            if($total_discount>$row['max_discount'])
            {
                $response['discount']=$row['max_discount'];
            }
            else
            {
                $response['discount']=floor($total_discount);
            }
			if($response['discount']==0)
			{
				$response['msg']="This Coupon Code is not for this item";
			}
			else
			{
				//create coupon code session
				$_SESSION['coupon_code']=$coupon_code;
				$response['msg']='ok';
			}
        }
        else
        {
            $response['msg']="Invalid Coupon Code.";
        }
    return $response;
}

//function for get discount


function discount_percent($sell_price,$price)
{
    $rs_off=$price-$sell_price;
    $percentage=floor($rs_off*100/$price);
    return $percentage;
}

// function for calculate branch commitions

function calculate_commitions($p_id,$conn)
{
    $sql="select price,branch_commision,com_type from products where id=$p_id";
    $res=$conn->query($sql);
    $row=$res->fetch_assoc();
  
    if($row['com_type']=='Percentage')
    {
         $cc=$row['price']*$row['branch_commision']/100;
    }
    else
    {
        $cc=$row['branch_commision'];
    }
    return $cc;
}

//distance matrix

function GetDrivingDistance($lat1, $lat2, $long1, $long2,$google_key)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL&key=".$google_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['value']/1000;
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return  $dist;
}

//Upload multiple images 23/04/20
function upload_images($files,$conn,$table,$id_col,$column,$id,$images)
{
	if(isset($_FILES[$images]))
    {
        $extension=array("jpeg","jpg","png","gif");
        foreach($_FILES[$images]["tmp_name"] as $key=>$tmp_name) 
        {
            $file_name=$_FILES[$images]["name"][$key];
            $file_tmp=$_FILES[$images]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        
            if(in_array($ext,$extension)) 
            {
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                if(move_uploaded_file($file_tmp=$_FILES[$images]["tmp_name"][$key],"uploads/".$newFileName))
                {
                    $sql="insert into $table($id_col, $column, type) values($id,'uploads/$newFileName', 'extra')";
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
        return $status;
    }
}
						
?>


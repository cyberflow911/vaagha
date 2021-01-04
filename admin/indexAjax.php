<?php
 require_once 'header.php';
      //$u_id = $_SESSION['id'];
      $val = $_POST['val'];   
      $sql="UPDATE vendors set available = '$val' where id=$id";
      if($conn->query($sql)){
        $resultMessage=true;
      }
    else{
        $error=$conn->error;
      }
?>
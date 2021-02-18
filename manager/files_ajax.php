<?php
    require_once '../lib/core.php';



    //api for deleting project file
    if(isset($_POST['deleteFile']))
    {
        $id = $_POST['deleteFile'];
        $sql = "DELETE FROM project_files where id =$id";
        if($conn->query($sql))
        {
            echo "ok";
        }else
        {
            echo $conn->error;
        }
    }
?>
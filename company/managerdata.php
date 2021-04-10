<?php
    require_once '../lib/core.php';
    
    if(isset($_POST['managerdata']))
    {
        $id = $_POST['managerdata'];
        $sql = "select email, m_num from com_admins where id =$id";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                $res['email']=$row['email'];
                $res['m_num']=$row['m_num'];
                echo json_encode($res);
            }
        }
        else
        {
            echo $conn->error;
        }
    }
    if(isset($_POST['projectdata']))
    {
        $id = $_POST['projectdata'];
        $sql = "select project_reference, incentive from projects where id =$id";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                $res['project_reference']=$row['project_reference'];
                $res['incentive']=$row['incentive'];
                echo json_encode($res);
            }
        }
        else
        {
            echo $conn->error;
        }
    }
?>
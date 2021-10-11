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

    if(isset($_POST['checkmanager']))
    {
        $result=[];
        $id=$_POST["managerid"];
        $sql="select * from projects where pm_id='$id'";
        if($res=$conn->query($sql))
        {
            if($res->num_rows)
            {
                while($row = $res->fetch_assoc())
                {
                    $result[]=$row;
                }
                $result['msg']="yes";
            }
            else
            {
                $result['msg']="no";
            }
        }
        else
        {
            $result['msg']="error";
        }

        echo json_encode($result);
    }

    if(isset($_POST['deletemanager']))
    {
        $id=$_POST["dmanagerid"];
        $sql="delete from com_admins where id='$id'";
        if($conn->query($sql))
        {
            $result['msg']="ok";
        }
        else
        {
            $result['msg']="error";
        }
        echo json_encode($result);
    }

?>
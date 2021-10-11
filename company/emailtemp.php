<?php



require_once '../lib/core.php';



if(isset($_POST['userid']))

{

    $uid=$_POST['userid'];
    $cid=$_POST['com_id'];

    $sql="select u.*, p.title, c.m_num as pmm_num, c.email as pmemail, c.f_name as pmf_name, c.l_name as pml_name from users u, projects p, com_admins c where u.id=$uid and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id";

    $res =  $conn->query($sql);

    if($res->num_rows)

    {

        $row = $res->fetch_assoc();

            $userdata = $row;

    }

    $sql="select * from customise_email where type=2 and com_id='$cid'";

    $res =  $conn->query($sql);

    if($res->num_rows)

    {

        $row = $res->fetch_assoc();

        $useremail = $row;

    }
    else
    {
        $sql="select * from email where type=2";

        $res =  $conn->query($sql);

        if($res->num_rows)

        {

            $row = $res->fetch_assoc();

            $useremail = $row;

        }
    }

    $result['sub']=prepareMessage($useremail['subject'],$userdata['title']);

    $result['greet']=prepareMessage2($useremail['greetings'], $userdata['f_name'], $userdata['l_name'], $userdata['salutation']);

    $result['bd']=prepareMessage3($useremail['body'],$userdata['title'], $userdata['incentive'], $userdata['id']);

    $result['endgreet']=prepareMessage4($useremail['endgreetings'],$userdata['pmf_name'], $userdata['pml_name'], $userdata['pmm_num']);

    $result['user_email']=$userdata['email'];

    $result['pm_email']=$userdata['pmemail'];

    echo json_encode($result, JSON_INVALID_UTF8_IGNORE);  

}
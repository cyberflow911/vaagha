<?php
    require_once "../lib/core.php";

    if(isset($_POST['SOtp']) && isset($_POST['User']))
    {        
        function genRandStr(  $length = 5,   $prefix = '',   $suffix = '')
        {
            for($i = 0; $i < $length; $i++)
            {
                $prefix .= random_int(0,1) ? chr(random_int(65, 90)) : random_int(0, 9);
            }
            return $prefix . $suffix;
        }
        $uid=$_POST['User'];
        $m_num=$_POST['number'];
        $sql="select count(id) as count from otp";
        if($res = $conn->query($sql))
        {
            if($res->num_rows)
            {
                $count = $res->fetch_assoc()['count'];
            }else
            {
                $count = 0;
            } 
            $token = $count.genRandStr();
            $sql="insert into otp(u_id, m_num, token, status) values($uid, $m_num, '$token', 1)";
            if($conn->query($sql))
            {
                echo "success";
            }
            else
            {
                echo $conn->error;
            }
        }
        
    }

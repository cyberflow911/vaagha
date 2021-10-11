<?php

require_once '../lib/core.php';

if(isset($_POST['sendMail']) && isset($_POST['Initiate']))
{
    $emails = json_decode($_POST['emails']);
    $pms = "'".implode($emails,"','")."'";
    $sql="select u.*, p.title, c.m_num as pmm_num, c.f_name as pmf_name, c.l_name as pml_name from users u, projects p, com_admins c where u.id in ($pms) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        while($row = $res->fetch_assoc())
        {
            $userdata[] = $row;
        }
    }
    $sql="select * from email where type=2";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        $row = $res->fetch_assoc();
        $useremail = $row;
    }
    $i =1;
    $successMailCounter =0;
    foreach($userdata as $data)
    {
        $sub=prepareMessage($useremail['subject'],$data['title']);
        $greet=prepareMessage2($useremail['greetings'], $data['f_name'], $data['l_name'], $data['salutation']);
        $bd=prepareMessage3($useremail['body'],$data['title'], $data['incentive'], $data['id']);
        $endgreet=prepareMessage4($useremail['endgreetings'],$data['pmf_name'], $data['pml_name'], $data['pmm_num']);
        try {
            $mail->isHTML(true);  
            $mail->addAddress($data['email']);
            $mail->Subject = $sub;
            $mail->Body    ="<p style='font-size: 14px'>$greet</p><p style='font-size: 14px'>$bd</p><p style='font-size: 14px'>$endgreet</p>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
            $mail->send();
            $mail ->ClearAllRecipients();
            $result[$i]['msg'] =  "success";
            
            $successMailCounter++;
        }
        catch (Exception $e)
        {
              
             $result[$i]['msg'] =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
        }
        if($result[$i]['msg']=="success")
        {
            $date=date("Y-m-d");
            $sql2="update users set pay_status='1', email_date='$date' where id='".$data['id']."'";
            if($conn->query($sql2))
            {
                $resMember=true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        $i++;
    }
    $result['successCount'] = $successMailCounter;
    echo json_encode($result);  
}

if(isset($_POST['sendMail']) && isset($_POST['bankdetails']))
{
    $emails = json_decode($_POST['emails']);
    $pms = "'".implode($emails,"','")."'";
    $sql="select u.*, p.title, c.m_num as pmm_num, c.f_name as pmf_name, c.l_name as pml_name from users u, projects p, com_admins c where u.id in ($pms) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        while($row = $res->fetch_assoc())
        {
            $userdata[] = $row;
        }
    }
    $sql="select * from email where type=3";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        $row = $res->fetch_assoc();
        $useremail = $row;
    }
    print_r($useremail);
    $i =1;
    $successMailCounter =0;
    foreach($userdata as $data)
    {
        $sub=prepareMessage($useremail['subject'],$data['title']);
        $greet=prepareMessage2($useremail['greetings'], $data['f_name'], $data['l_name'], $data['salutation']);
        $bd=prepareMessage3($useremail['body'],$data['title'], $data['incentive'], $data['id']);
        $endgreet=prepareMessage4($useremail['endgreetings'],$data['pmf_name'], $data['pml_name'], $data['pmm_num']);
        try {
            $mail->isHTML(true);  
            $mail->addAddress($data['email']);
            $mail->Subject = $sub;
            $mail->Body    ="<p style='font-size: 14px'>$greet</p><p style='font-size: 14px'>$bd</p><p style='font-size: 14px'>$endgreet</p>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
            $mail->send();
            $mail ->ClearAllRecipients();
            $result[$i]['msg'] =  "success";
            
            $successMailCounter++;
        }
        catch (Exception $e)
        {
              
             $result[$i]['msg'] =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
        }
        if($result[$i]['msg']=="success")
        {
            $date=date("Y-m-d");
            $sql2="update users set pay_status='1', email_date='$date' where id='".$data['id']."'";
            if($conn->query($sql2))
            {
                $resMember=true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        $i++;
    }
    $result['successCount'] = $successMailCounter;
    echo json_encode($result);  
}

if(isset($_POST['sendMail']) && isset($_POST['tandc']))
{
    $emails = json_decode($_POST['emails']);
    $pms = "'".implode($emails,"','")."'";
    $sql="select u.*, p.title, c.m_num as pmm_num, c.f_name as pmf_name, c.l_name as pml_name from users u, projects p, com_admins c where u.id in ($pms) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        while($row = $res->fetch_assoc())
        {
            $userdata[] = $row;
        }
    }
    $sql="select * from email where type=5";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        $row = $res->fetch_assoc();
        $useremail = $row;
    }
    print_r($useremail);
    $i =1;
    $successMailCounter =0;
    foreach($userdata as $data)
    {
        $sub=prepareMessage($useremail['subject'],$data['title']);
        $greet=prepareMessage2($useremail['greetings'], $data['f_name'], $data['l_name'], $data['salutation']);
        $bd=prepareMessage5($useremail['body'],$data['title'], $data['incentive'], $data['id']);
        $endgreet=prepareMessage4($useremail['endgreetings'],$data['pmf_name'], $data['pml_name'], $data['pmm_num']);
        try {
            $mail->isHTML(true);  
            $mail->addAddress($data['email']);
            $mail->Subject = $sub;
            $mail->Body    ="<p style='font-size: 14px'>$greet</p><p style='font-size: 14px'>$bd</p><p style='font-size: 14px'>$endgreet</p>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
            $mail->send();
            $mail ->ClearAllRecipients();
            $result[$i]['msg'] =  "success";
            
            $successMailCounter++;
        }
        catch (Exception $e)
        {
              
             $result[$i]['msg'] =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
        }
        if($result[$i]['msg']=="success")
        {
            $date=date("Y-m-d");
            $sql2="update users set pay_status='1', email_date='$date' where id='".$data['id']."'";
            if($conn->query($sql2))
            {
                $resMember=true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        $i++;
    }
    $result['successCount'] = $successMailCounter;
    echo json_encode($result);  
}

if(isset($_POST['sendMail']) && isset($_POST['tandc']))
{
    $emails = json_decode($_POST['emails']);
    $pms = "'".implode($emails,"','")."'";
    $sql="select u.*, p.title, c.m_num as pmm_num, c.f_name as pmf_name, c.l_name as pml_name from users u, projects p, com_admins c where u.id in ($pms) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        while($row = $res->fetch_assoc())
        {
            $userdata[] = $row;
        }
    }
    $sql="select * from email where id='5'";
    $res =  $conn->query($sql);
    if($res->num_rows)
    {
        $row = $res->fetch_assoc();
        $useremail = $row;
    }
    $i =1;
    $successMailCounter =0;
    foreach($userdata as $data)
    {
        $sub=prepareMessage($useremail['subject'],$data['title']);
        $greet=prepareMessage2($useremail['greetings'], $data['f_name'], $data['l_name'], $data['salutation']);
        $bd=prepareMessage3($useremail['body'],$data['title'], $data['incentive'], $data['id']);
        $endgreet=prepareMessage4($useremail['endgreetings'],$data['pmf_name'], $data['pml_name'], $data['pmm_num']);
        try {
            $mail->isHTML(true);  
            $mail->addAddress($data['email']);
            $mail->Subject = $sub;
            $mail->Body    ="<p style='font-size: 14px'>$greet</p><p style='font-size: 14px'>$bd</p><p style='font-size: 14px'>$endgreet</p>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
            $mail->send();
            $mail ->ClearAllRecipients();
            $result[$i]['msg'] =  "success";
            
            $successMailCounter++;
        }
        catch (Exception $e)
        {
              
             $result[$i]['msg'] =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
        }
        if($result[$i]['msg']=="success")
        {
            $date=date("Y-m-d");
            $sql2="update users set email_date='$date' where id='".$data['id']."'";
            if($conn->query($sql2))
            {
                $resMember=true;
            }
            else
            {
                $errorMember=$conn->error;
            }
        }
        $i++;
    }
    $result['successCount'] = $successMailCounter;
    echo json_encode($result);  
}

?>
<?php
    require_once '../lib/core.php';

    $date=date("Y-m-d");
    
    if(isset($_POST['managerid']))
    {
        $mid = $_POST['managerid'];
        $pms = "'".implode($mid,"','")."'";
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, c.l_name as pml_name , p.project_reference as p_ref, p.tandcfile, p.termandcondition, p.signortick from users u, projects p, com_admins c where u.pm_id in ($pms) and p.pm_id=u.pm_id and c.id=u.pm_id and u.p_id=p.id and u.pay_status=6 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];                               
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }

    if(isset($_POST['projectid']))
    {
        $project = $_POST['projectid'];
        $pjs = "'".implode($project,"','")."'";
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name ,p.tandcfile, p.termandcondition, p.signortick from users u, projects p, com_admins c where u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=6 and c.type=2 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }

    if(isset($_POST['manager'])&&isset($_POST['project']))
    {
         
        $pmid = $_POST['manager'];
        $project = $_POST['project'];
        $pms = "'".implode($pmid,"','")."'";
        $pjs = "'".implode($project,"','")."'";
           
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name, p.tandcfile, p.termandcondition, p.signortick  from users u, projects p, com_admins c where u.pm_id in ($pms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=6 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }


    if(isset($_POST['company'])&&isset($_POST['project']))
    {
         
        $company = $_POST['company'];
        $project = $_POST['project'];
        $cms = "'".implode($company,"','")."'";
        $pjs = "'".implode($project,"','")."'";
           
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name, p.termandcondition as tnc  from users u, projects p, com_admins c where u.com_id in ($cms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=6 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }
    if(isset($_POST['companycheck'])&&isset($_POST['projectcheck'])&&isset($_POST['managercheck']))
    {
         
        $company = $_POST['companycheck'];
        $project = $_POST['projectcheck'];
        $manager = $_POST['managercheck'];
        $cms = "'".implode($company,"','")."'";
        $pjs = "'".implode($project,"','")."'";
        $pms = "'".implode($manager,"','")."'";
           
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name, p.termandcondition as tnc  from users u, projects p, com_admins c where u.com_id in ($cms) and u.pm_id in ($pms) and u.p_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=6 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }
    if(isset($_POST['company'])&&isset($_POST['manager']))
    {
         
        $company = $_POST['company'];
        $manager = $_POST['manager'];
        $cms = "'".implode($company,"','")."'";
        $pjs = "'".implode($manager,"','")."'";
           
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name, p.termandcondition as tnc  from users u, projects p, com_admins c where u.com_id in ($cms) and u.pm_id in ($pjs) and u.p_id=p.id and u.pm_id=c.id and u.pay_status=6 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }
   
  
    
    if(isset($_POST['companyid']))
    {
        $company = $_POST['companyid'];
        $cms = "'".implode($company,"','")."'";
        $sql = "select u.*, p.title as p_title, c.f_name as pmf_name, p.project_reference as p_ref, c.l_name as pml_name , p.termandcondition as tnc from users u, projects p, com_admins c where u.com_id in ($cms) and u.p_id=p.id and u.pm_id=c.id and p.pm_id=c.id and u.pay_status=6 and c.type=2 order by u.email_date";
        if($result=$conn->query($sql))
        {
            if($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $res[]=$row;
                }
            }
        }
        $output['str']=" ";
        $i=1;
        foreach($res as $data)
        {
            if($data['tnc']==1)
            {
                $data['tnc']="Yes";
            }
            else
            {
                $data['tnc']="No";
            }
            $date1 = $data['email_date'];
                                            
            $dateDiff = dateDiffInDays($date1, $date);
            if($dateDiff==0)
            {
                $dateDiff="Today";
            }
            if($data['termandcondition']==1&&$data['tandcfile']==""&&($data['signortick']==1||$data['signortick']==2))
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'" disabled></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                <td><button type="button" class="btn btn-primary" onclick="uploadfile('.$data['id'].', '.$data['signortick'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"> <span class="sr-only"></span></div>Upload T&Cs</button></td> </tr>';
            }
            else
            {
                $str='<tr> 
                <td style="  text-align: center; " scope="row" id="serialNo<?=$i?>"><input type="checkbox" id="checkbox" value="'.$data['id'].'"></td> 
                <td style="  text-align: center; " id="f_name<?=$i?>">'.$data['f_name'].'</td> 
                <td style="  text-align: center; " id="l_name<?=$i?>">'.$data['l_name'].'</td> 
                <td style="  text-align: center; " id="email<?=$i?>">'.$data['email'].'</td> 
                <td style="  text-align: center; " id="m_num<?=$i?>">'.$data['m_num'].'</td>
                <td style="  text-align: center; " id="incentive<?=$i?>">'.$data['incentive'].'</td>
                <td style="  text-align: center; " id="p_title<?=$i?>">'.$data['p_title'].'</td>
                <td style="  text-align: center; " id="pm_name<?=$i?>">'.$data['pmf_name'].' '.$data['pml_name'].'</td>
                <td style="  text-align: center; " id="pay_reference<?=$i?>">'.$data['p_ref'].'</td>
                <td style="  text-align: center; " id="tandc<?=$i?>">'.$data['tnc'].'</td>
                <td style="  text-align: center; " id="email_template<?=$i?>"><button class="btn btn-success" type="button" onclick="template('.$data['id'].')"> <div class="spinner-border" id="linkspin" style="display: none;" role="status"><span class="sr-only"></span></div>Link</button></td>
                </tr>';
            }
            $output['str'].=$str;
            $i++;
        }

        echo json_encode($output);
    }
?>
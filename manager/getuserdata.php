<?php
    require_once '../lib/core.php';
    
    if(isset($_POST['projectid']))
    {
        $project = $_POST['projectid'];
        $pjs = "'".implode($project,"','")."'";
        $sql = "select u.*, p.title as p_title, p.tandcfile, p.termandcondition, p.project_reference as p_ref, p.signortick from users u, projects p where u.p_id in ($pjs) and u.p_id=p.id  and u.pay_status=6";
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
    else
    {
        echo $conn->error;
    }
?>
<?php
require_once "../lib/core.php";


$row = 1;
if (($handle = fopen("uploads/pwize.csv", "r")) !== FALSE) {

    $sql = "insert into user(title,project_reference,description,pm_id, incentive,participants,group_num,start_date,termandcondition) values";
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    if($row==1)
    {
        $row++;
        continue;
        
    }
    $num = count($data);

    echo "<p> $num fields in line $row: <br /></p>\n";
    $row++;
    // $sql.="('".implode($data,"','")."'),";
        $sql.="(";
        if($data[10]=="yes"||$data[10]=="Yes"||$data[10]=="YES"||$data[10]=="YEs"||$data[10]=="YeS"||$data[10]=="yeS"||$data[10]=="yeS")
        {
            $data[10]=1;
        }
        else
        {
            $data[10]=2;
        }
    $sql2="SELECT id FROM com_admins WHERE email='$data[5]'";
    $res =  $conn->query($sql2);
    if($res->num_rows)
    {
        while($r = $res->fetch_assoc())
        {
            $pmid = $r['id'];
        }
    }
    $data[5]=$pmid;
    for ($c=0; $c < $num; $c++) 
    {
        if($c==3||$c==4)
        {
            continue;
        }
        $sql .=  "'$data[$c]'," ;
    }
    $sql = rtrim($sql,",");
    $sql .="),";
  }
  echo $sql = rtrim($sql,",");

  fclose($handle);
}


?>
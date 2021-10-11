<?php
  require_once "../lib/core.php";
  if(isset($_GET['token'])&&!empty($_GET['token']))
  {
    $token=$_GET['token'];
    $sql="select p.termandcondition, p.signortick from projects p, bank_details b where p.id=b.p_id and b.id=$token";
    if($result = $conn->query($sql))
    {
        if($result->num_rows)
        {
            $project_details  = $result->fetch_assoc();  
        } 
    }
  }
?>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body style="background-color:#e1f3ff;">
      <div class="card" style="background-color: white; border-radius: 50px; ">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <p>Your Bank Details are Saved.</p>
        <br>
        <?php
        if($project_details['termandcondition']=1&&$project_details['signortick']==1)
        {
        ?>
          <div>
              <p> <b>One Last Step:</b> </p>
              <p>Please electronically sign Terms and Conditions <br>of Mango Ltd. without which we cannot pay you.</p><br>
              <button type="submit" name="login"class="btn btn-primary">Click To Sign Now</button>
          </div>
        <?php
        }
        ?>
        
      </div>
    </body>
</html>
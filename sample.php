<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background:#d9d9d9;">
  <?php
    $main="  <div style='background:#ffffff; border:15px solid #36E49A; font-family:arial;  width:450px;   margin:0 auto;  padding:20px;'>
    <div style='padding:5px; text-align:center;'>
       <div style='background:#000;  color:#fff;   font-size:2rem; width:70px; height:70px; border-radius:50%; margin:auto;'>
            <p><span style='line-height:70px;'>J</span></p>
        </div>
        <div>
            <p>Jane Doe</p>
        </div>
    </div>
    <div style='border:1px solid #000;  margin:auto; text-align:center;'>
        <p>Order #: 12345678</p>
    </div>
    <p style='color:#6F6F6F; font-size:12px; text-align:center;'><?php date_default_timezone_set('Asia/Manila'); echo date('Y-m-d h:i a')?></p>
    <hr>
    <div style='color:#6F6F6F; margin:20px 0;'>
        <div>
            <span>Email:</span>
            <span style='float:right;'>janedoe@gmail.com</span>
        </div>
        <div style='margin:20px 0;'>
            <span>Name:</span>
            <span style='float:right;'>Jane Doe</span>
        </div>
        <div>
            <span>Total Amount:</span>
            <span style='float:right;'>PHP 200.00</span>
        </div>
    </div>
    <hr>
    <div>
        <p style='color:#6F6F6F; font-size:12px; text-align:center;'>Please show this to the counter to receive your pick up order.</p>
    </div>
    <div>
        <h1 style='color:#36E49A; font-size:1.3rem; text-align:center;'>MANG MAC'S MARINEROS  <br> PIZZA HOUSE</h1>
    </div>
</div>";
  echo $main."\n";
  echo substr("Pamela Patacsil",0,1);
  ?>
</body>
</html>
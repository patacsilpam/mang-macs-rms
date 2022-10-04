<!DOCTYPE html>
<html>
<head>
    <title>PHP Signature Pad Example - Tutsmake.com</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
  
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
    <script type="text/javascript" src="jquery.signature/js/jquery.signature.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/jquery.signature/css/jquery.signature.css">
  
    <style>
        .kbw-signature { width: 400px; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
            border:1px solid gray;
        }
    </style>
  
</head>
<body>
  
<div class="container">
  
    <form method="POST" action="signature.php">
        
        <div class="col-md-12">
            <label>Signature:</label>
            <div id="sig"></div>
            <button id="clear">Clear Signature</button>
            <textarea id="signature64" name="signed" ></textarea>
        </div>
  
        <br/>
        <button class="btn btn-success">Submit</button>
    </form>
  
</div>


<script type="text/javascript">
    //btn clear signature
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>

</body>
</html>
<?php
  $folderPath = "assets/uploads/";
   
  $splitImgStr = explode(";base64,", $_POST['signed']);//split the image in to two (image type,image string)
       
  $imgTypeAux = explode("image/", $splitImgStr[0]);//split data:image/png
     
  $imgType = $imgTypeAux [1]; //get the array index 1 -- png
     
  $imgDecodeBase64 = base64_decode($splitImgStr[1]); //decode the lengthy image string
     
  $file = $folderPath . uniqid() . '.'.$imgType; //set the format of the image (assets/uploads/uniqueId.png)
     
  file_put_contents($file, $imgDecodeBase64);//set a unique id and upload to specified folder path (see 56 line of code)
  echo "Signature Uploaded Successfully.";

  
 ?>
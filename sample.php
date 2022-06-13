<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    <input type="text" name="productName" value="Pizza">
    <input type="text" name="size[]" value="Medium">
    <input type="text" name="size[]" value="Large">
    <input type="text" name="price[]" value="4">
    <input type="text" name="price[]" value="1">
    <button type="submit" name="submitBtn">Submit</button>
    </form>
    <?php
        if(isset($_POST['submitBtn'])){
            $size = $_POST['size'];
            $name = $_POST['productName'];
            $price = $_POST['price'];
            foreach($size as $key => $code){
                $newSize = $code;
                $newPrice = $price[$key];
                echo rand(00000,11111).$newSize.$newPrice.$name."<br/>";
            }
          
        }
        else{
            echo false;
        }
    ?>
</body>
</html>
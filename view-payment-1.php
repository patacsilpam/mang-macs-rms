<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="logo/mang-macs-logo.jpg" sizes="70x70">
    <title>Payment</title>
    <style>
    main {
        padding: 1rem;
    }

    main>article {
        display: flex;
        flex-direction: row;
    }
    main>article:nth-child(2) {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }
    img{
        width: 100%;
        height: fit-content;
    }
    </style>
</head>

<body class="bg-dark">
    <main>
        <article>
            <section>
                <a href="reservation_summary.php?order_number=<?php echo $_GET['order_number']?> " title="Back" class="text-white">
                    <i class="fa fa-arrow-circle-left" style="font-size:2.3rem"></i>
                </a>
            </section>
        </article>
        <article>
            <section>
                <?php
                    require 'public/connection.php';
                    $orderNumber = $_GET['order_number'];
                    $paymentPhoto="";
                    $getPaymentPhoto = $connect->prepare("SELECT payment_photo FROM tblreservation WHERE refNumber=?");
                    $getPaymentPhoto->bind_param('s',$orderNumber);
                    $getPaymentPhoto->execute();
                    $getPaymentPhoto->bind_result($paymentPhoto);
                    $getPaymentPhoto->fetch();
                    
                    echo '<img src="data:image/jpg;base64,'.$paymentPhoto.'">';
                ?>
           
            </section>
        </article>
    </main>

</body>

</html>
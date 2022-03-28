<?php
require 'public/admin-signup.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="logo/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css" type="text/css">
    <title>Reset Password</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="container" method="POST">
        <div class="container">
            <div class="content">
                <h1>Email Verification Code</h1>
                <?php
                //message box for registration
                //information for user
                if (isset($_GET['msg-success'])) {
                ?>
                    <strong class="text-success"><?php echo "<p class=' msg-Success'></p>".$_SESSION['info'] ?></strong>
                <?php
                }
                if (isset($_GET['msg-Error'])) {
                    ?>
                        <strong class="alert alert-danger"><?php echo "<p class=' msg-Error'></p>".$_SESSION['info'] ?></strong>
                    <?php
                    }
                //otp error message
                if ($otpError) {
                ?>
                    <strong class="alert alert-danger msg-Error"><?php echo $otpError; ?></strong>
                <?php
                }
                ?>
                <input type="number" class="form-control form" name="otp-reset" placeholder="Enter Verification Code" required>
                <button type="submit" name="btn-otp-reset">Enter</button>
            </div>
        </div>
    </form>
</body>

</html>
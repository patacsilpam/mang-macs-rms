<?php
require 'public/admin-signup.php';
//$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css" type="text/css">
    <title>Forgot Password</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="container" method="POST">
        <div class="container">
            <div class="content">
                <h1>Mang Mac's Marinero</h1>
                <strong class="text-forgot-password">Reset Password</strong><br>
                <?php
                if (isset($_GET['password-changed'])) {
                ?>
                    <div class="text-reset-box">
                        <p class="reset-Success alert alert-success"><i class="fas fa-check icons"></i> Your password has been reset.</p>
                        <p class="reset-Success">To sign in with your new account,<a href="login.php" class="text-primary">click here.</a></p>
                    </div>
                <?php

                }
                ?>
                <input type="hidden" value="<?=$email?>">
                <label for="password">New Password</label>
                <input type="password" class="form-control form togglePassword" id="password" name="newPassword" placeholder="Enter new password" required minlength="8">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control form togglePassword" id=" confirmPassword" name="confirmPassword" placeholder="Confrim password" required minlength="8">
                <strong class="text-danger msg-Error"><?php if ($pwordError) echo $pwordError ?></strong>
                <strong class="text-danger msg-Error"><?php if ($confirmPwordError) echo $confirmPwordError ?></strong>
                <div class="inline-checkbox"><input type="checkbox" class="checkbox" onclick="toggle(this)">Show Password</div>
                <button type="submit" name="btn-reset">Reset</button>
            </div>
        </div>
    </form>
    <script src="assets/js/multi-password-visibility.js"></script>
</body>

</html>
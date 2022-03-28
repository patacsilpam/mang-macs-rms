<?php
error_reporting(0);
require 'public/admin-signup.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/login.css" type="text/css">
    <title>Forgot Password</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="container" method="POST">
        <div class="container">
            <div class="content">
                <h1>Forgot your Password?</h1>
                <p class="reset-password">To reset your password, enter your email address to receive a verification code.</p>
                <?php if ($emailError) {
                ?>
                    <small class="alert alert-danger">Email not found.</small>
                <?php
                } ?>
                <label for="email">Email Address</label>
                <input type="email" class="form-control form" id="email" name="email" placeholder="Enter email" required>
                <button type="submit" name="btn-continue">Continue</button>
            </div>
        </div>
    </form>
</body>

</html>
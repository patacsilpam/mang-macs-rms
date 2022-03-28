<?php
require 'public/admin-login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Admin Sign In" content="Mang Macs, User Login">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css" type="text/css">
    <title>Sign in</title>
    
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="container">
            <div class="content">
                <h1>Mang Macs Marinero Pizza House</h1>
                <p>Login</p>
                <strong><?php if ($unameEmailError) echo "<strong class='msg-Error alert alert-danger'> $unameEmailError</strong>" ?></strong>
                <strong><?php if ($pwordError) echo "<strong class='msg-Error alert alert-danger''>$pwordError</strong>" ?></strong>
                <input type="text" class="form-control form" name="unameEmail" placeholder=" Username or email" required>
                <input type="password" class="form-control form" id="password" name="pword" placeholder="Password" required>
                <i class="bi bi-eye-slash icon-eye" id="togglePassword"></i>
                <button type="submit" name="btnSignin">Sign in</button>
               <a href="forgot-password.php"  class="forgot-password"> <i class="forgot-password">Forgot Password?</i></a>
            </div>
        </div>
    </form>
    <script src="assets/js/password-visibility.js"></script>
</body>

</html>
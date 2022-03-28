<?php
require 'public/profile-update.php';
require 'public/password-update.php';
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Profile" content="Mang Macs-Profile">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/jpeg" href="assets/images/mang-macs-logo.jpg" sizes="70x70">
    <link rel="stylesheet" href="assets/css/main.css" type="text/css">
    <title>Profile</title>
</head>

<body>
    <div class="grid-container">
        <!--Navigation-->
        <header class="nav-container">
            <h3>Profile</h3>
            <ul class="nav-list">
                <?php include 'assets/template/admin/navbar.php'?>
            </ul>
        </header>
        <!--Admin Profile-->
        <main class="main-container">
            <section>
                <article>
                    <div class="admin-container">
                        <div class="profile-information-container">
                            <h1>Account Information</h1>
                            <?php
                            if (isset($_GET['msg-updated'])) {
                            ?>
                            <div class="alert alert-success msg-Success"><i class="fas fa-check"></i>Updated Account
                                Successfully</div>
                            <?php
                            }
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"
                                class="profile-information-container" enctype="multipart/form-data">
                                <?php
                                $email = $_SESSION['email'];
                                $id = $_SESSION['id'];
                                $check_admin_profile = $connect->prepare("SELECT * FROM tblusers WHERE id=?");
                                $check_admin_profile->bind_param('i', $id);
                                $check_admin_profile->execute();
                                $rows = $check_admin_profile->get_result();
                                while ($fetch = $rows->fetch_assoc()) {
                                ?>
                                <input type="hidden" name="number" value="<?= $fetch['id'] ?>">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="First Name"
                                    value="<?= $fetch['fname'] ?>" required>
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lastName"
                                    placeholder="Last Name" value="<?= $fetch['lname'] ?>" required>
                                <label>Position</label>
                                <select name="position" class="form-control">
                                    <option value="none">Select Position</option>
                                    <option value="Admin"
                                        <?php if ($fetch['position'] == "Admin") echo 'selected="selected"'; ?>>Admin
                                    </option>
                                    <option value="Staff"
                                        <?php if ($fetch['position'] == "Staff") echo 'selected="selected"'; ?>>Staff
                                    </option>
                                </select>
                                <label>Username</label>
                                <input type="text" class="form-control" name="uname" placeholder="Username"
                                    value="<?= $fetch['uname'] ?>" required>
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email Address"
                                    value="<?= $fetch['email'] ?>" required>
                                <label>
                                    <input type="file" name="adminImage" multiple
                                        accept="image/png, image/jpeg, image/jpg" size="60">
                                </label>
                                <div> <img src="<?= $fetch['profile']; ?>" width="100"></div>
                                <button type="Submit" class="btn btn-success" name="btn-update-account">Update
                                    Account</button>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                        <div class="profile-information-container">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"
                                class="profile-information-container">
                                <h1>Change Password</h1>
                                <?php
                                if (isset($_GET['updated'])) {
                                ?>
                                <div class="alert alert-success msg-Success"><i class="fas fa-check"></i>Password
                                    changed successfully.</div>
                                <?php
                                }
                                ?>
                                <label for="currentPassword">Current Password</label>
                                <input type="password" class="form-control togglePassword" name="currentPassword"
                                    placeholder="Current Password" required>
                                <strong><?php if ($pwordError) echo "<strong class='msg-Error text-danger fa fa-times'>$pwordError</strong>" ?></strong>
                                <label for="password">New Password</label>
                                <input type="password" class="form-control togglePassword" name="newPassword"
                                    placeholder="New Password" minlength="8" required>
                                <?php if ($newPwordError) echo "<strong class='msg-Error text-danger fa fa-times'>$newPwordError</strong>" ?></strong>
                                <label>Confirm Password</label>
                                <input type="password" class="form-control togglePassword" name="confirmPassword"
                                    placeholder="Confirm Password" minlength="8" required>
                                <?php if ($confirmPwordError) echo "<strong class='msg-Error text-danger fa fa-times'> $confirmPwordError</strong>" ?></strong>
                                <?php if ($pwordNotMatch) echo "<strong class='msg-Error text-danger fa fa-times'>$pwordNotMatch</strong>" ?></strong>
                                <input type="checkbox" class="checkbox" onclick="toggle(this)">Show password
                                <button type="Submit" class="btn btn-success" name="btn-change-password">Change
                                    Password</button>
                            </form>
                        </div>
                    </div>
                </article>
            </section>
        </main>
        <!--Sidebar-->
        <?php include 'assets/template/admin/sidebar.php'?>
    </div>
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/sidebar-menu-active.js"></script>
    <script src="assets/js/multi-password-visibility.js"></script>
</body>

</html>
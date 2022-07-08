<!-- Add User -->
<div class="modal fade" id="addUsers" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Add</p>
                <div class="input-form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <input type="hidden" name="id">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name"
                            required>
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name"
                            required>
                        <label for="uname">Username</label>
                        <input type="text" class="form-control" name="uname" id="uname" placeholder="Username" required>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                        <label for="position">Account Type</label>
                        <select class="form-control" name="position" id="position" required>
                            <option value="">Select</option>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                        </select>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                            required>
                        <i class="bi bi-eye-slash icon-eye" id="togglePassword"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btn-save-user">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- View Users -->
<div class="modal fade" id="showUsers<?= $fetch['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div>
            <div class="d-flex justify-content-center">
                <img src="<?=$fetch['profile']?>" alt="profile" width="250">
            </div>
            <div>
                <p>Name: <?=$fetch['fname']." ".$fetch['lname'];?></p>
                <p>Email: <?=$fetch['email']?></p>
                <p>Account Type: <?=$fetch['position']?></p>
                <p>Created At: <?=date('F d, Y h:i:s',strtotime($fetch['created_at']));?></p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit User -->
<div class="modal fade" id="editUsers<?= $fetch['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Edit</p>
                <div class="input-form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $fetch['id'] ?>">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name"
                            value="<?= $fetch['fname'] ?>" required>
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name"
                            value="<?= $fetch['lname'] ?>" required>
                        <label for="uname">Username</label>
                        <input type="text" class="form-control" name="uname" id="uname" placeholder="Username"
                            value="<?= $fetch['uname'] ?>" required>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                            value="<?= $fetch['email'] ?>" required>
                        <label for="position">Account Type</label>
                        <select class="form-control" name="position" id="position" required>
                            <option value="">Select</option>
                            <option value="Admin"
                                <?php if ($fetch['position'] == "Admin") echo 'selected ? "selected"'; ?>>Admin</option>
                            <option value="Staff"
                                <?php if ($fetch['position'] == "Staff") echo 'selected ? "selected"'; ?>>Staff</option>
                        </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btn-edit-user">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Delete--->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
    <div class="modal fade" id="deleteUsers<?= $fetch['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mang Mac's Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $fetch['id']; ?>">
                    <p>Delete</p>
                    <div class="modal-body-container">
                        <i class="fas fa-exclamation-circle fa-3x icon-warning"></i><br>
                        <p class="icon-text-warning">Are you sure you want to delete the user that you selected?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="btn-delete-users">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!---Edit Salary--->
<div class="modal fade" id="editSalary<?= $fetch['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Edit</p>
                <div class="input-form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $fetch['id'] ?>">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name"
                            value="<?= $fetch['fname'] ?>" required>
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name"
                            value="<?= $fetch['lname'] ?>" required>
                        <label for="uname">Username</label>
                        <input type="text" class="form-control" name="uname" id="uname" placeholder="Username"
                            value="<?= $fetch['uname'] ?>" required>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                            value="<?= $fetch['email'] ?>" required>
                        <label for="position">Position</label>
                        <select class="form-control" name="position" id="position" required>
                            <option value="">Select</option>
                            <option value="Admin"
                                <?php if ($fetch['position'] == "Admin") echo 'selected ? "selected"'; ?>>Admin</option>
                            <option value="Staff"
                                <?php if ($fetch['position'] == "Staff") echo 'selected ? "selected"'; ?>>Staff</option>
                        </select>
                        <label for="salary">Salary</label>
                        <input type="number" class="form-control" name="salary" id="salary" placeholder="Salary"
                            value="<?= $fetch['salary']?>" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btn-salary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
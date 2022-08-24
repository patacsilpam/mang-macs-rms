<?php 
            if(isset($_GET['inserted'])){
                ?>
                <script>
                    swal({
                        title: "Successful",
                        text: "Insert new user successfully",
                        icon: "success",
                        button: "Ok",
                        });
                </script>
                <?php
            }
            else if(isset($_GET['username_already_exist'])){
                ?>
                 <script>
                    swal({
                        title: "Error",
                        text: "Username already exist",
                        icon: "error",
                        button: "Ok",
                        });
                </script>
                <?php
            }
            else{
                if(isset($_GET['email_already_exist'])){
                ?>
                <script>
                   swal({
                       title: "Error",
                       text: "Email already exist",
                       icon: "error",
                       button: "Ok",
                       });
               </script>
               <?php
                }
            }
        ?>
        <!--Update alert message-->
        <?php
            if(isset($_GET['updated'])){
                ?>
                <script>
                    swal({
                        title: "Successful",
                        text: "Update user successfully",
                        icon: "success",
                        button: "Ok",
                        });
                </script>
                <?php
            }
            else{
                if(isset($_GET['update_user_error'])){
                ?>
                <script>
                   swal({
                       title: "Error",
                       text: "Could not update item",
                       icon: "error",
                       button: "Ok",
                       });
               </script>
               <?php
                }
            }
        ?>
         <!--Delete alert message-->
         <?php
            if(isset($_GET['deleted'])){
                ?>
                <script>
                    swal({
                        title: "Successful",
                        text: "Delete user successfully",
                        icon: "success",
                        button: "Ok",
                        });
                </script>
                <?php
            }
            else{
                if(isset($_GET['delete_user_error'])){
                ?>
                <script>
                   swal({
                       title: "Error",
                       text: "Could not delete item",
                       icon: "error",
                       button: "Ok",
                       });
               </script>
               <?php
                }
            }
?>
<?php if(isset($_GET['inserted'])){
            ?>
            <script>
                swal({
                    title: "Successful",
                    text: "Insert new product successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        //error sweet alert message
        else{
            if(isset($_GET['product_already_exist'])){
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Product already exist.",
                        icon: "error",
                        button: "Ok",
                        });
                </script>
            <?php
            }
        }
        ?>
       
        <?php
        if(isset($_GET['updated'])){
             //update sweet alert message
            ?>
             <script>
                swal({
                    title: "Successful",
                    text: "Update product successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else if(isset($_GET['update_stock'])){
            ?>
            <script>
                swal({
                    title: "Successful",
                    text: "Update stock successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else{
            if(isset($_GET['update_product_error'])){
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Could not update product.",
                        icon: "error",
                        button: "Ok",
                        });
                </script>
                <?php
            }
        }
        ?>
        <?php
        if(isset($_GET['deleted'])){
            ?>
             <script>
               swal({
                    title: "Successful",
                    text: "Delete product successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else{
            if(isset($_GET['delete_product_error'])){
            ?>
            <script>
                swal({
                    title: "Error",
                    text: "Could not delete product.",
                    icon: "error",
                    button: "Ok",
                    });
            </script>
            <?php
            }
        }
?>
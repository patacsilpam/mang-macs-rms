<?php if(isset($_GET['inserted'])){
            ?>
            <script>
                swal({
                    title: "Successful",
                    text: "Insert new item successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        //error sweet alert message
        else{
            if(isset($_GET['error'])){
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Could not insert item.",
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
                    text: "Update item successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else{
            if(isset($_GET['update_item_error'])){
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "Could not update item.",
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
                    text: "Delete item successfully",
                    icon: "success",
                    button: "Ok",
                    });
            </script>
            <?php
        }
        else{
            if(isset($_GET['delete_item_error'])){
            ?>
            <script>
                swal({
                    title: "Error",
                    text: "Could not delete item.",
                    icon: "error",
                    button: "Ok",
                    });
            </script>
            <?php
            }
        }
?>
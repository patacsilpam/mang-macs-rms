<!-- Modal -->
<div class="modal fade" id="editUsers<?= $fetch['order_number'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <div class="modal-body">
                    <label for="">Change Order Status</label><br>
                    <input type="hidden" value="<?= $fetch['order_type']?>" name="orderType">
                    <input type="hidden" value="<?= $fetch['customer_name']?>" name="customerName">
                    <input type="hidden" value="<?= $fetch['order_number'] ?>" name="orderNumber">
                    <input type="hidden" value="<?=$fetch['created_at']?>" name="orderDate">
                    <input type="hidden" value="<?= $fetch['email']?>" name="email">
                    <select class="form-control" name="orderStatus">
                        <option value="Pending" <?php if($fetch['order_status'] == "Pending") echo 'selected ? "selected"';?>>Pending</option>
                        <option value="Order Received" <?php if($fetch['order_status'] == "Order Received") echo 'selected ? "selected"';?>>Order Received</option>
                        <option value="Shipped" <?php if($fetch['order_status'] == "Shipped") echo 'selected ? "selected"';?>>Shipped</option>
                        <option value="Delivered" <?php if($fetch['order_status'] == "Delivered")  echo 'selected ? "selected"'?>>Delivered</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-update">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
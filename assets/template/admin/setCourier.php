<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
  <div class="modal fade" id="setCourier<?=$orderNumber?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Courier In-charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $fetch['id']; ?>">
          <div class="modal-body-container">
            <i class="fas fa-shipping-fast fa-3x icon-warning"></i><br>
            <p class="icon-text-warning">Set courier in-charge</p>
            <input type="text" name="courierName" value="<?=$courierName?>" placeholder="Enter courier fullname" class="form-control" required>
            <input type="text" name="orderNumber" value="<?=$orderNumber?>" style="display:none;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success" name="btn-set-courier">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>



<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
  <div class="modal fade" id="orderstatus<?=$orderNumber?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Courier In-charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $fetch['id']; ?>">
          <div class="modal-body-container">
          <select name="orderStatus" class="form-control" style="font-size:1.3rem" id="order-status">
            <option value="Pending" <?php if($orderStatus == "Pending") { echo 'selected ? "selected"';}?>>Pending</option>
            <option value="Order Processing" <?php if($orderStatus == "Order Processing") { echo 'selected ? "selected"';}?>>Processing (Confirm Order)</option>
            <option id="out-delivery" value="Out for Delivery" <?php if($orderStatus == "Out for Delivery") { echo 'selected ? "selected"';}?>>Out for Delivery</option>
            <option id="ready-pickup" value="Ready for Pick Up" <?php if($orderStatus == "Ready for Pick Up") { echo 'selected ? "selected"';}?>>Ready for Pick Up</option>
            <option value="Order Completed" <?php if($orderStatus == "Order Completed") { echo 'selected ? "selected"';}?>>Complete</option>
            <option value="Cancelled" <?php if($orderStatus == "Cancelled") { echo 'selected ? "selected"';}?>>Cancel</option>
          </select>
          <input type="hidden" name="orderNumber" value="<?=$orderNumber?>">
            <input type="hidden" id="order-type" value="<?=$orderType?>">
            <input type="hidden" name="sales" value="<?=$totalAmount?>">
            <button type="submit" name="btn-update" class="btn btn-primary">Update Status</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success" name="btn-set-courier">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
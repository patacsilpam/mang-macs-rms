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
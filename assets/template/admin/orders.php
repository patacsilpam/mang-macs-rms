<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
<div class="modal fade" id="editOrderTime" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Change Delivery Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div>
            <div class="d-flex justify-content-center">
            </div>
            <div>
                <label>Delivery Time</label>
                <input type="time" class="form-control" name="devTime" required>
                <input type="hidden" name="email" value="<?=$email?>">
                <input type="hidden" class="form-control" name="orderNumber" value="<?=$orderNumber?>">
                <input type="hidden" name="orderStatus" value="<?=$email?>">
                <input type="hidden" name="orderDate" value="<?=$placedOn?>">
                <input type="hidden" name="orderType" value="<?=$orderType?>"> 
                <input type="hidden" name="token" value="<?=$token?>"><br>
                <label>Reason for changing delivery time</label>     
                <div>
                    <input type="radio" name="modDevTime" value="Order Quantity" required>
                    <label>Quantity of Orders</label>  
                </div>
                <div>
                    <input type="radio" name="modDevTime" value="Queued Orders" required>
                    <label>Multiple queued Orders</label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="update-dev-time">Save</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- Modal -->
<div class="modal fade" id="editPosOrder<?= $idNumber ?>" tabindex="-1" role="dialog"
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
                    <input type="hidden" value="<?= $idNumber ?>" name="idNumber">
                    <select class="form-control" name="orderStatus">
                        <option value="Processing" <?php if($statuss == "Processing") echo 'selected ? "selected"';?>>Processing</option>
                        <option value="Completed" <?php if($statuss == "Completed") echo 'selected ? "selected"';?>>Completed</option>
                    </select>
                    <input type="text" name="sales" value="<?php if($discountedPrice == 0){ echo $total;} else{echo $discountedPrice;}?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-update">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                        <option value="Running" <?php if($statuss == "Running") echo 'selected ? "selected"';?>>Running</option>
                        <option value="Settled" <?php if($statuss == "Settled") echo 'selected ? "selected"';?>>Settled</option>
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
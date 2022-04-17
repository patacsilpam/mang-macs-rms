<!-- Modal -->
<div class="modal fade" id="editUsers<?= $fetch['id'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Booking Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <div class="modal-body">
                    <label for="">Change Booking Status</label><br>
                    <input type="hidden" value="<?=$fetch['id']?>" name="id">
                    <input type="hidden" value="<?= $fetch['fname']." ".$fetch['lname'];?>" name="customerName">
                    <input type="hidden" value="<?=$fetch['created_at']?>" name="reservedDate">
                    <input type="hidden" value="<?=$fetch['scheduled_date']." ".$fetch['scheduled_time']?>" name="placedOn">
                    <input type="hidden" value="<?= $fetch['email']?>" name="email">
                    <input type="hidden" value="<?= $fetch['guests']?>" name="guests">
                    <input type="hidden" value="<?= $fetch['refNumber']?>" name="refNumber">
                    <select class="form-control" name="bookStatus">
                        <option value="Pending" <?php if($fetch['status'] == "Pending") echo 'selected ? "selected"';?>>Pending</option>
                        <option value="Booking Received" <?php if($fetch['status'] == "Booking Received") echo 'selected ? "selected"';?>>Booking Received</option>
                        <option value="Completed" <?php if($fetch['status'] == "Completed")  echo 'selected ? "selected"'?>>Completed</option>
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
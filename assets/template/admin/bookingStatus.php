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
                    <label for="">Confirmation Table Reservation</label><br>
                    <input type="hidden" value="<?=$fetch['id']?>" name="id">
                    <input type="hidden" value="<?= $fetch['fname']." ".$fetch['lname'];?>" name="customerName">
                    <input type="hidden" value="<?=$fetch['created_at']?>" name="reservedDate">
                    <input type="hidden" value="<?=$fetch['scheduled_date']?>" name="schedDate">
                    <input type="hidden" value="<?=$fetch['scheduled_time']?>"  name="schedTime">
                    <input type="hidden" value="<?= $fetch['email']?>" name="email">
                    <input type="hidden" value="<?= $fetch['guests']?>" name="guests">
                    <input type="hidden" value="<?= $fetch['order_number']?>" name="refNumber">
                    <input type="hidden" value="<?=$fetch['token']?>" name="token">
                    <div class="form-check">
                        <div>
                            <input class="form-check-input" type="radio" name="bookStatus" value="Reserved" <?php if($fetch['status'] == "Reserved"){ echo "checked=checked";} ?> style="height:15px; width:15px">
                            <label class="form-check-label">Reserved</label>
                        </div>
                        <div>
                            <input class="form-check-input" type="radio" name="bookStatus" value="Cancelled" <?php if($fetch['status'] == "Cancelled"){ echo "checked=checked";} ?> style="height:15px; width:15px">
                            <label class="form-check-label">Not Available</label>
                        </div>
                        <div>
                            <input class="form-check-input" type="radio" name="bookStatus" value="Finished" <?php if($fetch['status'] == "Completed"){ echo "checked=checked";} ?> style="height:15px; width:15px">
                            <label class="form-check-label">Finished</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-update">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- View Table Reservation  -->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
<div class="modal fade" id="viewTable<?= $fetch['id'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Table Reservation Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Customer Name: <?=$fetch['fname']." ".$fetch['lname']?></p>
                <p>Email: <?=$fetch['email']?></p>
                <p>No. of Guests: <?=$fetch['guests']?></p>
                <p>Date: <?= date('D,F d, Y',strtotime($fetch['scheduled_date']))?></p>
                <p>Time: <?=$fetch['scheduled_time']?></p>
                <strong>Confirm Table Reservation</strong>
                <div class="form-check">
                    <input type="hidden" value="<?=$fetch['id']?>" name="id">
                    <input type="hidden" value="<?= $fetch['fname']." ".$fetch['lname'];?>" name="customerName">
                    <input type="hidden" value="<?=$fetch['created_at']?>" name="reservedDate">
                    <input type="hidden" value="<?=$fetch['scheduled_date']?>" name="schedDate">
                    <input type="hidden" value="<?=$fetch['scheduled_time']?>"  name="schedTime">
                    <input type="hidden" value="<?= $fetch['email']?>" name="email">
                    <input type="hidden" value="<?= $fetch['guests']?>" name="guests">
                    <input type="hidden" value="<?= $fetch['refNumber']?>" name="refNumber">
                    <input type="hidden" value="<?=$fetch['token']?>" name="token">
                    <div>
                        <input class="form-check-input" type="radio" name="bookStatus" value="Reserved" <?php if($fetch['status'] == "Reserved"){ echo "checked=checked";} ?> style="height:15px; width:15px">
                        <label class="form-check-label">Reserved</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="bookStatus" value="Cancelled" <?php if($fetch['status'] == "Cancelled"){ echo "checked=checked";} ?> style="height:15px; width:15px">
                        <label class="form-check-label">Not Available</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btn-update">Confirm</button>
            </div>
        </div>
    </div>
</div>
</form>
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
                    
                    <select class="form-control" name="orderStatus">
                        <optgroup label="Deliver" class="deliver">
                            <option value="Pending" <?php if($fetch['order_status'] == "Pending") echo 'selected ? "selected"';?>>Pending</option>
                            <option value="Order Received" <?php if($fetch['order_status'] == "Order Received") echo 'selected ? "selected"';?>>Order Received</option>
                            <option value="Order Processing" <?php if($fetch['order_status'] == "Order Processing") echo 'selected ? "selected"';?>>Order Processing</option>
                            <option value="Out for Delivery" <?php if($fetch['order_status'] == "Out for Delivery") echo 'selected ? "selected"';?>>Out for Delivery</option>
                            <option value="Order Completed" <?php if($fetch['order_status'] == "Order Completed")  echo 'selected ? "selected"'?>>Order Completed</option>
                        </optgroup>
                        <optgroup label="Pick Up" class="pickUp">
                            <option value="Pending" <?php if($fetch['order_status'] == "Pending") echo 'selected ? "selected"';?>>Pending</option>
                            <option value="Order Received" <?php if($fetch['order_status'] == "Order Received") echo 'selected ? "selected"';?>>Order Received</option>
                            <option value="Order Processing" <?php if($fetch['order_status'] == "Order Processing") echo 'selected ? "selected"';?>>Order Processing</option>
                            <option value="Ready for Pick Up" <?php if($fetch['order_status'] == "Ready for Pick Up") echo 'selected ? "selected"';?>>Ready for Pick Up</option>
                            <option value="Order Completed" <?php if($fetch['order_status'] == "Order Completed")  echo 'selected ? "selected"'?>>Order Completed</option>
                        </optgroup>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function btnOrderType(orderType){
        console.log(orderType.value)
        let deliverList = document.querySelectorAll('.deliver'); 
        let pickUpList = document.querySelectorAll('.pickUp');     
        //display:block deliver class list 
        for(let i=0; i<deliverList.length; i++){
            deliverList[i].style.display='block';
        }
       //display:block pickup class list 
        for(let i=0; i<pickUpList.length; i++){
            pickUpList[i].style.display='block';
        }
        //deliver
       if(orderType.value == "Deliver"){
            for(let i=0; i<deliverList.length; i++){
                deliverList[i].style.display='block';
            }
       }
       else{
            for(let i=0; i<deliverList.length; i++){
                deliverList[i].style.display='none';
            }
       }
       //pick up
       if(orderType.value == "Pick Up"){
        for(let i=0; i<pickUpList.length; i++){
            pickUpList[i].style.display='block';
        }
       }
       else{
            for(let i=0; i<pickUpList.length; i++){
                pickUpList[i].style.display='none';
            }
       }
    }
</script>
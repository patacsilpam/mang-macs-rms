<!--A modal for creating add-ons--->
<div class="modal fade" id="createAddOn" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Choice Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Create Add-On</p>
        <div class="input-form">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <div class="mt-3">
                <label>Choose add-on(e.g.Pizza)</label>
                <select name="choiceGroup" class="form-control form-control-sm" required>
                    <option value=""></option>
                    <option value="Noodles">Noodles</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Sizzling Plates">Sizzling Plates</option>
                    <?php
                        /*$getChoices = $connect->prepare("SELECT productCategory FROM tblproducts GROUP BY productCategory ORDER BY productCategory ASC");
                        $getChoices->execute();
                        $getChoices->bind_result($productCategory);
                        while($getChoices->fetch()){
                            ?>
                            <option value="<?= $productCategory?>"><?= $productCategory?></option>
                            <?php
                        }*/
                    ?>
                </select>
            </div>
            <div class="mt-3 add-ons-con">
              <div class="add-ons-div">
                <label>Add-On</label>
                <label>Price</label>
                <label>Quantity</label>
              </div>
              <div class="add-ons-child">
                <div class="add-ons-div">
                  <input type="text" class="add-ons-input form-control form-control-sm" name="add-ons-name[]" placeholder="Add-on" required>
                  <input type="number" class="add-ons-input form-control form-control-sm" name="add-ons-price[]" placeholder="0" required>
                  <input type="number" class="add-ons-input form-control form-control-sm" name="add-ons-quantity[]" placeholder="0" required>
                </div>
              </div>
              <hr>
              <p id="add-ons"><i class="fas fa-plus"></i> Create add-on choice </p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="btn-save-choices">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--A modal for viewing add-ons--->
<div class="modal fade" id="viewAddOns<?=$id?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Choice Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Choice Group Detail</p>
        <div class="input-form">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <div class="mt-3">
              <div class="add-ons-div">
                <label><strong>Choice Group: <?=$addOnsCategory?></strong></label>
                <label>Price</label>
                <label>Quantity</label>
              </div>
               
                <?php
                  $addOnsArr = explode(',',$addOnsName);
                  $addOnsPriceArr = explode(',',$addOnsPrice);
                  $addOnsQtyArr = explode(',',$addOnsQty);
                  foreach($addOnsArr as $addOnsIndex => $addOnsValue){
                    $newAddOns = $addOnsValue;
                    $newAddOnsPrice = $addOnsPriceArr[$addOnsIndex];
                    $newAddOnsQty = $addOnsQtyArr[$addOnsIndex];
                    ?>
                      <div class="add-ons-child">
                        <div class="add-ons-div">
                          <input type="text" class="add-ons-input form-control form-control-sm" value="<?=$newAddOns?>" disabled>
                          <input type="number" class="add-ons-input form-control form-control-sm" value="<?=$newAddOnsPrice?>" disabled>
                          <input type="number" class="add-ons-input form-control form-control-sm" value="<?=$newAddOnsQty?>" disabled>
                        </div>
                      </div>                    
                    <?php
                  }
                ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="btn-save-choices">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--A modal for updating add-ons--->
<div class="modal fade" id="editAddons<?=$id?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Choice Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Edit Choice Group</p>
        <div class="input-form">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <div class="mt-3">
                <strong>Choice Group: <?=$addOnsCategory?></strong>
            </div>
            <div class="mt-3 add-ons-con">
              <div class="add-ons-div">
                <label style="width:150px;" >Add-On</label>
                <label style="width:50px;">Price</label>
                <label style="width:80px;">Quantity</label>
                <label style="width:90px;">Adjust Qty.</label>
              </div>
                <?php
                  $fetchAddOns = $connect->prepare("SELECT id,add_ons,add_ons_price,add_ons_category,add_ons_quantity,add_ons_available_qty FROM tbladdons WHERE add_ons_category=? ORDER BY id ASC");
                  $fetchAddOns->bind_param('s',$addOnsCategory);
                  $fetchAddOns->execute();
                  $fetchAddOns->store_result();
                  $fetchAddOns->bind_result($id,$addOns,$addOnsFee,$addOnsGroup,$addOnsQty,$availStockQty);
                  while($fetchAddOns->fetch()){
                    ?>
                  <div class="add-ons-child">
                      <div class="add-ons-div">
                        <input type="hidden" name="ids[]" value="<?=$id?>">
                        <input type="hidden" name="availStockQty[]" value="<?=$availStockQty?>">
                        <input type="text" class="add-ons-input form-control form-control-sm" name="addOns[]" value="<?=$addOns?>" required style="width:150px">
                        <input type="number" class="add-ons-input form-control form-control-sm" name="addOnsPrice[]" value="<?=$addOnsFee?>" required style="width:50px;">
                        <input type="number" class="add-ons-input form-control form-control-sm" name="addOnsQuantity[]" value="<?=$addOnsQty?>" readonly style="width:70px;">      
                        
                          <div class="d-flex flex-row align-content-center justify-content-center my-2 mx-3">
                            <button type="button" class="rounded-0 border border-secondary form-control form-control-sm" id="minus-btn" style="width:25px"><strong>-</strong></button>
                            <input type="number" class="text-center rounded-0 add-ons-input border border-secondary form-control form-control-sm m-0" id="adjust-qty" style="width:45px;" name="adjustQty[]" placeholder="0">
                            <button type="button" class="rounded-0 border border-secondary form-control form-control-sm" id="plus-btn" style="width:25px"><strong>+</strong></button>
                          </div>
                        
                        
                        <button type="submit" class="remove-btn" name="btn-remove-addOns" value="<?=$id?>">x</button><!--This button's functionality delete specific add ons--->
                      </div>
                  </div>    
                  <?php
                }
              ?>
            <hr>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="btn-edit-choices">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--A modal for removing/deleting add-ons--->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
  <div class="modal fade" id="deleteChoiceGroup<?=$id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mang Macs Choice Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="add-ons-category" value="<?=$addOnsCategory?>">
          <p>Delete Choice Group</p>
          <div class="modal-body-container">
            <i class="fas fa-exclamation-circle fa-3x icon-warning"></i><br>
            <p class="icon-text-warning">Are you sure you want to delete this choice group data?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" name="btn-delete-choiceGroup">Delete</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Create Add ons -->
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
                    <?php
                        $getChoices = $connect->prepare("SELECT productCategory FROM tblproducts GROUP BY productCategory ORDER BY productCategory ASC");
                        $getChoices->execute();
                        $getChoices->bind_result($productCategory);
                        while($getChoices->fetch()){
                            ?>
                            <option value="<?= $productCategory?>"><?= $productCategory?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="mt-3 add-ons-con">
              <div class="add-ons-div">
                <label>Add-On</label>
                <label>Price</label>
              </div>
              <div class="add-ons-child">
                <div class="add-ons-div">
                  <input type="text" class="add-ons-input form-control form-control-sm" name="add-ons-name[]" placeholder="Add-on" required>
                  <input type="number" class="add-ons-input form-control form-control-sm" name="add-ons-price[]" placeholder="0" required>
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

<!-- View Add ons -->
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
                </div>
               
                <?php
                  $addOnsArr = explode(',',$addOnsName);
                  $addOnsPriceArr = explode(',',$addOnsPrice);
                  foreach($addOnsArr as $addOnsIndex => $addOnsValue){
                    $newAddOns = $addOnsValue;
                    $newAddOnsPrice = $addOnsPriceArr[$addOnsIndex];
                    ?>
                      <div class="add-ons-child">
                        <div class="add-ons-div">
                          <input type="text" class="add-ons-input form-control form-control-sm" value="<?=$newAddOns?>" disabled>
                          <input type="number" class="add-ons-input form-control form-control-sm" value="<?=$newAddOnsPrice?>" disabled>
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

<!-- Edit Add ons -->
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
                <label>Add-On</label>
                <label>Price</label>
              </div>
                <?php
                  $fetchAddOns = $connect->prepare("SELECT id,add_ons,add_ons_price,add_ons_category FROM tbladdons WHERE add_ons_category=?");
                  $fetchAddOns->bind_param('s',$addOnsCategory);
                  $fetchAddOns->execute();
                  $fetchAddOns->store_result();
                  $fetchAddOns->bind_result($id,$addOns,$addOnsFee,$addOnsGroup);
                  while($fetchAddOns->fetch()){
                    ?>
                  <div class="add-ons-child">
                      <div class="add-ons-div">
                        <input type="hidden" name="ids[]" value="<?=$id?>">
                        <input type="text" class="add-ons-input form-control form-control-sm" name="addOns[]" value="<?=$addOns?>" required>
                        <input type="number" class="add-ons-input form-control form-control-sm" name="addOnsPrice[]" value="<?=$addOnsFee?>" required>
                        <button type="submit" class="remove-btn" name="btn-remove-addOns" value="<?=$id?>">x</button>
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
<!--Remove All Add Ons of each menu category--->
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

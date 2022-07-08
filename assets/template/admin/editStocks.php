<!--Update Product Stocks-->
<div class="modal fade" id="editStocks<?=$id;?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Edit Quantity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <p>Product Name: <input type="text" class="bg-transparent" value="<?=$productName?>" name="productName" style="border:none; outline:none;"></p>
        <p>Stocks</p>
        <?php
              require 'public/connection.php';
              $getStocks = $connect->prepare("SELECT productVariation,stocks FROM tblproducts WHERE productName=?");
              $getStocks->bind_param('s',$productName);
              $getStocks->execute();
              $getStocks->store_result();
              $getStocks->bind_result($variations,$stock);
              while($getStocks->fetch()){
                  ?>
                      <div class="mt-3">
                          <input type="hidden" class="bg-transparent" value="<?=$productName?>" name="productName[]">
                          <input type="text" class="bg-transparent border-0 sizes" value="<?=$variations?>" name="size[]">
                          <input type="number" class="form-control  mt-2" value="<?=$stock?>" name="stocks[]" placeholder="Enter Stocks">
                      </div>
                  <?php
              }
        
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"  name="btn-update-stocks">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!---View Stocks--->
<div class="modal fade" id="viewStocks<?=$id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Quantity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Product Name: <?=$productName?></p>
        <?php
              require 'public/connection.php';
              $getStocks = $connect->prepare("SELECT productVariation,stocks FROM tblproducts WHERE productName=?");
              $getStocks->bind_param('s',$productName);
              $getStocks->execute();
              $getStocks->store_result();
              $getStocks->bind_result($variations,$stock);
              while($getStocks->fetch()){
                  ?>
                      <div class="mt-3">
                          <input type="text" class="bg-transparent border-0 sizes" value="<?=$variations?>" disabled>
                          <input type="number" class="form-control  mt-2" value="<?=$stock?>" name="stocks" disabled>
                      </div>
                  <?php
              }
        
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"  name="btn-update-stocks">Save</button>
      </div>
    </div>
  </div>
</div>
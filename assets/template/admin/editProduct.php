<!--Edit Product-->
<div class="modal fade" id="editProducts<?= $fetch['id']; ?>" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Product</h5>
        <button type="button" class="close xsa" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p id="editProduct">Edit Product</p>
        <div class="input-form">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $fetch['id'] ?>">
            <div class="mt-2">
              <label style="font-size: 1.1rem">Product Name</label>
              <input type="text" class="form-control" name="editProductName" placeholder="E
              nter Product Name" value="<?= $fetch['productName'] ?>" required>
            </div>
            <!---Edit Product Category!-->
            <div class="mt-2">
              <label style="font-size: 1.1rem">Category</label>
              <select name="editProductCategory" class="form-control" onchange="changeVariation(this)">
                <option value="">Select Category</option>  
                <option value="Promo" <?php if ($fetch['productCategory'] == "Promo") {echo 'selected ? "selected"';} ?>>Promo</option>
                <option value="Add Ons" <?php if ($fetch['productCategory'] == "Add Ons") echo 'selected ? "selected"'; ?>>Add Ons</option>
                <option value="Appetizer" <?php if ($fetch['productCategory'] == "Appetizer") echo 'selected ? "selected"'; ?>>Appetizer</option>
                <option value="Beef" <?php if ($fetch['productCategory'] == "Beef") echo 'selected ? "selected"'; ?>>Beef</option>
                <option value="Bbq" <?php if ($fetch['productCategory'] == "Bbq") echo 'selected ? "selected"'; ?>>Barbeque</option>     
                <option value="Beer Bucket" <?php if ($fetch['productCategory'] == "Beer Bucket") echo 'selected ? "selected"'; ?>>Beer Bucket(With Pulutan)</option>
                <option value="Beverages and Liqours" <?php if ($fetch['productCategory'] == "Beverages and Liqours") echo 'selected ? "selected"'; ?>>Beverages and Liqours</option>
                <option value="Carbonara Bilao" <?php if($fetch['productCategory'] == "Carbonara Bilao") echo 'selected ? "selected"'; ?>>Carbonara Bilao</option>
                <option value="Chicken" <?php if ($fetch['productCategory'] == "Chicken") echo 'selected ? "selected"'; ?>>Chicken</option>
                <option value="Dessert" <?php if ($fetch['productCategory'] == "Dessert") echo 'selected ? "selected"'; ?>>Dessert</option>
                <option value="Dimsum" <?php if ($fetch['productCategory'] == "Dimsum") echo 'selected ? "selected"'; ?>>Dimsum</option>
                <option value="Drinks" <?php if ($fetch['productCategory']  == "Drinks")echo 'selected ? "selected"'; ?>>Drinks</option>
                <option value="Grilled Siomai" <?php if ($fetch['productCategory']  == "Grilled Siomai")echo 'selected ? "selected"'; ?>>Grilled Siomai</option>
                <option value="Mang Macs Pulutan" <?php if ($fetch['productCategory']  == "Mang Macs Pulutan")echo 'selected ? "selected"'; ?>>Mang Macs Pulutan</option>
                <option value="Meals Good for 3 pax" <?php if ($fetch['productCategory'] == "Meals Good for 3 pax") echo 'selected ? "selected"'; ?>>Meals Good for 3 pax</option>
                <option value="Noodles" <?php if ($fetch['productCategory'] == "Noodles") echo 'selected ? "selected"'; ?>>Noodles</option>
                <option value="Pasta" <?php if ($fetch['productCategory'] == "Pasta") echo 'selected ? "selected"'; ?>>Pasta</option>
                <option value="Palabok Bilao"  <?php if ($fetch['productCategory'] == "Palabok Bilao") echo 'selected ? "selected"'; ?>>Palabok Bilao</option>
                <option value="Pancit" <?php if ($fetch['productCategory'] == "Pancit") echo 'selected ? "selected"'; ?>>Pancit</option>
                <option value="Pancit Bilao(Bihon)" <?php if ($fetch['productCategory'] == "Pancit Bilao(Bihon)") echo 'selected ? "selected"'; ?>>Pancit Bilao(Bihon)</option>
                <option value="Pancit Bilao(Canton)" <?php if ($fetch['productCategory'] == "Panict Bilao(Canton)") echo 'selected ? "selected"'; ?>>Pancit Bilao(Canton)</option>
                <option value="Pizza" <?php if ($fetch['productCategory'] == "Pizza") echo 'selected ? "selected"'; ?>>Pizza</option>
                <option value="Pork"  <?php if ($fetch['productCategory'] == "Pork") echo 'selected ? "selected"'; ?>>Pork</option>
                <option value="Pigar Pigar" <?php if ($fetch['productCategory'] == "Pigar Pigar") echo 'selected ? "selected"'; ?>>Pigar Pigar</option>
                <option value="Rice" <?php if ($fetch['productCategory'] == "Rice") echo 'selected ? "selected"'; ?>>Rice</option>
                <option value="Seafoods" <?php if ($fetch['productCategory'] == "Seafoods") echo 'selected ? "selected"'; ?>>Seafoods</option>
                <option value="Sizzling Plates" <?php if ($fetch['productCategory'] == "Sizzling Plates") echo 'selected ? "selected"'; ?>>Sizzling Plates</option>
                <option value="Spaghetti Bilao" <?php if ($fetch['productCategory'] == "Spaghetti Bilao") echo 'selected ? "selected"'; ?>>Spaghetti Bilao</option>
                <option value="Soup" <?php if ($fetch['productCategory'] == "Soup") echo 'selected ? "selected"'; ?>>Soup</option>
                <option value="Vegetable" <?php if ($fetch['productCategory'] == "Vegetable") echo 'selected ? "selected"'; ?>>Vegetable</option>
                <option value="Wine" <?php if ($fetch['productCategory'] == "Wine") echo 'selected ? "selected"'; ?>>Wine</option>
              </select>
            </div>
            <div class="mt-3">
              <label style="font-size: 1.1rem" class="mt-2">Price</label>
              <!--product with variation-->
              <div style="display: flex;">
                <input type="text" class="categoryPrice  bg-transparent border-0" name="editProductVariation" value="<?=$fetch['productVariation']?>" style="width: 120px">
                <input type="number" class="form-control" name="editProductPrice" placeholder="Enter Price" value="<?=$fetch['price']?>">
              </div>
            </div>
            <div class="mt-3">
              <label style="font-size: 1.1rem">Time of Preparation</label>
              <input type="number" class="form-control" name="editPreparedTime" placeholder="e.g (20 mins)" value="<?=$fetch['preparationTime']?>">
            </div>
           <div class="mt-2">
            <label style="font-size: 1.1rem">Choose Image</label>
            <input type="file" multiple accept="image/png, image/jpeg, image/jpg" name="editImageProduct">
            <img src="<?= $fetch['productImage']; ?>" alt="image" width="50">
           </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="btn-update-products">Save</button>
      </div>
     
    </div>
  </div>
</div>
<!--Delete--->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
  <div class="modal fade" id="deleteProduct<?= $fetch['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mang Mac's Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $fetch['id']; ?>">
          <p>Delete Product</p>
          <div class="modal-body-container">
            <i class="fas fa-exclamation-circle fa-3x icon-warning"></i><br>
            <p class="icon-text-warning">Are you sure you want to delete the product(s) that you selected?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" name="btn-delete-products">Delete</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- View Product -->
<div class="modal fade" id="viewProduct<?= $fetch['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="d-flex justify-content-center">
            <img src="<?= $fetch['productImage']?>" alt="image product" width="250">
          </div>
          <div>
            <p>Product Name: <?=$fetch['productName'];?></p>
            <p>Category: <?=$fetch['productCategory']?></p>
            <p>Variation: <?=$fetch['productVariation']?></p>
            <p>Price: ₱ <?=$fetch['price']?>.00</p>
            <p>Time of Preparation: <?=$fetch['preparationTime']?>mins</p>
            <p>Created At: <?=date('F d, Y h:i:s',strtotime($fetch['created_at']));?></p>
          </div>
        </div>
   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
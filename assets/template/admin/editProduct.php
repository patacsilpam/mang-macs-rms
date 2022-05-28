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
            <input type="hidden" name="id" value="<?= $fetch['id'] ?>" id="ID">
            <div class="mt-2">
              <label for="prodName">Product Name</label>
              <input type="text" class="form-control" name="editProductName" placeholder="E
              nter Product Name" value="<?= $fetch['productName'] ?>" required>
            </div>
            <!---Edit Product Category!-->
            <div class="mt-2">
              <label for="prodCategory">Product Category</label>
              <select name="editProductCategory" class="form-control editProductCategory" onchange="changeVariation(this)">
                <option value="">Select Category</option>  
                <option value="Promo" <?php if ($fetch['productCategory'] == "Promo") {echo 'selected ? "selected"';} ?>>Promo</option>
                <option value="Add Ons" <?php if ($fetch['productCategory'] == "Add Ons") echo 'selected ? "selected"'; ?>>Add Ons</option>
                <option value="Appetizer" <?php if ($fetch['productCategory'] == "Appetizer") echo 'selected ? "selected"'; ?>>Appetizer</option>
                <option value="Bbq" <?php if ($fetch['productCategory'] == "Bbq") echo 'selected ? "selected"'; ?>>Barbeque</option>     
                <option value="Beer Bucket" <?php if ($fetch['productCategory'] == "Beer Bucket") echo 'selected ? "selected"'; ?>>Beer Bucket(With Pulutan)</option>
                <option value="Beverages and Liqours" <?php if ($fetch['productCategory'] == "Beverages and Liqours") echo 'selected ? "selected"'; ?>>Beverages and Liqours</option>
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
                <option value="Pizza" <?php if ($fetch['productCategory'] == "Pizza") echo 'selected ? "selected"'; else echo "Pizza"; ?>>Pizza</option>
                <option value="Sizzling Plates" <?php if ($fetch['productCategory'] == "Sizzling Plates") echo 'selected ? "selected"'; else echo "Pizza"; ?>>Sizzling Plates</option>
                <option value="Spaghetti Bilao" <?php if ($fetch['productCategory'] == "Spaghetti Bilao") echo 'selected ? "selected"'; ?>>Spaghetti Bilao</option>
                <option value="Soup" <?php if ($fetch['productCategory'] == "Soup") echo 'selected ? "selected"'; ?>>Soup</option>
                <option value="Wine" <?php if ($fetch['productCategory'] == "Wine") echo 'selected ? "selected"'; ?>>Wine</option>
              </select>
            </div>
            <!---Edit Product Variation--!-->
           <div class="mt-2  editVariationContainer variationContainer">
           <label for="prodVariation">Select sub-category</label>
            <select name="editProductVariation" class="form-control editVariation">
              <option value="">Select sub-category</option>
              <optgroup label="Meals Good for 3 pax" class="mealsGoods mealsGood"  style="display: none;" >
                <option value="Beef" <?php if ($fetch['productVariation'] == "Beef") echo 'selected ? "selected"'; ?>>Beef</option>
                <option value="Chicken" <?php if ($fetch['productVariation'] == "Chicken") echo 'selected ? "selected"' ?>>Chicken</option>
                <option value="Pork" <?php if ($fetch['productVariation'] == "Pork") echo 'selected ? "selected"' ?>>Pork</option>
                <option value="Pigar Pigar" <?php if($fetch['productVariation'] == "Pigar Pigar") echo 'selected ? "selected"';?>>Pigar Pigar</option>
                <option value="Rice" <?php if($fetch['productVariation'] == "Rice") echo 'selected ? "selected"';?>>Rice</option>
                <option value="Seafoods" <?php if ($fetch['productCategory'] == "Seafoods") echo 'selected ? "selected"'; ?>>Seafoods</option>
                <option value="Vegetable" <?php if($fetch['productVariation'] == "Vegetable") echo 'selected ? "selected"';?>>Vegetable</option> 
              </optgroup>
              <optgroup label="Pizza"  class="pizzas pizza"  style="display: none;">
                <option value="Medium" <?php if ($fetch['productVariation'] == "Medium") echo 'selected ? "selected"' ?>>Medium</option>
                <option value="Large" <?php if ($fetch['productVariation'] == "Large") echo 'selected ? "selected"' ?>>Large</option>
              </optgroup>
              <optgroup label="Palabok Bilao" class="palabokBilaos palabokBilao"  style="display: none;">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
              <optgroup label="Pancit Bilao(Bihon)" class="pancitBihons pancitBihon"  style="display: none;">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
              <optgroup label="Pancit Bilao(Canton)"  class="pancitCantons pancitCanton"  style="display: none;">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
              <optgroup label="Spaghetti Bilao"  class="spaghettiBilaos spaghettiBilao"  style="display: none;">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
            </select>
           </div>
            <div class="mt-2">
              <label for="status">Status</label>
              <select name="editStatus" class="form-control" required>
                <option value="In Stock" <?php if ($fetch['status'] == "In Stock") echo 'selected ? "selected"'; ?>>In stock</option>
                <option value="Out of Stock" <?php if ($fetch['status'] == "Out of Stock") echo 'selected ? "selected"'; ?>>Out of Stock</option>
              </select>
            </div>
           <div class="mt-2">
              <label for="prodPrice">Product Price</label>
              <input type="number" class="form-control" name="editProductPrice" placeholder="Enter Product Price" value="<?= $fetch['price'] ?>" required>
           </div>
           <div class="mt-2">
            <label for="prodImage">Choose Image</label>
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
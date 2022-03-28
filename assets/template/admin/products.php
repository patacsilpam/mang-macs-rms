<!-- Add Product -->
<div class="modal fade" id="addProducts" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Add Product</p>
        <div class="input-form">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id">
            <div>
              <label for="prodName">Product Name</label>
              <input type="text" class="form-control" id="prodName" name="productName" placeholder="Enter Product Name" required>
            </div>
            <div class="mt-2">
            <label for="prodCategory">Product Category</label>
              <select name="productCategory" id="prodCategory" class="form-control">
                <option value="">Select Category</option>
                <option value="Appetiser">Appetiser</option>
                <option value="Combo Budget Meals">Combo Buget Meals</option>
                <option value="Dimsum">Dimsum</option>
                <option value="Drinks">Drinks</option>
                <option value="Meals Good for 3 pax">Meals Good for 3 pax</option>
                <option value="Noodles">Noodles</option>
                <option value="Pancit">Pancit</option>
                <option value="Pancit Bilao(Bihon)">Pancit Bilao(Bihon)</option>
                <option value="Pancit Bilao(Canton)">Pancit Bilao(Canton)</option>
                <option value="Palabok Bilao">Palabok Bilao</option>
                <option value="Pizza">Pizza</option>
                <option value="Rice">Rice</option>
                <option value="Rice Meals with Ice Tea">Rice Meals with Ice Tea</option>
                <option value="Spaghetti Bilao">Spaghetti Bilao</option>
                <option value="Seafoods">Seafoods</option>
                <option value="Soup">Soup</option>
                <option value="Vegetables">Vegetables</option>
              </select>
            </div>
            <div class="mt-2">
            <label for="prodVariation">Product Variation</label>
              <select name="productVariation" id="prodVariation" class="form-control">
                <option value="">Select Variation</option>
                <option value="">None</option>
                <optgroup label="Meals Good for 3 pax">
                  <option value="Beef">Beef</option>
                  <option value="Chicken">Chicken</option>
                  <option value="Pork">Pork</option>
                </optgroup>
                <optgroup label="Pizza">
                  <option value="Medium">Medium</option>
                  <option value="Large">Large</option>
                </optgroup>
                <optgroup label="Palabok Bilao">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
                <optgroup label="Pancit Bilao(Bihon)">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
                <optgroup label="Pancit Bilao(Canton)">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
                <optgroup label="Spaghetti Bilao">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
              </select>
            </div>
            <div class="mt-2">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control" required>
                <option value="In Stock">In stock</option>
                <option value="Out of Stock">Out of Stock</option>
              </select>
            </div>
            <div class="mt-2">
            <label for="prodPrice">Product Price</label>
            <input type="number" class="form-control" name="productPrice" id="prodPrice" placeholder="Enter Product Price" required>
            </div>
            <div class="mt-2">
              <label for="prodImage">Choose Image</label>
              <input type="file" multiple accept="image/png, image/jpeg, image/jpg" name="imageProduct" required>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="btn-save-products">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Edit Product-->
<div class="modal fade" id="editProducts<?= $fetch['id']; ?>" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Edit Product</p>
        <div class="input-form">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $fetch['id'] ?>">
            <div class="mt-2">
              <label for="prodName">Product Name</label>
              <input type="text" class="form-control" id="prodName" name="editProductName" placeholder="E
              nter Product Name" value="<?= $fetch['productName'] ?>" required>
            </div>
            <div class="mt-2">
              <label for="prodCategory">Product Category</label>
              <select name="editProductCategory" id="prodCategory" class="form-control">
                <option value="">Select Category</option>
                <option value="Appetiser" <?php if ($fetch['productCategory'] == "Appetiser") echo 'selected ? "selected"'; ?>>Appetiser</option>
                <option value="Combo Budget Meals" <?php if ($fetch['productCategory'] == "Combo Budget Meals") echo 'selected ? "selected"'; ?>>Combo Buget Meals</option>
                <option value="Dimsum" <?php if ($fetch['productCategory'] == "Dimsum") echo 'selected ? "selected"'; ?>>Dimsum</option>
                <option value="Drinks" <?php if ($fetch['productCategory'] == "Drinks") echo 'selected ? "selected"'; ?>>Drinks</option>
                <option value="Meals Good for 3 pax" <?php if ($fetch['productCategory'] == "Meals Good for 3 pax") echo 'selected ? "selected"'; ?>>Meals Good for 3 pax</option>
                <option value="Noodles" <?php if ($fetch['productCategory'] == "Noodles") echo 'selected ? "selected"'; ?>>Noodles</option>
                <option value="Pancit" <?php if ($fetch['productCategory'] == "Pancit") echo 'selected ? "selected"'; ?>>Pancit</option>
                <option value="Pancit Bilao(Bihon)" <?php if ($fetch['productCategory'] == "Pancit Bilao(Bihon)") echo 'selected ? "selected"'; ?>>Pancit Bilao(Bihon)</option>
                <option value="Pancit Bilao(Canton)" <?php if ($fetch['productCategory'] == "Panict Bilao(Canton)") echo 'selected ? "selected"'; ?>>Pancit Bilao(Canton)</option>
                <option value="Palabok Bilao" <?php if ($fetch['productCategory'] == "Palabok Bilao") echo 'selected ? "selected"'; ?>>Palabok Bilao</option>
                <option value="Pizza" <?php if ($fetch['productCategory'] == "Pizza") echo 'selected ? "selected"'; ?>>Pizza</option>
                <option value="Rice" <?php if ($fetch['productCategory'] == "Rice") echo 'selected ? "selected"'; ?>>Rice</option>
                <option value="Rice Meals with Ice Tea" <?php if ($fetch['productCategory'] == "Rice Meals with Ice Tea") echo 'selected ? "selected"'; ?>>Rice Meals with Ice Tea</option>
                <option value="Spaghetti Bilao" <?php if ($fetch['productCategory'] == "Spaghetti Bilao") echo 'selected ? "selected"'; ?>>Spaghetti Bilao</option>
                <option value="Seafoods" <?php if ($fetch['productCategory'] == "Seafoods") echo 'selected ? "selected"'; ?>>Seafoods</option>
                <option value="Soup" <?php if ($fetch['productCategory'] == "Soup") echo 'selected ? "selected"'; ?>>Soup</option>
                <option value="Vegetables" <?php if ($fetch['productCategory'] == "Vegetables") echo 'selected ? "selected"'; ?>>Vegetables</option>
              </select>
            </div>
           <div class="mt-2">
           <label for="prodVariation">Product Variation</label>
            <select name="editProductVariation" id="prodVariation" class="form-control">
              <option value="">Select Variation</option>
              <optgroup label="Meals Good for 3 pax">
                <option value="Beef" <?php if ($fetch['productVariation'] == "Beef") echo 'selected ? "selected"'; ?>>Beef</option>
                <option value="Chicken" <?php if ($fetch['productVariation'] == "Chicken") echo 'selected ? "selected"' ?>>Chicken</option>
                <option value="Pork" <?php if ($fetch['productVariation'] == "Pork") echo 'selected ? "selected"' ?>>Pork</option>
              </optgroup>
              <optgroup label="Pizza">
                <option value="Medium" <?php if ($fetch['productVariation'] == "Medium") echo 'selected ? "selected"' ?>>Medium</option>
                <option value="Large" <?php if ($fetch['productVariation'] == "Large") echo 'selected ? "selected"' ?>>Large</option>
              </optgroup>
              <optgroup label="Palabok Bilao">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
              <optgroup label="Pancit Bilao(Bihon)">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
              <optgroup label="Pancit Bilao(Canton)">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
              <optgroup label="Spaghetti Bilao">
                <option value="7-10 Person" <?php if ($fetch['productVariation'] == "7-10 Person") echo 'selected ? "selected"' ?>>7 - 10 Person</option>
                <option value="10-15 Person" <?php if ($fetch['productVariation'] == "10-15 Person") echo 'selected ? "selected"' ?>>10 - 15 Person</option>
                <option value="15-20 Person" <?php if ($fetch['productVariation'] == "15-20 Person") echo 'selected ? "selected"' ?>>15 - 20 Person</option>
              </optgroup>
            </select>
           </div>
            <div class="mt-2">
              <label for="status">Status</label>
              <select name="editStatus" id="status" class="form-control" required>
                <option value="In Stock" <?php if ($fetch['status'] == "In Stock") echo 'selected ? "selected"'; ?>>In stock</option>
                <option value="Out of Stock" <?php if ($fetch['status'] == "Out of Stock") echo 'selected ? "selected"'; ?>>Out of Stock</option>
              </select>
            </div>
           <div class="mt-2">
              <label for="prodPrice">Product Price</label>
              <input type="number" class="form-control" name="editProductPrice" id="prodPrice" placeholder="Enter Product Price" value="<?= $fetch['price'] ?>" required>
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
      </form>
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
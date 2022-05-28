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
              <select name="productCategory" class="form-control prodCategory" onchange="changeVariation(this)">
                <option value="">Select Category</option>
                <option value="Promo">Promo</option>
                <option value="Add Ons">Add Ons</option>
                <option value="Appetizer">Appetizer</option>
                <option value="Bbq">Barbeque</option>     
                <option value="Beer Bucket">Beer Bucket(With Pulutan)</option>
                <option value="Beverages and Liqours">Beverages and Liqours</option>
                <option value="Dessert">Dessert</option>
                <option value="Dimsum">Dimsum</option>
                <option value="Drinks">Drinks</option>
                <option value="Grilled Siomai">Grilled Siomai</option>
                <option value="Mang Macs Pulutan">Mang Macs Pulutan</option>
                <option value="Meals Good for 3 pax">Meals Good for 3 pax</option>
                <option value="Noodles">Noodles</option>
                <option value="Pasta">Pasta</option>
                <option value="Palabok Bilao">Palabok Bilao</option>
                <option value="Pancit">Pancit</option>
                <option value="Pancit Bilao(Bihon)">Pancit Bilao(Bihon)</option>
                <option value="Pancit Bilao(Canton)">Pancit Bilao(Canton)</option>
                <option value="Pizza">Pizza</option>
                <option value="Sizzling Plates">Sizzling Plates</option>
                <option value="Spaghetti Bilao">Spaghetti Bilao</option>
                <option value="Soup">Soup</option>
                <option value="Wine">Wine</option>
              </select>
            </div>
            <div class="mt-2 variationContainer">
            <label for="prodVariation">Select sub-category</label>
              <select name="productVariation" class="form-control">
                <option value="">Select sub-category</option>
                <optgroup label="Meals Good for 3 pax" class="mealsGood">
                  <option value="Beef">Beef</option>
                  <option value="Chicken">Chicken</option>
                  <option value="Pork">Pork</option>
                  <option value="Pigar Pigar">Pigar Pigar</option>
                  <option value="Rice">Rice</option>
                  <option value="Seafoods">Seafoods</option>
                  <option value="Vegetable">Vegetable</option>
                </optgroup>
                <optgroup label="Pizza"  class="pizza">
                  <option value="Medium">Medium</option>
                  <option value="Large">Large</option>
                </optgroup>
                <optgroup label="Palabok Bilao" class="palabokBilao">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
                <optgroup label="Pancit Bilao(Bihon)" class="pancitBihon">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
                <optgroup label="Pancit Bilao(Canton)" class="pancitCanton">
                  <option value="7-10 Person">7 - 10 Person</option>
                  <option value="10-15 Person">10 - 15 Person</option>
                  <option value="15-20 Person">15 - 20 Person</option>
                </optgroup>
                <optgroup label="Spaghetti Bilao" class="spaghettiBilao">
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




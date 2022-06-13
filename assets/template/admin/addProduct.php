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
            <input type="hidden" name="id[]">
            <input type="hidden" name="stocks" value="0">
            <div>
              <label style="font-size: 1.1rem">Product Name</label>
              <input type="text" class="form-control" id="prodName" name="productName" placeholder="Enter Product Name" required>
            </div>
            <div class="mt-3">
            <label style="font-size: 1.1rem">Category</label>
              <select name="productCategory" class="form-control" onchange="changeVariation(this)">
                <option value="">Select Category</option>
                <option value="Promo">Promo</option>
                <option value="Add Ons">Add Ons</option>
                <option value="Appetizer">Appetizer</option>
                <option value="Bbq">Barbeque</option>     
                <option value="Beef">Beef</option>
                <option value="Beer Bucket">Beer Bucket(With Pulutan)</option>
                <option value="Beverages and Liqours">Beverages and Liqours</option>
                <option value="Carbonara Bilao">Carbonara Bilao</option>
                <option value="Chicken">Chicken</option>
                <option value="Dessert">Dessert</option>
                <option value="Dimsum">Dimsum</option>
                <option value="Drinks">Drinks</option>
                <option value="Grilled Siomai">Grilled Siomai</option>
                <option value="Mang Macs Pulutan">Mang Macs Pulutan</option>
                <option value="Noodles">Noodles</option>
                <option value="Pasta">Pasta</option>
                <option value="Palabok Bilao">Palabok Bilao</option>
                <option value="Pancit">Pancit</option>
                <option value="Pancit Bilao(Bihon Guisado)">Pancit Bilao(Bihon Guisado)</option>
                <option value="Pancit Bilao(Canton Bihon)">Pancit Bilao(Canton Bihon)</option>
                <option value="Pork">Pork</option>
                <option value="Pigar Pigar">Pigar Pigar</option>
                <option value="Pizza">Pizza</option>
                <option value="Rice">Rice</option>
                <option value="Seafoods">Seafoods</option>
                <option value="Sizzling Plates">Sizzling Plates</option>
                <option value="Spaghetti Bilao">Spaghetti Bilao</option>
                <option value="Soup">Soup</option>
                <option value="Vegetable">Vegetable</option>
                <option value="Wine">Wine</option>
              </select>
            </div>
            <div class="noCategoryPrice mt-3" style="display: none;">
              <label style="font-size: 1.1rem">Price</label>
              <input type="number" class="form-control  mt-2 " name="price" placeholder="Enter Price">
            </div>
            <div class="pizzaPrice mt-3" style="display: none;">
              <label style="font-size: 1.1rem">Price</label>
              <!--Medium-->
              <div style="display: flex;">
                <input type="text" class="bg-transparent border-0" name="pizzaSize[]" value="Medium" style="width: 80px">
                <input type="number" class="form-control  mt-2 " name="pizzaPrice[]" placeholder="Enter Price">
              </div>
              <div class="mt-3"  style="display: flex;">
                <input type="text" class="bg-transparent border-0" name="pizzaSize[]" value="Large" style="width: 80px">
                <input type="number" class="form-control mt-2" name="pizzaPrice[]" placeholder="Enter Price">
              </div>
            </div>
            <div class="bilaoPrice mt-3" style="display: none;">
              <label style="font-size: 1.1rem">Price</label>
              <!--Medium-->
              <div style="display: flex;">
                <input type="text" class="bg-transparent border-0" name="bilaoSize[]" value="7 - 10 Person" style="width: 120px">
                <input type="number" class="form-control  mt-2 " name="bilaoPrice[]" placeholder="Enter Price">
              </div>
              <div class="mt-3"  style="display: flex;">
                <input type="text" class="bg-transparent border-0" name="bilaoSize[]" value="10 -15 Person" style="width: 120px">
                <input type="number" class="form-control mt-2" name="bilaoPrice[]" placeholder="Enter Price">
              </div>
              <div class="mt-3"  style="display: flex;">
                <input type="text" class="bg-transparent border-0" name="bilaoSize[]" value="15 -20 Person" style="width: 120px">
                <input type="number" class="form-control mt-2" name="bilaoPrice[]" placeholder="Enter Price">
              </div>
            </div>
            <div class="mt-3">
              <label style="font-size: 1.1rem">Time of Preparation</label>
              <input type="number" class="form-control" name="preparedTime" placeholder="e.g (20 mins)">
            </div>
            <div style="font-size: 1.1rem" class="mt-2">
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







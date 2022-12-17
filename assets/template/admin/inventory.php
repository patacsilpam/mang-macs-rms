<!-- Add Product -->
<div class="modal fade" id="addInventory" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Add</p>
                <div class="input-form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <input type="hidden" name="id">
                        <div class="mt2">
                            <label>Purchased Date</label>
                            <input type="date" id="purchasedDate" name="purchasedDate" class="form-control" required>
                        </div>
                        <div class="mt2">
                            <label>Expiration Date</label>
                            <input type="date" id="expirationDate" name="expirationDate" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label>Item Category</label>
                            <div>
                                <select id="category" class="form-control item-category" name="itemCategory" required onchange="changeCategory(this)">
                                    <option disabled selected>Please Choose...</option>
                                    <?php
                                    require 'public/connection.php';
                                        $fetchCategoryDb = $connect->prepare("SELECT productCategory FROM tblproducts
                                        WHERE productCategory IN ('Beverages and Liqours','Drinks','Pizza','Wine') GROUP BY productCategory");
                                        $fetchCategoryDb->execute();
                                        $fetchCategoryDb->store_result();
                                        $fetchCategoryDb->bind_result($productCategory);
                                        while($fetchCategoryDb->fetch()){
                                            ?>
                                                <option value="<?=$productCategory?>"><?=$productCategory?></option>
                                            <?php
                                        }
                                        
                                    ?>
                                </select>
                            </div>  
                            <div class="mt-2" style="display:none" id="pizzaBread">
                                <label>Item Name</label>
                                <select class="form-control" name="product">
                                    <option disabled selected>Please Choose...</option>
                                    <option value="Pizza Bread">Pizza Bread</option>
                                </select>
                            </div>
                            <div class="mt-2" style="display:none" id="bevLiqours">
                                <label>Item Name</label>
                                <select class="form-control" name="product">
                                    <option disabled selected>Please Choose...</option>
                                    <?php
                                        require 'public/connection.php';
                                        $fetchCategoryDb = $connect->prepare("SELECT productName,stockCode FROM tblproducts WHERE productCategory = 'Beverages and Liqours'");
                                        $fetchCategoryDb->execute();
                                        $fetchCategoryDb->store_result();
                                        $fetchCategoryDb->bind_result($productName,$stockCode);
                                        while($fetchCategoryDb->fetch()){
                                            ?>
                                                <option value="<?=$productName?>"><?=$productName?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mt-2" style="display:none" id="drinks">
                                <label>Item Name</label>
                                <select class="form-control" name="product">
                                    <option disabled selected>Please Choose...</option>
                                    <?php
                                        require 'public/connection.php';
                                        $fetchCategoryDb = $connect->prepare("SELECT productName,stockCode FROM tblproducts WHERE productCategory = 'Drinks'");
                                        $fetchCategoryDb->execute();
                                        $fetchCategoryDb->store_result();
                                        $fetchCategoryDb->bind_result($productName,$stockCode);
                                        while($fetchCategoryDb->fetch()){
                                            ?>
                                                <option value="<?=$productName?>"><?=$productName?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mt-2" style="display:none" id="wine">
                                <label>Item Name</label>
                                <select class="form-control" name="product">
                                    <option disabled selected>Please Choose...</option>
                                    <?php
                                        require 'public/connection.php';
                                        $fetchCategoryDb = $connect->prepare("SELECT productName,stockCode FROM tblproducts WHERE productCategory = 'Wine'");
                                        $fetchCategoryDb->execute();
                                        $fetchCategoryDb->store_result();
                                        $fetchCategoryDb->bind_result($productName,$stockCode);
                                        while($fetchCategoryDb->fetch()){
                                            ?>
                                                <option value="<?=$productName?>"><?=$productName?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mt-2" style="display:none" id="beerBucket">
                                <label>Item Name</label>
                                <select class="form-control" name="product">
                                    <option disabled selected>Please Choose...</option>
                                    <?php
                                        require 'public/connection.php';
                                        $fetchCategoryDb = $connect->prepare("SELECT productName,stockCode FROM tblproducts WHERE productCategory = 'Beer Bucket'");
                                        $fetchCategoryDb->execute();
                                        $fetchCategoryDb->store_result();
                                        $fetchCategoryDb->bind_result($productName,$stockCode);
                                        while($fetchCategoryDb->fetch()){
                                            ?>
                                                <option value="<?=$productName?>"><?=$productName?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-2" id="pizzaVariation" style="display:none">
                            <label>Item Variation</label>
                            <select class="form-control" name="itemVariation" required>
                                <option disabled selected>Please Choose...</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label>Item Purchase</label>
                            <input type="number" class="form-control" name="quantityPurchased" placeholder="Enter Quantity Purchased" required>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btn-save-inventory">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Edit Product-->
<div class="modal fade" id="editInventory<?= $fetch['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Mang Macs Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Edit</p>
                <div class="input-form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <input type="hidden" name="id" value="<?=$fetch['id']?>">
                        <input type="hidden" name="code" value="<?=$fetch['code']?>">
                        <div class="mt2">
                            <label for="expirationDate">Purchased Date</label>
                            <input type="date" id="purchasedDate" name="purchasedDate" class="form-control"
                                value="<?=$fetch['created_at']?>" required>
                        </div>
                        <div class="mt2">
                            <label for="expirationDate">Expiration Date</label>
                            <input type="date" id="expirationDate" name="expirationDate" class="form-control"
                                value="<?=$fetch['expiration_date']?>" required>
                        </div>
                        <div class="mt-2">
                            <label>Item Category</label>
                            <select class="form-control" name="product">
                                
                                <?php
                                    require 'public/connection.php';
                                    $category = $fetch['itemCategory'];
                                    $prod = $fetch['product'];
                                    if($category != "Pizza"){
                                        $fetchCategoryDb = $connect->prepare("SELECT productName,stockCode FROM tblproducts WHERE productCategory = '$category' GROUP BY productName");
                                        $fetchCategoryDb->execute();
                                        $fetchCategoryDb->store_result();
                                        $fetchCategoryDb->bind_result($productName,$stockCode);
                                        while($fetchCategoryDb->fetch()){
                                            ?>
                                                <option value="<?=$productName?>" <?php if($productName == $prod){echo "selected ? 'selected'";}?>><?=$productName?></option>
                                            <?php
                                        }
                                    }
                                    else{
                                        ?>
                                            <option value="Pizza Bread">Pizza Bread</option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label>Item Category</label>
                            <input type="text" class="form-control" name="itemCategory" placeholder="Enter Item Category" value="<?=$fetch['itemCategory']?>" readonly>
                        </div>
                        <div class="mt-2">
                            <label for="product">Item Variation</label>
                            <select class="form-control" name="itemVariation">
                                <option disabled selected>Please Choose...</option>
                                <option value="Medium" <?php if($fetch['itemVariation'] == "Medium") {echo "selected ? 'selected'";}?>>Medium</option>
                                <option value="Large" <?php if($fetch['itemVariation'] == "Large") {echo "selected ? 'selected'";}?>>Large</option>
                            </select>
                        </div>
                        <div  class="mt-2">
                          <label for="quantity">Add/Remove Quantity Purchased</label>
                          <input type="number" class="form-control" name="quantityPurchased" placeholder="0" value="0"/>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btn-edit-inventory">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- View Users -->
<div class="modal fade" id="viewStocks<?= $fetch['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div>
            <div class="d-flex justify-content-center">
            </div>
            <div>
                <p>Purchased Date: <?=date('F d, Y',strtotime($fetch['created_at']));?></p>
                <p>Expiration Date: <?=date('F d, Y',strtotime($fetch['expiration_date']))?></p>
                <p>Name: <?=$fetch['product']?></p>
                <p>Category: <?=$fetch['itemCategory']?></p>
                <p>Variation: <?=$fetch['itemVariation']?></p>
                <p>Quantity Purchased: <?=$fetch['quantityPurchased']?></p>
                <p>Quantity Stock: <?=$fetch['quantityInStock']?></p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Delete-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
    <div class="modal fade" id="deleteInventory<?= $fetch['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Mang Mac's Product</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $fetch['id']; ?>">
                    <input type="hidden" name="code" value="<?= $fetch['code']; ?>">
                    <input type="hidden" name="purchased" value="<?= $fetch['quantityPurchased']; ?>">
                    <input type="hidden" name="product" value="<?= $fetch['product']; ?>">
                    <input type="hidden" name="itemCategory" value="<?= $fetch['itemCategory']; ?>">
                    <input type="hidden" name="itemVariation" value="<?= $fetch['itemVariation']; ?>">
                    <h4>Delete</h4>
                    <div class="modal-body-container">
                        <i class="fas fa-exclamation-circle fa-3x icon-warning"></i><br>
                        <p class="icon-text-warning">Are you sure you want to delete this item?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="btn-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    function incrementValue()
    {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('number').value = value;
    }
</script>

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
                            <label for="expirationDate">Expiration Date</label>
                            <input type="date" id="expirationDate" name="expirationDate" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="product">Product</label>
                            <input type="text" class="form-control" name="product" placeholder="Enter Product" required>
                        </div>
                        <div class="mt-2">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="Available">Availabe</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="quantity">Quantity Purchase</label>
                            <input type="number" class="form-control" name="quantityPurchased"
                                placeholder="Enter Quantity Purchased" required>
                        </div>
                        <div class="mt-2">
                            <label for="quantity">Quantity In Stock</label>
                            <input type="number" class="form-control" name="quantityInStock"
                                placeholder="Enter Quantity In Stock" required>
                        </div>
                        <div class="mt-2">
                            <label for="incharge">In charge</label>
                            <input type="text" class="form-control" name="incharge" placeholder="In charge" required>
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
                        <div class="mt2">
                            <label for="expirationDate">Expiration Date</label>
                            <input type="date" id="expirationDate" name="expirationDate" class="form-control"
                                value="<?=$fetch['expiration_date']?>" required>
                        </div>
                        <div class="mt-2">
                            <label for="product">Product</label>
                            <input type="text" class="form-control" name="product" placeholder="Enter Product"
                                value="<?=$fetch['product']?>" required>
                        </div>
                        <div class="mt-2">
                            <label for="quantity">Quantity Purchase</label>
                            <input type="number" class="form-control" name="quantityPurchased"
                                placeholder="Enter Quantity Purchased" value="<?= $fetch['quantityPurchased']?>"
                                required>
                        </div>
                        <div class="mt-2">
                            <label for="quantity">Quantity In Stock</label>
                            <input type="number" class="form-control" name="quantityInStock"
                                placeholder="Enter Quantity Purchased" value="<?= $fetch['quantityInStock']?>" required>
                        </div>
                        <div class="mt-2">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="Available"
                                    <?php if($fetch['status'] == "Available") echo 'selected ? "selected"'?>>Availabe
                                </option>
                                <option value="Not Available"
                                    <?php if($fetch['status'] == "Not Available") echo 'selected ? "selected"';?>>Not
                                    Available</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="incharge">In charge</label>
                            <input type="text" class="form-control" name="incharge" placeholder="In charge"
                                value="<?=$fetch['in_charge']?>" required>
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
                    <h4>Delete</h4>
                    <div class="modal-body-container">
                        <i class="fas fa-exclamation-circle fa-3x icon-warning"></i><br>
                        <p class="icon-text-warning">Are you sure you want to delete the product that you selected?</p>
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
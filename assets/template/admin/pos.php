<div class="add-product-container">
    <div class="container mt-3 add-product-container">
        <h2>Products</h2>
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link active m-1  bg-dark text-white" data-toggle="tab" href="#comboBudgetMeals">Combo
                    Budget Meals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#dimsum">Dimsum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#drinks">Drinks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#mealsGood">Meals Good For 3</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#pasta">Pasta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#pizza">Pizza</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#riceMealsWithIceTea">Rice Meals w/
                    Ice Tea</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#others">Others</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div id="comboBudgetMeals" class="container tab-pane active"><br>
                <h5>Combo Budget Meals</h5>
                <div class="product-container">
                    <?php
                        $getComboMeals = "SELECT * FROM tblproducts WHERE productCategory='Combo Budget Meals'";
                        $displayComboMeals = $connect->query($getComboMeals);
                            while($fetch = $displayComboMeals->fetch_assoc()){
                               
                            ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <div id="dimsum" class="container tab-pane fade"><br>
                <h5>Dimsum</h5>
                <div class="product-container">
                    <?php
                        $getDimsum = "SELECT * FROM tblproducts WHERE productCategory='Dimsum' ORDER BY id ASC";
                        $displayDimsum = $connect->query($getDimsum);
                            while($fetch = $displayDimsum->fetch_assoc()){
                            ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <div id="drinks" class="container tab-pane fade"><br>
                <h5>Drinks</h5>
                <div class="product-container">
                    <?php
                        $getDrinks = "SELECT * FROM tblproducts WHERE productCategory='Drinks' ORDER BY id ASC";
                        $displayDrinks = $connect->query($getDrinks);
                            while($fetch = $displayDrinks->fetch_assoc()){
                            ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <div id="mealsGood" class="container tab-pane fade"><br>
                <h5>Meals Good for 3 pax</h5>
                <div class="product-container">
                    <?php
                    $getMeals = "SELECT * FROM tblproducts WHERE productCategory='Meals Good for 3 pax' ORDER BY id ASC";
                    $displayMeals = $connect->query($getMeals);
                        while($fetch = $displayMeals->fetch_assoc()){
                        ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div id="pizza" class="container tab-pane fade"><br>
                <h5>Pizza</h5>
                <div class="product-container">
                    <?php
                    $getPizza = "SELECT * FROM tblproducts WHERE productCategory='pizza' ORDER BY id ASC";
                    $displayPizza = $connect->query($getPizza);
                        while($fetch = $displayPizza->fetch_assoc()){
                        ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage'] ?>" class="img-product" />
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div id="pasta" class="container tab-pane fade"><br>
                <h5>Pasta</h5>
                <div class="product-container">
                    <?php
                    $getPasta = "SELECT * FROM tblproducts WHERE productCategory='Palabok Bilao' OR productCategory='Pancit Bilao(Bihon)' 
                    OR productCategory='Panict Bilao(Canton)'  OR productCategory='Spaghetti Bilao' ORDER BY productCategory ASC";
                    $displayPasta = $connect->query($getPasta);
                        while($fetch = $displayPasta->fetch_assoc()){
                      
                        ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?= $fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div id="riceMealsWithIceTea" class="container tab-pane fade"><br>
                <h5>Rice Meals with Ice Tea</h5>
                <div class="product-container">
                    <?php
                        $getPasta = "SELECT * FROM tblproducts WHERE productCategory='Rice Meals with Ice Tea' ORDER BY id ASC";
                        $displayPasta = $connect->query($getPasta);
                            while($fetch = $displayPasta->fetch_assoc()){
                            ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <div id="others" class="container tab-pane fade"><br>
                <h5>Others</h5>
                <div class="product-container">
                    <?php
                    $getOthers = "SELECT * FROM tblproducts WHERE productCategory='Appetiser' OR productCategory='Noodles' OR productCategory='Pancit' 
                    OR productCategory='Rice' OR productCategory='Seafoods' OR productCategory='Soup' OR  productCategory='Vegetables' ORDER BY productCategory ASC";
                    $displayOthers = $connect->query($getOthers);
                        while($fetch = $displayOthers->fetch_assoc()){
                        ?>
                    <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                        <input type="hidden" value="<?=$fetch['code']?>">
                        <img src="<?=$fetch['productImage']?>" class="img-product">
                        <strong class="text-product-name"><?=$fetch['productName']?></strong>
                        <small class="text-dark"><?=$fetch['productVariation']?></small>
                        <label class="text-danger">₱<?=$fetch['price']?>.00</label>
                        <input type="number" class="form-control input-quantity" value="1" name="quantity">
                        <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    </form>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<div class="add-product-container">
    <div class="container mt-3 add-product-container">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#beerBucket">Beer Bucket w/ Pulutan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#beverages">Beverages & Liqours</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#bilao">Bilao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#pasta">Pasta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#dimsum">Dimsum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#soup">Soup</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#drinks">Drinks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#dessert">Dessert</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active m-1  bg-dark text-white" data-toggle="tab" href="#pizza">Mang Mac's Pizza</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#pulutan">Mang Mac's Pulutan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#grilledMenu">Mang Mac's Grilled Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#mealsGood">Meals Good For 3 pax</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#appetizer">Appetizer</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#sizzlingPlates">Sizzling Plates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#pancitNoodles">Pancit & Noodles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1  bg-dark text-white" data-toggle="tab" href="#wine">Wine</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!--Pizza--!--->
            <div id="pizza" class="container tab-pane active"><br>
                <h5>Mang Mac's Pizza</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Pizza' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <!---Add Category and Product Code Here :)----!-->
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                   
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Appetizer--!--->
             <div id="appetizer" class="container tab-pane fade"><br>
                <h5>Appetizer</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Appetizer' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Grilled Menu--!--->
             <div id="grilledMenu" class="container tab-pane fade"><br>
                <h5>Mang Mac's Grilled Menu</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Add Ons' OR productCategory='Bbq' OR productCategory='Grilled Siomai' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Meals Good for 3 pax--!--->
             <div id="mealsGood" class="container tab-pane fade"><br>
                <h5>Meals Good For 3 pax</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Meals Good for 3 pax' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Sizzling Plates--!--->
             <div id="sizzlingPlates" class="container tab-pane fade"><br>
                <h5>Sizzling Plates</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Sizzling Plates' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Sizzling Plates--!--->
             <div id="pancitNoodles" class="container tab-pane fade"><br>
                <h5>Pancit & Noodles</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Noodles' OR productCategory='Pancit' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Bilao--!--->
             <div id="bilao" class="container tab-pane fade"><br>
                <h5>Bilao</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Palabok Bilao' OR productCategory='Pancit Bilao(Bihon Guisado)' OR productCategory='Pancit Bilao(Canton Bihon)' OR productCategory='Spaghetti Bilao' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <!--Pasta--!--->
            <div id="pasta" class="container tab-pane fade"><br>
                <h5>Pasta</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Pasta'  ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Dimsum--!--->
             <div id="dimsum" class="container tab-pane fade"><br>
                <h5>Dimsum</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Dimsum' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <!--Dimsum--!--->
            <div id="soup" class="container tab-pane fade"><br>
                <h5>Soup</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Soup' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <!--Drinks--!--->
            <div id="drinks" class="container tab-pane fade"><br>
                <h5>Drinks</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Drinks' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <strong class="text-success">₱<?=$fetch['price']?>.00</strong>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <p class="text-danger"><?php if($fetch['stocks'] <= 10 && $fetch['stocks'] != 0){echo $fetch['stocks']." items left";} else{echo "";}?></p>
                    <button type="submit" name="add-to-cart" class="btn btn-warning" <?php if($fetch['stocks']  <= 0){ echo "disabled";}?>> 
                        <?php if($fetch['stocks'] <= 0){ echo "Not Available";} else{echo "Add";}?>
                    </button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
             <!--Dessert--!--->
             <div id="dessert" class="container tab-pane fade"><br>
                <h5>Dessert</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Dessert' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <!--Mang Macs Pulutan--!--->
            <div id="pulutan" class="container tab-pane fade"><br>
                <h5>Mang Mac's Pulutan</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Mang Macs Pulutan' ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <!--Mang Macs Pulutan--!--->
            <div id="beerBucket" class="container tab-pane fade"><br>
                <h5>Beer Bucket w/ Pulutan</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE productCategory='Beer Bucket'  ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <button type="submit" name="add-to-cart" class="btn btn-warning">Add</button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <div id="beverages" class="container tab-pane fade"><br>
                <h5>Beverages & Liqours</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE  productCategory='Beverages and Liqours'  ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <p class="text-danger"><?php if($fetch['stocks'] <= 10 && $fetch['stocks'] != 0){echo $fetch['stocks']." items left";} else{echo "";}?></p>
                    <button type="submit" name="add-to-cart" class="btn btn-warning" <?php if($fetch['stocks']  <= 0){ echo "disabled";}?>> 
                        <?php if($fetch['stocks'] <= 0){ echo "Not Available";} else{echo "Add";}?>
                    </button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
            <div id="wine" class="container tab-pane fade"><br>
                <h5>Wine</h5>
                <div class="product-container">
                <?php
                    $getMenu = "SELECT * FROM tblproducts WHERE  productCategory='Wine'  ORDER BY productname ASC";
                    $displayMenu = $connect->query($getMenu);
                    while($fetch = $displayMenu->fetch_assoc()){ 
                ?>
                <form method="POST" action="pos.php?action=add&code=<?=$fetch['code']?>" class="box-product">
                    <input type="hidden" value="<?=$fetch['code']?>">
                    <img src="<?=$fetch['productImage']?>" class="img-product">
                    <strong class="text-product-name"><?=$fetch['productName']?></strong>
                    <small class="text-dark"><?=$fetch['productVariation']?></small>
                    <label class="text-success">₱<?=$fetch['price']?>.00</label>
                    <input type="number" class="form-control input-quantity" value="1" name="quantity">
                    <p class="text-danger"><?php if($fetch['stocks'] <= 10 && $fetch['stocks'] != 0){echo $fetch['stocks']." items left";} else{echo "";}?></p>
                    <button type="submit" name="add-to-cart" class="btn btn-warning" <?php if($fetch['stocks']  <= 0){ echo "disabled";}?>> 
                        <?php if($fetch['stocks'] <= 0){ echo "Not Available";} else{echo "Add";}?>
                    </button>
                    <!---Add Category and Product Code Here :)----!-->
                </form>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>
        
    <script type="text/javascript">
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php
if(isset($_POST['add_to_cart'])){
    if(isset($_SESSION['user'])){
      if($logged_in_data['role'] == 'User'){
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user'];
        $quantity = 1;
  
        $select_product = $connection->prepare("SELECT * FROM `products` WHERE  product_id = ?");
        $select_product->execute([$product_id]);
        $selected_product = $select_product->fetch(PDO::FETCH_ASSOC);
        $colors = explode(',' , $selected_product['colors']);
  
        $check_cart = $connection->prepare("SELECT * FROM `cart` WHERE product_id = ? AND user_id = ?");
        $check_cart->execute([$product_id, $user_id]);
        $cart_items = $check_cart->fetch(PDO::FETCH_ASSOC);
  
        if($check_cart->rowCount() > 0){
          $update_cart = $connection->prepare("UPDATE `cart` SET quantity = ? ");
          $update_cart->execute([$cart_items['quantity']+1]);
        }
        else{
          $insert_cart = $connection->prepare("INSERT INTO `cart`(product_id, user_id, quantity, color) VALUES (?, ?, ?, ?)");
          $insert_cart->execute([$product_id, $user_id, $quantity, $colors[0]]);
        }
      }
      else{
        echo '<script>alert("Cannot buy when admin is logged in")</script>';
      }
   }
   else{
    header('location:userLogin.php');
   }
}


if(isset($_GET['category'])){
    $view = $_GET['category'];
    ?>
    <div class="container mt-2">
        <h3 class="text-start fw-bold">Showing results for "<?= $view;?>"</h3>
        <div class="row border-bottom justify-content-around">
        <?php
        $select_products = $connection->prepare("SELECT * FROM `products` WHERE category =?");
        $select_products->execute([$view]);
        if($select_products->rowCount() <= 0){
            echo 'No category or products found';
        }
        else{
            while($row = $select_products->fetch(PDO::FETCH_ASSOC)){
          $colors = explode(',', $row['colors']);
          $name = mb_strimwidth(ucwords($row['category']).' '. $row['name'].' '.$colors[0], 0, 16,'');
                ?>
                <div class="card col-sm-4 border-2 mt-1 mb-1" style="width: 12rem; ">
                <div class="p-2">
                    <a href="viewProduct.php?productId=<?= $row['product_id']; ?>" class="text-center pb-0 mb-0">
                        <img class="" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                        <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 1rem;"><?= $name;?></p>
                        <p class="text-bold text-start text-bold p-0 m-0" style="font-size: 1rem;"><s style="font-size: 0.9rem;"><?= $row['original_price'];?></s><b>&nbsp; &#8377;<?= $row['offer_price'];?></b><br><b class="text-success p-0 m-0" style="font-size: 0.9rem;"><?= 100-round(100 * ($row['offer_price']/$row['original_price']));?>% Off</b></p>
                    </a>
                    <form method="post">
                        <input type="hidden" value="<?= $row['product_id']; ?>" name="product_id">
                        <input type="submit" name="add_to_cart" class="btn btn-sm btn-secondary m-0" value="Add to Cart">
                    </form>                
            </div>
        </div>
            <?php
            }
        }
        ?>
        </div>
    </div>
<?php
}

elseif(isset($_POST['search'])){
    $searchning_for = $_POST['searching_for'];
    ?>
    <div class="container-fluid mt-2">
        <h3 class="text-start fw-bold">Showing results for "<?= $searchning_for;?>"</h3>
        <div class="row border-bottom justify-content-around">
        <?php
        $select_products = $connection->prepare("SELECT * FROM `products` WHERE name LIKE '%$searchning_for%' OR category LIKE '%$searchning_for%' OR colors LIKE '%$searchning_for%'");
        $select_products->execute();
        if($select_products->rowCount() <= 0){
            echo 'No category or products found';
        }
        else{
            while($row = $select_products->fetch(PDO::FETCH_ASSOC)){
          $colors = explode(',', $row['colors']);
          $name = mb_strimwidth(ucwords($row['category']).' '. $row['name'].' '.$colors[0], 0, 16,'');
                ?>
                <div class="card col-sm-4 border-2 mt-1 mb-1" style="width: 11rem; ">
                <div class="p-2">
                    <a href="viewProduct.php?productId=<?= $row['product_id']; ?>" class="text-center pb-0 mb-0">
                        <img class="" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                        <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 1rem;"><?= $name;?></p>
                        <p class="text-bold text-start text-bold p-0 m-0" style="font-size: 1rem;"><s style="font-size: 0.9rem;"><?= $row['original_price'];?></s><b>&nbsp; &#8377;<?= $row['offer_price'];?></b><br><b class="text-success p-0 m-0" style="font-size: 0.9rem;"><?= 100-round(100 * ($row['offer_price']/$row['original_price']));?>% Off</b></p>
                    </a>
                    <form method="post">
                        <input type="hidden" value="<?= $row['product_id']; ?>" name="product_id">
                        <input type="submit" name="add_to_cart" class="btn btn-sm btn-secondary m-0" value="Add to Cart">
                    </form>                
            </div>
        </div>
            <?php
            }
        }
        ?>
        </div>
    </div>
<?php    
}

?>
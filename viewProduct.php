<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php

if(isset($_POST['add_to_cart'])){
    if(isset($_SESSION['user'])){
      if($logged_in_data['role'] == 'User'){
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user'];
        $color = $_POST['color'];
        $size = $_POST['size'];
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
          $insert_cart = $connection->prepare("INSERT INTO `cart`(product_id, user_id, quantity, color, size) VALUES (?, ?, ?, ?, ?)");
          $insert_cart->execute([$product_id, $user_id, $quantity, $color, $size]);
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

if(isset($_GET['productId'])){
    $product_id = $_GET['productId'];

    $select_product = $connection->prepare("SELECT * FROM `products` WHERE product_id = ?");
    $select_product->execute([$product_id]);
    $row = $select_product->fetch(PDO::FETCH_ASSOC);
    $sizes = explode(',', $row['size']);
    $colors = explode(',', $row['colors']);
    $name = ucwords($row['category']).' '. $row['name'].' '.$colors[0];
    ?>
    <div class="container bg-white p-2 mt-3 mb-3">
        <form method="post">
            <div class="row justify-content-around">

                <div class="col-sm-5 mt-2">
                    <img class="card-img" style="object-fit: contain;" width="500px" src="admin/Products/<?= $row['photo'];?>">
                </div>

                <div class="col-sm-6 mt-3">
                    <h1 class="fw-bold text-start p-1 m-0 text-bold"><?= $name ;?></h1>
                    <span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
                    <p class=" text-start text-bold p-0 m-0" style="font-size: 2rem;"><s style="font-size: 1.5rem;"><?= $row['original_price'];?></s><b>&nbsp; &#8377;<?= $row['offer_price'];?></b><br><b class="text-success p-0 m-0" style="font-size: 0.9rem;"><?= 100-round(100 * ($row['offer_price']/$row['original_price']));?>% Off</b></p>
                    <h5 class="fw-bold text-start  mt-2 text-bold">Selct Colors</h5>
                    <?php
                    foreach ($colors as $color){
                        ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input " type="radio" name="color" value="<?= $color; ?>" id="flexRadioDefault1" required>
                            <label class="form-check-label" for="flexRadioDefault1" ><?= $color; ?></label>
                        </div>
                        <?php
                    }
                    ?>
                    <h5 class="fw-bold text-start mt-3 text-bold">Select Size</h5>
                    <?php
                    foreach ($sizes as $size){
                        ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input " type="radio" name="size" value="<?= $size; ?>" id="flexRadioDefault1" required>
                            <label class="form-check-label" for="flexRadioDefault1" ><?= $size; ?></label>
                        </div>
                        <?php
                    }
                    ?>
                    
                    <h6 class="fw-bold text-start mt-3 text-bold">More Details</h6>
                    <p><?= $row['description'];?></p>

                    <div class="d-flex me-2  justify-content-start ">
                        <input type="hidden" name="product_id" value="<?= $row['product_id'];?>">
                        <button type="submit" name="add_to_cart" class="btn me-2 btn-outline-warning">Add to Cart</button>
                        <input type="hidden" name="product_id" value="<?= $row['product_id'];?>">
                        <button type="submit" name="buynow" class="btn btn-warning">Buy Now</button>
                        
                    </div>
                </div>
            
            </div>
        </form>
    </div>
    <?php
}
?>

<div class="container">
    
<h2 class="text-muted text-center">More from Same Category</h2>
<hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
<div class="row border-bottom justify-content-around">
      <?php
      $select_product = $connection->prepare("SELECT * FROM `products` WHERE STOCK > 0 AND category = ? LIMIT 5");
      $select_product->execute([$row['category']]);
      if($select_product->rowCount() <= 0){
          echo 'No Products available to update';
      }
      else{
          while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            $colors = explode(',', $row['colors']);
            $name = mb_strimwidth(ucwords($row['category']).' '. $row['name'].' '.$colors[0], 0, 16,'');
            ?>
            <div class="card border-2 mt-1 mb-2" style="width: 11.9rem; ">
                <div class="p-2">
                  <a href="viewProduct.php?productId=<?= $row['product_id'] ;?>" class="text-center pb-0 mb-0">
                    <img class="card-img" style="object-fit: cover;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                    <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 0.9rem;"><?= $name ;?>...</p>
                    <p class="text-bold text-start text-bold p-0 m-0" style="font-size: 1rem;"><s style="font-size: 0.9rem;"><?= $row['original_price'];?></s><b>&nbsp; &#8377;<?= $row['offer_price'];?></b><br><b class="text-success p-0 m-0" style="font-size: 0.9rem;"><?= 100-round(100 * ($row['offer_price']/$row['original_price']));?>% Off</b></p>
                  </a>
                </div>
              </div>       
            <?php
          }
        }
        ?>

      </div>
    </div>
</div>


<?php include 'footer.php'; ?>

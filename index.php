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
      $size = explode(',' , $selected_product['size']);

      $check_cart = $connection->prepare("SELECT * FROM `cart` WHERE product_id = ? AND user_id = ?");
      $check_cart->execute([$product_id, $user_id]);
      $cart_items = $check_cart->fetch(PDO::FETCH_ASSOC);

      if($check_cart->rowCount() > 0){
        $update_cart = $connection->prepare("UPDATE `cart` SET quantity = ? ");
        $update_cart->execute([$cart_items['quantity']+1]);
      }
      else{
        $insert_cart = $connection->prepare("INSERT INTO `cart`(product_id, user_id, quantity, color, size) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->execute([$product_id, $user_id, $quantity, $colors[0], $size[0]]);
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
?>

<div id="carouselExampleIndicators" class="carousel slide mt-2 shadow">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>

  <div class="carousel-inner">

    <div class="carousel-item active">
      <img src="assets/images/banner1.jpg" class="d-block w-100" alt="...">
    </div>

    <div class="carousel-item">
      <img src="assets/images/banner2.jpg" class="d-block w-100" alt="...">
    </div>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
  <i class="fa-solid fa-angle-left"  aria-hidden="true"></i>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <i class="fa-solid fa-angle-right"  aria-hidden="true"></i>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="container rounded mt-3 mb-3 bg-#ced4da p-3">
<h2 class="text-muted text-center">Shop by Category</h2>
<hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
  <div class="row justify-content-around">

    <div class="mt-2" style="width: 12rem;">
      <a href="product.php?category=men" class="text-center pb-0 mb-0">
        <img class="im-fluid" style="object-fit: contain;"  width="180px" height="200px" src="assets/images/jeans dress.jpg">
        <h3>MENS</h3>
      </a>
    </div>

    <div class="mt-2" style="width: 12rem;">
      <a href="product.php?category=women" class="text-center pb-0 mb-0">
        <img class="im-fluid" style="object-fit: contain;"  width="180px" height="200px" src="assets/images/kurti.jpg">
        <h3>WOMENS</h3>
      </a>
    </div>

    <div class="mt-2" style="width: 12rem;">
      <a href="product.php?category=kids" class="text-center pb-0 mb-0">
        <img class="im-fluid" style="object-fit: contain;"  width="180px" height="200px"  src="assets/images/cat-3.webp">
        <h3>KIDS</h3>
      </a>
    </div>
  </div>
</div>

<div class="container-fluid rounded mt-4">
  <h2 class="text-muted text-center pt-4">Latest Products Back to Stock</h2>
  <hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
  <div class="d-flex align-items-center overflow-scroll " style="">
    <div class="d-flex pb-2 justify-content-evenly mx-auto">
    <?php
    $select_product = $connection->prepare("SELECT * FROM `products` WHERE STOCK > 0 ORDER BY product_id DESC LIMIT 9");
    $select_product->execute();
    if($select_product->rowCount() <= 0){
        echo 'No Products available to update';
    }
    else{
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
          $colors = explode(',', $row['colors']);
          $name = mb_strimwidth(ucwords($row['category']).' '. $row['name'].' '.$colors[0], 0, 16,'');
            ?>
            <div class="card bg-white me-2 mt-1" style="width: 10rem;">
              <div class="p-2">
                <a href="viewProduct.php?productId=<?= $row['product_id'] ;?>" class="text-center pb-0 mb-0">
                  <img class="card-img" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                  <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 0.9rem;"><?= $name ;?>...</p>
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
</div>



<div class="container-fluid rounded mt-3 mb-3 bg-gray p-3">
<h2 class="text-muted text-center">Featured Collection</h2>
<hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
  <div class="row border-bottom justify-content-around">

  <?php
      $select_product = $connection->prepare("SELECT * FROM `products` WHERE STOCK > 0 ORDER BY rand() LIMIT 6");
      $select_product->execute();
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
                    <img class="card-img" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                    <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 0.9rem;"><?= $name ;?>...</p>
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


<div id="carouselExampleControls"class="carousel carousel-dark bg-white mt-2 mb-3 p-3 slide" data-bs-ride="carousel">

<div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner" id="men">

    <div class="carousel-item active mt-3 mb-3">
    <h2 class="text-muted text-center">Men Shopping</h2>
    <hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
      <div class="row border-bottom justify-content-around">
      <?php
      $select_product = $connection->prepare("SELECT * FROM `products` WHERE STOCK > 0 AND category = 'men' LIMIT 4");
      $select_product->execute();
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
                    <img class="card-img" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                    <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 0.9rem;"><?= $name ;?>...</p>
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

    <div class="carousel-item mt-3 mb-3" id="Women">
    <h2 class="text-muted text-center">Women Shopping</h2>
    <hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
      <div class="row border-bottom justify-content-around">

      <?php
      $select_product = $connection->prepare("SELECT * FROM `products` WHERE STOCK > 0 AND category = 'women' LIMIT 4");
      $select_product->execute();
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
                    <img class="card-img" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                    <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 0.9rem;"><?= $name ;?>...</p>
                    <p class="text-bold text-start text-bold p-0 m-0" style="font-size: 1rem;"><s style="font-size: 0.9rem;"><?= $row['original_price'];?></s><b>&nbsp; &#8377;<?= $row['offer_price'];?></b><br><b class="text-success p-0 m-0" style="font-size: 0.9rem;"><?= 100-round(100 * ($row['offer_price']/$row['original_price']));?>% Off</b></p>
                  </a>
                  <form method="post">
                    <input type="hidden" value="<?= $row['product_id']; ?>" name="product_id">
                    <input type="submit" name="add_to_cart" class="btn btn-sm btn-gray m-0" value="Add to Cart">
                  </form>
                </div>
              </div>       
            <?php
          }
        }
        ?>


      </div>
    </div>

    <div class="carousel-item mt-3 mb-3" id="Kids">
    <h2 class="text-muted text-center">Kids Shopping</h2>
    <hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
      <div class="row border-bottom justify-content-around">
      <?php
      $select_product = $connection->prepare("SELECT * FROM `products` WHERE STOCK > 0 AND category = 'kids' LIMIT 4");
      $select_product->execute();
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
                    <img class="card-img" style="object-fit: contain;" width="100px" height="100px" src="admin/Products/<?= $row['photo'];?>">
                    <p class="text-bold text-start p-1 m-0 text-bold" style="font-size: 0.9rem;"><?= $name ;?>...</p>
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

  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="visually-hidden">Next</span>
  </button>
</div>



<div class="container rounded mt-3 mb-3 bg-white p-3">
<h2 class="text-muted text-center">Feedbacks</h2>
<hr class="mt-2 mb-2"  style="width:30%; margin:auto;">
  <div class="row justify-content-around">
    <?php
    $select_product = $connection->prepare("SELECT * FROM `feedback`  LIMIT 6");
    $select_product->execute();
    if($select_product->rowCount() <= 0){
        echo 'No Products available to update';
    }
    else{
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
        
        ?>
        <div class="mt-2" style="width: 12rem;">
          <h4><?= $row['name'];?></h4>
          <p><?= $row['feedback'];?></p>
    </div>
        <?php
        }
      }
            ?>

  </div>
</div>

<?php include 'footer.php'; ?>
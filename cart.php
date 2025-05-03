<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['user'])){
    header('Location:error.php');
}
?>


<?php
if(isset($_POST['update_plus'])){
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'] +1;
    $update_cart = $connection->prepare("UPDATE `cart` SET quantity = ? WHERE cart_id = ?");
    $update_cart->execute([$quantity, $cart_id]);
}

if(isset($_POST['update_minus'])){
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'] - 1;
    if($quantity < 1){
        $quantity = 1;
    }
    $update_cart = $connection->prepare("UPDATE `cart` SET quantity = ? WHERE cart_id = ?");
    $update_cart->execute([$quantity, $cart_id]);
}

if(isset($_POST['delete'])){
    $cart_id = $_POST['cart_id'];
    $update_cart = $connection->prepare("DELETE FROM `cart` WHERE cart_id = ?");
    $update_cart->execute([$cart_id]);
}

$select_from_cart = $connection->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_from_cart->execute([$_SESSION['user']]);
?>
<div class="container p-3 mt-2 mb-2 bg-white">
<h4 class="mx-auto">Cart Items : (<?= $select_from_cart->rowCount() ?>)</h4>
    <div class="row">
        <div class="col-md-7">
    <?php
    if($select_from_cart->rowCount() < 0){
        echo '<h1 class="text-center fw-bold">Cart is empty</h1>';
    }
    else{
        $sub_total_original = 0;
        $sub_total_offer = 0;
        while($from_cart = $select_from_cart->fetch(PDO::FETCH_ASSOC)){
            $from_product = $connection->prepare("SELECT * FROM `products` WHERE product_id = ?");
            $from_product->execute([$from_cart['product_id']]);
            $from_product_table = $from_product->fetch(PDO::FETCH_ASSOC);
            $name = ucwords($from_product_table['category']).' '. $from_product_table['name']. ' '.$from_cart['color'];
            ?>
            <div class=" p-0 mt-2 mb-2">
                <div class="p-2 align-items-center p-0 d-flex justify-content-evenly ">
                    <div class="align-items-center">
                        <img class="mx-auto" src="admin/Products/<?= $from_product_table['photo']; ?>" style="width:100px; height:70px;object-fit: contain;">
                    </div>
                    <div class="text-start">
                        <p class="text-bold text-start p-0 m-0 text-bold" style="font-size: 1rem;"><?= $name ;?></p>
                        <p class="text-bold text-start p-0 m-0 text-bold" style="font-size: 0.9rem;">Color : <?= $from_cart['color'];?></p>
                        <p class="text-bold text-start p-0 m-0 text-bold" style="font-size: 0.9rem;">Size : <?= $from_cart['size'];?></p>
                        <form class="d-flex p-0 m-0" method="post">
                            <input type="hidden" name="cart_id" value="<?= $from_cart['cart_id']; ?>"> 
                            <button type="submit" class="btn btn-sm btn-light" name="update_minus"><i class="fa fa-minus"></i></button>
                            <input type="text" name="quantity" class="form-control form-control-sm bg-white rounded" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" style="width:50px" value="<?= $from_cart['quantity']; ?>">
                            <button type="submit" class="btn btn-sm btn-light" name="update_plus"><i class="fa fa-plus"></i></button>
                        </form>
                        <p class="text-bold text-start text-bold p-0 m-0" style="font-size: 1rem;"><s style="font-size: 0.9rem;"><?= $total_original = ($from_product_table['original_price'] * $from_cart['quantity']) ;?></s><b>&nbsp; &#8377;<?= $total_offer = ($from_product_table['offer_price'] * $from_cart['quantity']);?></b> <b class="text-success p-0 m-0" style="font-size: 0.9rem;"><?= 100-round(100 * ($from_product_table['offer_price']/$from_product_table['original_price']));?>% Off</b></p>
                    </div>
                    <div class="text-start">
                        <form class="d-flex" method="post">
                            <input type="hidden" name="cart_id" value="<?= $from_cart['cart_id']; ?>"> 
                            <button type="submit" class="btn btn-sm btn-light" name="delete"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            $sub_total_original = $sub_total_original + $total_original ;
            $sub_total_offer = $sub_total_offer + $total_offer;
        }
        $select_date = date("l jS F");
        $date = date_create($select_date);
        date_add($date,date_interval_create_from_date_string("7 days"));
        $delivery_date = date_format($date,"l jS F");
        ?>
        </div>
        <div class="col-md-3 p-3 mt-2 bg-light rounded align-items-center text-start">
            <div class="col-md-14 rounded border p-3 bg-gray mb-4" style="">
                <h4 class="">Estimated Delivery Date</h4>
                <label class="labels me-5">Standard Delivery <br><b><?= $delivery_date ;?></b></label>
            </div>
            <h5 class="fw-bold">Total Summary</h5>
            <div class="row mt-4">
                <div class="col-5">
                    <p class="mb-1">Subtotal</p>
                    <p class="mb-1">Offer</p>
                    <p class="mb-1">Shipping</p>
                    <p class="fw-bold">Total</p>
                </div>
                <div class="col-1 text-right">
                    <p class="mb-1 text-center ">:</p>
                    <p class="mb-1 text-center">:</p>
                    <p class="fw-bold text-center">:</p>
                </div>
                <div class="col-4 text-right">
                    <p class="mb-1 text-end "><?= $sub_total_original;?>.00</p>
                    <p class="mb-1 text-end "><s>75.00</s></p>
                    <p class="mb-1 text-end"><?= $sub_total_original - $sub_total_offer;?>.00</p>
                    <p class="fw-bold text-end"><?= $sub_total_offer;?>.00</p>
                </div>
            </div>
            <a href="checkout.php" class="btn btn-success block mt-2 mb-2">Proceed to Checkout <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
        <?php
    }
    ?>
    </div>
<?php include 'footer.php'; ?>
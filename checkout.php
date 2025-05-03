<?php include 'header.php'; ?>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo "<script type='text/javascript'>alert('$message');</script>";
      }
   }
?>
<?php
include 'conn.php';
if(!isset($_SESSION['user'])){
    header('location:error.php');
}
else{
    $user_id = $_SESSION['user'];
}
?>
<?php
$select_address = $connection->prepare("SELECT * FROM `users`  WHERE unique_id = ?");
$select_address->execute([$_SESSION['user']]);
$row = $select_address->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['save'])){
    $address1 = $_POST['address_line_1'];
    $address2 = $_POST['address_line_2'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    $insert_address = $connection->prepare("INSERT INTO `addresses` (user_id, Address_line_1, Address_line_2, Area, City, Pincode, State, Country) VALUE (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_address->execute([$user_id, $address1, $address2, $area, $city, $pincode, $state, $country]);
    $message[] = 'Address saved';
}

if(isset($_POST['place_order'])){
    $select_product = $connection->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_product->execute([$user_id]);
    if($select_product->rowCount() > 0){
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            $product_details = $connection->prepare("SELECT * FROM `products` WHERE product_id = ?");
            $product_details->execute([$row['product_id']]);
            $product_data = $product_details->fetch(PDO::FETCH_ASSOC);

            $product_id = $product_data['product_id'];
            $product_name = $product_data['name'];
            $price = $product_data['offer_price'] * $row['quantity'];
            $image = $product_data['photo'];

            $quantity = $row['quantity'];
            $color = $row['color'];
            $size = $row['size'];

            $address1 = $_POST['address_line_1'];
            $address2 = $_POST['address_line_2'];
            $area = $_POST['area'];
            $city = $_POST['city'];
            $pincode = $_POST['pincode'];
            $state = $_POST['state'];
            $country = $_POST['country'];

            $insert_order = $connection->prepare("INSERT INTO `orders` (Product_id, Image_01, user_id, Product_Name, Quantity, color, size, Total_Price, Address_line_1, Address_line_2, Area, City, Pincode, State, Country) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([$product_id, $image, $user_id, $product_name, $quantity, $color, $size, $price, $address1, $address2, $area, $city, $pincode, $state, $country]);
            if($insert_order){
                $delete_order = $connection->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $delete_order->execute([$user_id]);
                header('Location:thankyou.php');
            }
        }
    }
}
?>
<div class="container">
    <div class=" text-center mt-4 ">
        <h2>Shipping Address</h2> 
    </div>
    <div class="row">
      <div class="col-lg-5 mx-auto">
        <div class="card mt-2 mx-auto p-4">
            <div class="card-body">
                <div class = "container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Address Line 1</label>
                                        <input type="text" name="address_line_1" value="" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="address_line_2" value="" class="form-control p-1 shadow-sm bg-white rounded">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Area</label>
                                        <input type="text" name="area" value="" class="form-control p-1 shadow-sm bg-white rounded" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>City</label>
                                        <input type="text" name="city" value="" class="form-control p-1 shadow-sm bg-white rounded" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Pincode</label>
                                        <input type="text" name="pincode" value="" class="form-control p-1 shadow-sm bg-white rounded" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>State</label>
                                        <select name="state" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                            <option selected>KARNATKA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Country</label>
                                        <select name="country" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                            <option selected>INDIA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="post">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Payment Type</label>
                            <select name="payment" class="form-select form-select-sm p-1 shadow-sm bg-white rounded" required>
                                <option selected>--Select--</option>
                                            <option>Cash on Delivery</option>
                                            <option>UPI</option>
                                            <option>G-Pay</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12"> 
                                    <input type="submit" name="place_order" class="btn btn-warning block" value="Place Order" >
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
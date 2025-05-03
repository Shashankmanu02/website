<?php include 'header.php'; ?>
<?php include 'conn.php'; ?>
<?php
if(isset($_SESSION['user'])){
    $check_user = $connection->prepare("SELECT * FROM `users` WHERE unique_id = ?");
    $check_user->execute([$_SESSION['user']]);
    $logged_in_data = $check_user->fetch(PDO::FETCH_ASSOC);
    $user_id = $logged_in_data['unique_id'];
    if($logged_in_data['role'] == 'Admin'){
        header('Location:index.php');
    }
}
else{
    header('Location:index.php');
}

if(isset($_POST['delete'])){
  $order_id = $_POST['order_id'];
  $delete_product = $connection->prepare("DELETE FROM `orders` WHERE Order_id = ?");
  $delete_product->execute([$order_id]);
  $message[] = 'Order Deleted Successfully';
}
?>
<div class="container-xl mt-5 overflow-auto">
    <h4>Orders : </h4>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Order ID</th>
      <th scope="col">Item</th>
      <th scope="col">Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Amount</th>
      <th scope="col" width='15%'>Delivery Address</th>
      <th scope="col">Order Status</th>
      <th scope="col">Payment Status</th>
      <th scope="col">Delivery Date</th>
      <th scope="col">Cancel Order</th>
    </tr>
  </thead>
  <tbody>
  <?php
$select_product = $connection->prepare("SELECT * FROM `orders` WHERE user_id = ?");
$select_product->execute([$user_id]);
    if($select_product->rowCount() > 0){
        while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            $select_date = $row['order_time'];
            $date=date_create($select_date);
            date_add($date,date_interval_create_from_date_string("7 days"));
            $delivery_date = date_format($date,"l jS F");
    ?>
    <tr>
    <form method="post">
      <input type="hidden" name="order_id" value="<?= $row['order_id'];?>">
      <td><?= $row['order_id'];?></td>
      <td><img class="card-img-top" src="admin/Products/<?= $row['Image_01'];?>" width="100px" height="60px" alt="Product Image"></td>
      <td><?= $row['Product_Name'];?></td>
      <td><?= $row['Quantity'];?></td>
      <td><?= $row['Total_Price'];?></td>
      <td><p><?= $row['Address_line_1'];?>, <?= $row['Address_line_2'];?>, <?= $row['Area'];?>, <?= $row['City'];?>-<?= $row['Pincode'];?></td>
      <td><?= $row['Order_Status'];?></td>
      <td><?= $row['Payment_Status'];?></td>
      <td><?= $delivery_date;?></td>
      <td>
        <?php
        if($row['Order_Status'] == 'Pending'){
          ?>
          <input type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');" value="Cancel">
        <?php
        }
        else{
          ?>
          <input type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');" value="Cancel" disabled>
        <?php
        }
        ?>
        </td>
    </form>
    </tr>
    <?php
   }
}
?>
  </tbody>
</table>
</div>

<?php include 'footer.php'; ?>
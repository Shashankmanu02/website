<?php include 'header.php'; ?>
<?php include 'conn.php'; ?>
<?php
if(isset($_SESSION['user'])){
    $check_user = $connection->prepare("SELECT * FROM `users` WHERE unique_id = ?");
    $check_user->execute([$_SESSION['user']]);
    $logged_in_data = $check_user->fetch(PDO::FETCH_ASSOC);
    if($logged_in_data['role'] == 'Admin'){
        header('Location:index.php');
    }
}
else{
    header('Location:index.php');
}
?>
<?php
$select_user = $connection->prepare("SELECT * FROM `users` WHERE unique_id = ?");
$select_user->execute([$logged_in_data['unique_id']]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);
$unique_id = $logged_in_data['unique_id'];

if(isset($_POST['update_name'])){
    $name = $_POST['fullname'];

    $update_qty = $connection->prepare("UPDATE `users` SET name = ? WHERE unique_id = ?");
    $update_qty->execute([$name, $unique_id]);
    header("Refresh:0");
}

if(isset($_POST['update_email'])){
    $email = $_POST['email'];

    $update_qty = $connection->prepare("UPDATE `users` SET email = ? WHERE unique_id = ?");
    $update_qty->execute([$email, $unique_id]);
    header("Refresh:0");
}
if(isset($_POST['update_phone'])){
    $phone_no = $_POST['phone_no'];

    $update_qty = $connection->prepare("UPDATE `users` SET phone = ? WHERE unique_id = ?");
    $update_qty->execute([$phone_no, $unique_id]);
    header("Refresh:0");
}
?>

<div class="container">
        <div class=" text-center mt-4 ">
            <h2>Update Profile</h2> 
        </div>
    <div class="row">
      <div class="col-lg-5 mx-auto">
        <div class="card mt-2 mx-auto p-4">
            <div class="card-body">
            <div class = "container">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="controls">
                <?php
                    if(isset($message)){
                        foreach($message as $message){
                            echo '
                            <div class="alert shadow" style="background-color: black; padding: 10px;color:white;">
                                <span class="closebtn" onClick="this.parentElement.remove()">&times;</span>
                                '.$message.'
                                </div>';
                        }
                    }
                    ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>User ID</label>
                            <input type="text" name="user_id" value="<?= $row['unique_id']; ?>" class="form-control p-1 shadow-sm bg-white rounded shadow-sm bg-white rounded" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="fullname" value="<?= $row['name'] ;?>" class="form-control p-1 shadow-sm bg-white rounded" required>
                            <button type="submit" name="update_name" class="btn block p-1" value="Update Email"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= $row['email'] ;?>" class="form-control p-1 shadow-sm bg-white rounded" required>
                            <button type="submit" name="update_email" class="btn block p-1" value="Update Email"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Phone No.</label>
                            <input type="tel" name="phone_no" value="<?= $row['phone'] ;?>" class="form-control p-1 shadow-sm bg-white rounded" required>
                            <button type="submit" name="update_phone" class="btn block p-1" value="Update Email"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group d-flex mb-3">
                            <a href="changepassword.php?Customer_id=<?= $row['unique_id'] ;?>" class="link" value="Update Email">Click here to Change Password</a>
                        </div>
                    </div>
                </div>
                    <div class="col-md-12"> 
                        <input type="submit" name="update" class="btn btn-dark block" value="Update Profile" >
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>


<?php include 'footer.php'; ?>
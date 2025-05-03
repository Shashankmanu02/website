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
?>
<div class="container rounded border mt-5  mx-auto">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="../sources/profile.jpg"><span class="font-weight-bold" style="text-transform:capitalize">hey, <?= $row['name'] ;?></span><span class="text-black-50" style="font-style:italic;">Fashion Cart</span></div>
        </div>
        <div class="col-md-5 border-right align-center">
            <div class="card">
                <div class="card-header">
                    <h4>My Profile</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-12 mb-2"><label class="labels me-5">Name&emsp; &emsp; &emsp;</label>: <b style="text-transform: capitalize;"><?= $row['name'] ;?></b></div>
                        <div class="col-md-12 mb-2"><label class="labels me-5">Mobile No&emsp;&ensp;</label>: <b style="text-transform: capitalize;"><?= $row['phone'] ;?></b></div>
                        <div class="col-md-12 mb-2"><label class="labels me-5">Email&emsp; &emsp; &ensp; &ensp;</label>: <b style="text-transform: capitalize;"><?= $row['email'] ;?></b></div>
                        <div class="mt-2"><a class="btn btn-dark" href="update.php">Update Profile</a></div>
                    </div>
                </div>
            </div>
        </div>    
    </div>


    <?php include 'footer.php'; ?>
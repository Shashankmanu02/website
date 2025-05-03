<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php
if(isset($_SESSION['user'])){
    header('location:index.php');
}
if(isset($_POST['login'])){
    $email = ucwords($_POST['email']);
    $password = $_POST['password'];
    $role = 'User';

    $check_user = $connection->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? AND role = ?");
    $check_user->execute([$email, $password, $role]);
    if($check_user->rowCount() > 0 ){
        $logged_in_data = $check_user->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $logged_in_data['unique_id'];
        header('Location:dashboard.php');
    }
    else{
        $message = 'Invalid e-Mail or Password entered';
    }
}
?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Message from Fashion Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= $message; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
<?php
?>

<div class="mt-3 mb-3 col-md-3 p-4 p-lg-2 mx-auto">
    <div class="container-sm bg-white rounded shadow-sm border mx-auto ">
                
        <h3 class="p-3 text-center m-0"><a href="index.php">User Login</a></h3>
        <form action="" id="reg_form" method="post" class="p-3" style="font-size: 0.9rem;">

        <?php
        if(isset($message)){
            ?>
            <script>
            var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
            myModal.show();
            </script>
            <?php
            }
        
        ?>

            <div class="row">
                <div class="col-md mb-3">
                    <label class="form-label text-black mb-1">Email</label>
                    <input type="text" id="email" value="" class="form-control form-control-sm" name="email" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md mb-3">
                    <label class="form-label text-black mb-1">Password</label>
                    <input type="password" id="password" class="form-control form-control-sm" name="password" required>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <input type="submit" class="btn mb-3 bg-warning shadow  col-sm-12 text-black" value="Login" name="login">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p class="p-1 m-0">Don't have Account? <a href="userRegistration.php" class="text-primary">Create Now</a></p>
                </div>
            </div>

        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
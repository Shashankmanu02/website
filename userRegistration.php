<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php
if(isset($_SESSION['user'])){
    header('location:index.php');
}
if(isset($_POST['register'])){
    $name = ucwords($_POST['name']);
    $email = ucwords($_POST['email']);
    $mobile = $_POST['mobile_no'];
    $password = $_POST['password'];
    $role = 'User';

    $check_user = $connection->prepare("SELECT * FROM `users` WHERE email = ?");
    $check_user->execute([$email]);
    if($check_user->rowCount() > 0 ){
        $message = 'User with this email or phone already exists';
    }
    else{
        $insert_user = $connection->prepare("INSERT INTO `users` (name, email, phone, password, role) VALUES (?, ?,  ?, ?, ?)");
        if($insert_user->execute([$name, $email, $mobile, $password, $role])){
            $message = 'Registered successfully';
        }
    }
}
?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Message Fashion Cart</h5>
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

<div class="mt-3 mb-3 col-md-4 p-4 p-lg-2 mx-auto">
    <div class="container-sm bg-white rounded shadow-sm border mx-auto ">
                
        <h3 class="p-3 text-center m-0"><a href="index.php">User Registration</a></h3>
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
                    <label class="form-label text-black mb-1">Name</label>
                    <input type="text" id="name" value="" class="form-control form-control-sm" name="name" required>
                </div>
            </div>


            <div class="row">
                <div class="col-md mb-3">
                    <label class="form-label text-black mb-1">Email</label>
                    <input type="text" id="email" value="" class="form-control form-control-sm" name="email" required>
                </div>
                <div class="col-md mb-3">
                    <label class="form-label text-black mb-1">Mobile No.</label>
                    <input type="text" id="phone" value="" class="form-control form-control-sm" name="mobile_no" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md mb-3">
                    <label class="form-label text-black mb-1">Password</label>
                    <input type="password" id="password" onchange="onChange()" class="form-control form-control-sm" name="password" required>
                </div>
                <div class="col-md mb-3">
                    <label class="form-label text-black mb-1">Confirm Password</label>
                    <input type="password" id="confirm_password" onchange="onChange()" class="form-control form-control-sm" name="confirm_password" required>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <input type="submit" class="btn mb-3 bg-warning shadow  col-sm-12 text-black" value="Register" name="register">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p class="p-1 m-0">Already have and Account? <a href="userLogin.php" class="text-primary">Login Now</a></p>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    function onChange() {
  const password = document.querySelector('input[name=password]');
  const confirm = document.querySelector('input[name=confirm_password]');
    
  if (confirm.value === password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}
</script>

<?php include 'footer.php'; ?>
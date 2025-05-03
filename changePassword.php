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
if($select_user->rowCount() > 0){
 $row = $select_user->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['change_password'])){
 $current_password = $_POST['current_password'];
 $password = $_POST['password'];

 if($current_password == $row['password']){
     $update_password = $connection->prepare("UPDATE `users` SET password = ? WHERE unique_id = ?");
     $update_password->execute([$password, $logged_in_data['unique_id']]);
     $message[] = 'Password Updated Successfully';
 }
 else{
     $message[] = 'Current Password is wrong';
 }
}
?>
<div class="card col-sm-4 mt-2 mx-auto shadow p-3">
<div class="container-sm ">
<form method="post">
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
    <h4 style="padding:5px; text-align:left; border-bottom:2px solid black; ">Change Password</h4>
    <div class="mb-2">
        <label for="InputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control p-1 shadow-sm bg-white rounded" id="InputEmail1" value="<?= $row['email'];?>" disabled>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Current Password</label>
        <input type="password" name="current_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword1" required>
    </div>
    <div class="mb-2">
        <label for="InputPassword1" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control p-1 shadow-sm bg-white rounded" onchange="onChange()" id="InputPassword2" required>
    </div>
    <button type="submit" name="change_password" class="btn btn-dark">Change Password</button>
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
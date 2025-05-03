<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['user'])){
    header('Location:error.php');
}
else{
    $check_user = $connection->prepare("SELECT * FROM `users` WHERE unique_id = ?");
    $check_user->execute([$_SESSION['user']]);
    $logged_in_data = $check_user->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['add'])){
    $insert_feedback = $connection->prepare("INSERT INTO `feedback`(user_id, name, feedback) VALUES (?, ?, ?)");
    if($insert_feedback->execute([$_POST['unique_id'], $_POST['name'], $_POST['feedback']])){
        echo 'Feedback Inserted';
    }
}
?>

<div class="container">
    <form action="" method="post">
        
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>User Name</label>
                            <input type="text" name="name" value="<?= $logged_in_data['name'];?>" >                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Feedback</label>
                            <textarea name="feedback" class="form-control form-control p-1 shadow-sm bg-white rounded" required rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="<?= $logged_in_data['unique_id'];?>" name="unique_id">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Feedback</label>
                            <input type="submit" name="add" value="Add Feedback">
                        </div>
                    </div>
                </div>
    </form>
</div>
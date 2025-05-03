
<?php
ob_start();
session_start();
?>
<?php include 'conn.php'; ?>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
        <script src="assets/css/bootstrap.js"></script>

        <style>
            :root{
                --form-background: #F5F5F6;
            }
            body{
                background-color:#d3d4d5;
                margin: 0 auto;
            }
            a{
                color: black;
                text-decoration: none;
            }
            .nav-link{
                color: black;
            }
            .nav-link:hover{
                color: var(--main-color);
            }
            .form-control:focus{
            box-shadow: none;
            border-color: #ffc107;
            }
            ::-webkit-scrollbar {
            width: 0px;
            }
        </style>
    </head>
    <body>

<?php
if(isset($_SESSION['user'])){
    $check_user = $connection->prepare("SELECT * FROM `users` WHERE unique_id = ?");
    $check_user->execute([$_SESSION['user']]);
    $logged_in_data = $check_user->fetch(PDO::FETCH_ASSOC);
    if($logged_in_data['role'] == 'Admin'){
        if(basename($_SERVER['PHP_SELF'])  == 'registration.php' || basename($_SERVER['PHP_SELF'])  == 'login.php'){
        }
        else{
        ?>
<div class="bg-gray">
    <div class="container justify-content-between navbar navbar-expand-lg bg-gray">

        <div class="d-flex  align-items-center">
            <a class="navbar-toggler me-1" style="border:0px; outline:none;"  type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <i class="fa fa-bars-staggered "></i>
            </a>
            <div class="navbar-brand" href="index.php">
                <h4 class="p-0 m-0 "><a href="index.php">Fashion</a></h4>
                <h6 class="p-0 text-end m-0" style="font-style:italic;">cart</h6>
            </div>
            <h6>Admin</h6>
        </div>

        <div class="d-lg-none">
            <a class="me-4" onclick="showSearch()" type="submit"><i class="fa fa-search "></i></a>
            <a class="me-4" href="admin/dashboard.php"><i class="fa fa-user-circle"></i></a>
            <a class="me-4" href="admin/logout.php"><i class="fa fa-sign-out"></i></a>
        </div>

        <div class="collapse ms-2 navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Products <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="__blank" href="admin/addNew.php?action=addProduct">Add Products</a></li>
                        <li><a class="dropdown-item" target="__blank" href="admin/addNew.php?action=viewProducts">Edit Products</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addNew.php?action=category">Add new Category</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Users <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="__blank" href="admin/list.php">View users List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Orders & Payments <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="__blank" href="admin/orders.php">View orders and Status</a></li>
                        <li><a class="dropdown-item" target="__blank" href="admin/payments.php">View Payments</a></li>
                    </ul>
                </li>
           </ul>
        </div>


        <div class="pc-screen">
            <a class="me-4" onclick="showSearch()" type="submit"><i class="fa fa-search "></i></a>
            <a class="me-4" href="admin/dashboard.php"><i class="fa fa-user-circle"></i></a>
            <a class="me-4" href="admin/logout.php"><i class="fa fa-sign-out"></i></a>
        </div>

    </div>
</div>
        <?php
    }
}
    else{
        ?>
        <div class="bg-gray">
    <div class="container justify-content-between navbar navbar-expand-lg  bg-gray">

        <div class="d-flex  align-items-center">
            <a class="navbar-toggler me-1" style="border:0px; outline:none;"  type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <i class="fa fa-bars-staggered "></i>
            </a>
            <div class="navbar-brand" href="index.php">
                <h4 class="p-0 m-0 "><a href="index.php">Fashion</a></h4>
                <h6 class="p-0 text-end m-0" style="font-style:italic;">Cart</h6>
            </div>
        </div>

        <div class="d-lg-none">
            <a class="me-4" onclick="showSearch()" type="submit"><i class="fa fa-search "></i></a>
            <a class="me-4" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
            <a class="me-4" href="logout.php"><i class="fa fa-sign-out"></i></a>
        </div>

        <div class="collapse ms-2 navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="product.php?category=men">Men</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="product.php?category=women">Women</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="product.php?category=kids">Kids</a>
                </li>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="feedback.php">Feedback</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Orders <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="__blank" href="orders.php">View Orders</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Account <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="__blank" href="dashboard.php">Dashboard</a></li>
                        <li><a class="dropdown-item" target="__blank" href="changepassword.php?Customer_id=<?= $logged_in_data['unique_id'] ;?>">Change Password</a></li>
                        <li><a class="dropdown-item" target="__blank" href="mesurment.php">Add-Mesurment</a></li>
                    </ul>
                </li>
           </ul>
        </div>


        <div class="pc-screen">
            <a class="me-4" onclick="showSearch()" type="submit"><i class="fa fa-search "></i></a>
            <a class="me-4" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
            <a class="me-4" href="logout.php"><i class="fa fa-sign-out"></i></a>
        </div>

    </div>
</div>
        <?php       
    }
}
else{
    if(basename($_SERVER['PHP_SELF'])  == 'registration.php' || basename($_SERVER['PHP_SELF'])  == 'login.php'){
    }
    else{
        ?>
<div class="bg-gray">
    <div class="container justify-content-between navbar navbar-expand-lg bg-gray">

        <div class="d-flex  align-items-center">
            <a class="navbar-toggler me-1" style="border:0px; outline:none;"  type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <i class="fa fa-bars-staggered "></i>
            </a>
            <div class="navbar-brand" href="index.php">
                <h4 class="p-0 m-0 "><a href="index.php">Fashion</a></h4>
                <h6 class="p-0 text-end m-0" style="font-style:italic;">Cart</h6>
            </div>
        </div>

        <div class="d-lg-none">
            <a class="me-4" onclick="showSearch()" type="submit"><i class="fa fa-search "></i></a>
            <a class="me-4"><i class="fa fa-user-circle"></i></a>
            <a class="me-4"><i class="fa fa-shopping-cart"></i></a>
        </div>

        <div class="collapse ms-2 navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="product.php?category=men">Men</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="product.php?category=women">Women</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" aria-current="page" href="product.php?category=kids">Kids</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="__blank" href="userLogin.php">Login</a></li>
                        <li><a class="dropdown-item" target="__blank" href="userRegistration.php">Create Account</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="admin/registration.php">Create Account(Admin)</a></li>
                        <li><a class="dropdown-item" href="admin/login.php">Login(Admin)</a></li>
                    </ul>
                </li>
           </ul>
        </div>


        <div class="pc-screen">
            <a class="me-4" onclick="showSearch()" type="submit"><i class="fa fa-search "></i></a>
            <a class="me-4"><i class="fa fa-user-circle"></i></a>
            <a class="me-4"><i class="fa fa-shopping-cart"></i></a>
        </div>

    </div>
</div>
        <?php
    }
}
?>

    <div class="p-2 col-sm-5 align-items-center mx-auto" style="display:none;" id="searchBox">
        <form method="post" action="product.php" class="d-flex d-expand-lg" role="search">
            <input class="form-control form-control-sm bg-white" type="search" name="searching_for" placeholder="Search" aria-label="Search">
            <button class="btn p-2" name="search" type="submit"><i class="fa fa-search "></i></button>
        </form>
    </div>

    <script>
        function showSearch(){
            var searchBox = document.getElementById('searchBox');
            if(searchBox.style.display == 'none'){
                searchBox.style.display = 'block';
            }
            else{
                searchBox.style.display = 'none';
            }
        }
    </script>





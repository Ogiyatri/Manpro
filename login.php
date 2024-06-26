<?php
session_start();

$DATABASE_HOST = "localhost";
$DATABASE_USER = "root";
$DATABASE_PASS = "";
$DATABASE_NAME = "farmasi";


$dsn = "mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME";
$koneksi = new PDO($dsn, $DATABASE_USER, $DATABASE_PASS);
$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['user'];

    // Prepare the query using placeholders
    $stmt = $koneksi->prepare("SELECT password, nama, admin FROM USER WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Use password_verify to check the hashed password
        if (password_verify($_POST['pass'], $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['isAdmin'] = $row['admin'] == 1;
            $_SESSION['isLoggedIn'] = true;

            if ($_SESSION['isAdmin']) {
                $_SESSION['role'] = 'Admin'; // Set the role here
                $message = "<div class='alert alert-info'>Admin login successful</div>";
            } else {
                $_SESSION['role'] = 'User'; // Set the role here
                $message = "<div class='alert alert-info'>User login successful</div>";
            }
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
        } else {
            // Password does not match
            $message = "<div class='alert alert-danger rounded'>Login failed</div>";
            echo "<script>
                setTimeout(function(){
                    document.querySelector('.alert-danger').style.display = 'none';
                }, 3000);
            </script>";
        }
    } else {
        // No user found with that username
        $message = "<div class='alert alert-danger rounded'>Login failed</div>";
        echo "<script>
            setTimeout(function(){
                document.querySelector('.alert-danger').style.display = 'none';
            }, 3000);
        </script>";
    }

    $stmt->closeCursor();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="https://colorlib.com/etc/lf/Login_v1/images/icons/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/main.css">
    <style>
        .login100-form-btn {
            background-color: Red;
        }

        .login100-form-btn:hover {
            background-color: Crimson;
        }
          .container-login100 {
        background: url('./assets/img/red.jpg') center/cover; 
    }
    </style>
    <meta name="robots" content="noindex, follow">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt="">
                    <img src="./assets/img/find_user.jpg" alt="IMG">
                </div>
                <form class="login100-form validate-form" method="POST" action="login.php">
                    <span class="login100-form-title">
                        Login
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="user" placeholder="ID">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="login">Sign In</button>
                    </div>
                    <?php echo $message; ?> 
                    <div class="text-center p-t-12">
                        <span class="txt1">Forgot</span>
                        <a class="txt2" href="">Username / Password?</a>
                    </div>
                    <div class="text-center p-t-136">

                    </div>

                    <script src="./assets/vendor/jquery-3.2.1.min.js"></script>
                    <script src="./assets/vendor/bootstrap.min.js"></script>
                    <script src="./assets/vendor/select2.min.js"></script>
                    <script src="./assets/vendor/tilt.jquery.min.js"></script>
                    <script>
                    $('.js-tilt').tilt({
                        scale: 1.1
                    })
                    </script>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

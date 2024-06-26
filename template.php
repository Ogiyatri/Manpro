<?php
function db_conn(){
    $DATABASE_HOST = "localhost";
    $DATABASE_USER = "root";
    $DATABASE_PASS = "";
    $DATABASE_NAME = "farmasi";

    try {
        $dsn = "mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME";
        $koneksi = new PDO($dsn, $DATABASE_USER, $DATABASE_PASS);
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $koneksi;
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}


function adminChecks(){
    global $koneksi;
    $adminUsername = 'admin';
    $adminPassword = password_hash('admin', PASSWORD_DEFAULT); // Hashing the password
    $adminName = 'Admin';
    $adminRole = '1';

// Check if the admin already exists
    $checkAdmin = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
    $checkAdmin->bind_param("s", $adminUsername);
    $checkAdmin->execute();
    $result = $checkAdmin->get_result();

    if ($result->num_rows == 0) {
        // Admin doesn't exist, so create it
        $insertAdmin = $koneksi->prepare("INSERT INTO user (username, nama, password, admin) VALUES (?, ?, ?, ?)");
        $insertAdmin->bind_param("ssss", $adminUsername,  $adminName, $adminPassword, $adminRole);
        $insertAdmin->execute();
    }

    $checkAdmin->close();
    unset ($_SESSION['username']);
    unset($_SESSION['nama']);
    unset($_SESSION['isAdmin']);
    unset($_SESSION['role']);
    unset($_SESSION['isLoggedIn']);

}
function template_header($userName, $date){
    echo <<<EOF
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Elixir System</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="Stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="assets/img/find_user.jpg" />
    <style>
        .navbar {
            background-color: #FF2400;
            border-color: #333; 
            min-height: 80px; 
            margin-bottom: 0; 
}
        .date-display {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 20px;
            color: #FFF;
          
        }
        .welcome-message {
            position: absolute;
            top: 15px;
            left: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #FFF;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add a subtle text shadow */
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <h3 class="date-display">$date</h3>
                </div>
        </nav>
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/img/find_user.jpg" class="user-image img-responsive" />
                    </li>
                    <li> <a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li> <a href="index.php?page=history"><i class="fas fa-history"></i> History</a></li>
                    <li> <a href="index.php?page=admin"><i class="fas fa-tshirt"></i> Pegawai</a></li>             
                    <li> <a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> logout</a></li>

                </ul>
            </div>
        </nav>
        <div id="page-wrapper">
        <div class="welcome-message">
            <h3>Selamat Datang $userName</h3>
        </div>
EOF;
}

function template_footer(){
    echo <<<EOF
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom.js"></script>
    </body>
EOF;
}

<?php
//This script will handle login
session_start();

// check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("location: profile_user.php");
    exit;
}
require_once "config.php";

$username = $password = $voterid = $aadhar = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password'])) || empty(trim($_POST['voterid'])) || empty(trim($_POST['aadhar']))) {
        $err = "Please enter username + password + voterid + aadhar";
        
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $voterid = trim($_POST['username']);
        $aadhar = trim($_POST['aadhar']);
    }


    if (empty($err)) {
        $sql = "SELECT id, username, password ,voterid ,aadhar FROM users WHERE aadhar = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_aadhar);
        $param_aadhar = $aadhar;


        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $voterid, $aadhar);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // this means the password is corrct. Allow user to login
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["voterid"] = $voterid;
                        $_SESSION["aadhar"] = $aadhar;
                        $_SESSION["loggedin"] = true;

                        //Redirect user to welcome page
                        header("location: profile_user.php");

                    }
                    
                }

            }

        }
        
    }


}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP login system!</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Php Login System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>



            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Please Login Here:</h3>
        <hr>

        <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputUserName">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputUserName"
                    aria-describedby="emailHelp" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword"
                    placeholder="Enter Password" required minlength="5" maxlength="20">
            </div>
            <div class="form-group">
                <label for="exampleInputVoterID">Voter ID</label>
                <input type="text" name="voterid" class="form-control" id="exampleInputVoterID"
                    placeholder="Enter Voter ID" required>
            </div>
            <div class="form-group">
                <label for="exampleInputAadharNo.">Aadhar No.</label>
                <input type="text" name="aadhar" class="form-control" id="exampleInputAadharNo."
                    placeholder="Enter Aadhar No." required minlength="12" maxlength="12">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>
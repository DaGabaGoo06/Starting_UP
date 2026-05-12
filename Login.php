<?php
session_start();
include "config.php";


if (isset($_GET['msg']) && $_GET['msg'] == "registered") {
    echo "<div class='alert alert-success text-center'>Account created successfully. Please login.</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM Users WHERE Email='$email'";
    $result = $conn->query($sql);

    $sql = "SELECT * FROM Users WHERE Email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    
    if (
        $password === $user["Password"] || 
        password_verify($password, $user["Password"]) 
    ) {

        $_SESSION["user_id"] = $user["UserID"];
        $_SESSION["role"] = $user["Role"];
        $_SESSION["name"] = $user["Name"];

        if ($user["Role"] == "admin") {
            header("Location: admin.php");
        } elseif ($user["Role"] == "investitor") {
            header("Location: investor.php");
        } elseif ($user["Role"] == "startup") {
            header("Location: startup.php");
        }

        exit();
    } else {
        $error = "Invalid email or password";
    }
} else {
    $error = "Invalid email or password";
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card p-4 shadow">
        <h3 class="mb-3">Login</h3>

        <?php 
        if(isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form method="POST">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>

        </form>

        
        <div class="text-center mt-3">
            <a href="register.php">Don't have an account? Sign up</a>
        </div>

    </div>

</div>

</body>
</html>
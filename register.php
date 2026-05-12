<?php
include "config.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $last_name = $_POST["last_name"];
    $email = strtolower($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    
    $name = $conn->real_escape_string($name);
    $last_name = $conn->real_escape_string($last_name);
    $email = $conn->real_escape_string($email);
    $role = $conn->real_escape_string($role);

    
    $password = password_hash($password, PASSWORD_DEFAULT);

    
    $check = $conn->query("SELECT * FROM Users WHERE Email='$email'");
    if ($check->num_rows > 0) {
        $error = "Email already exists!";
    } else {

        
        $sql = "INSERT INTO Users (Name, Last_Name, Email, Password, Role)
                VALUES ('$name', '$last_name', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {

            
            $user_id = $conn->insert_id;

            $_SESSION["user_id"] = $user_id;
            $_SESSION["role"] = $role;
            $_SESSION["name"] = $name;

            
            if ($role == "startup") {
                header("Location: add_startup.php");
            } elseif ($role == "investitor") {
                header("Location: investor.php");
            }

            exit();

        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card p-4 shadow">

        <h3 class="mb-3">Sign Up</h3>

        <?php 
        if(isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form method="POST">

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Register As</label>
                <select name="role" class="form-control" required>
                    <option value="startup">Startup</option>
                    <option value="investitor">Investor</option>
                </select>
            </div>

            <button class="btn btn-success w-100">Register</button>

            <div class="text-center mt-3">
                <a href="login.php">Already have an account? Login</a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
<?php
session_start();
include "config.php";

// optional: protect page (only admin can add investors)
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // simple protection against SQL issues
    $name = $conn->real_escape_string($name);
    $last_name = $conn->real_escape_string($last_name);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    $sql = "INSERT INTO Users (Name, Last_Name, Email, Password, Role)
            VALUES ('$name', '$last_name', '$email', '$password', 'investitor')";

    if ($conn->query($sql) === TRUE) {
        // IMPORTANT: always return to admin dashboard
        header("Location: admin.php?msg=investor_added");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Investor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h3 class="mb-3">Add Investor</h3>

        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>

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
                <input type="text" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">
                Add Investor
            </button>

            <a href="admin.php" class="btn btn-secondary">Back</a>

        </form>

    </div>

</div>

</body>
</html>
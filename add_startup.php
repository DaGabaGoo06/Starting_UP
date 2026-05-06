<?php
session_start();
include "config.php";

// 🔒 ONLY STARTUP USERS ALLOWED
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "startup") {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// ✅ CHECK IF USER ALREADY HAS A STARTUP
$check = $conn->query("SELECT * FROM Startups WHERE owner_id = $user_id");

if ($check->num_rows > 0) {
    // already has startup → go to dashboard
    header("Location: startup.php");
    exit();
}

// 🚀 CREATE STARTUP
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["startup_Name"];
    $industry = $_POST["Industry"];
    $description = $_POST["Description"];

    // basic protection
    $name = $conn->real_escape_string($name);
    $industry = $conn->real_escape_string($industry);
    $description = $conn->real_escape_string($description);

    $sql = "INSERT INTO Startups (startup_Name, Industry, Description, owner_id)
            VALUES ('$name', '$industry', '$description', '$user_id')";

    if ($conn->query($sql)) {
        // ✅ GO TO DASHBOARD AFTER CREATION
        header("Location: startup.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Startup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h3 class="mb-3">Register Your Startup</h3>

        <?php 
        if(isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form method="POST">

            <div class="mb-3">
                <label>Startup Name</label>
                <input type="text" name="startup_Name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Industry</label>
                <input type="text" name="Industry" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="Description" class="form-control" required></textarea>
            </div>

            <button class="btn btn-success w-100">Create Startup</button>

        </form>

    </div>

</div>

</body>
</html>
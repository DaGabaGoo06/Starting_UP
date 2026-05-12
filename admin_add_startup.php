<?php
session_start();
include "config.php";


if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["startup_Name"];
    $industry = $_POST["Industry"];
    $description = $_POST["Description"];
    $owner_id = $_POST["owner_id"];

    
    $name = $conn->real_escape_string($name);
    $industry = $conn->real_escape_string($industry);
    $description = $conn->real_escape_string($description);

    $sql = "INSERT INTO Startups (startup_Name, Industry, Description, owner_id)
            VALUES ('$name', '$industry', '$description', '$owner_id')";

    if ($conn->query($sql)) {
        header("Location: admin.php?msg=startup_added");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add Startup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h3 class="mb-3">Admin: Create Startup</h3>

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

            
            <div class="mb-3">
                <label>Assign Owner (Startup User)</label>
                <select name="owner_id" class="form-control" required>

                    <?php
                    $users = $conn->query("SELECT * FROM Users WHERE Role='startup'");
                    while($u = $users->fetch_assoc()) {
                        echo "<option value='{$u['UserID']}'>
                                {$u['Name']} {$u['Last_Name']}
                              </option>";
                    }
                    ?>

                </select>
            </div>

            <button class="btn btn-success w-100">Create Startup</button>

        </form>

    </div>

</div>

</body>
</html>
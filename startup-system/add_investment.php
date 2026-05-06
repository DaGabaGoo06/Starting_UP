<?php
session_start();
include "config.php";

// allow both admin and investor
if (!isset($_SESSION["role"])) {
    header("Location: index.php");
    exit();
}

// investor is always logged-in user
$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $startup_id = $_POST["startup_id"];
    $amount = $_POST["amount"];

    $sql = "INSERT INTO Investments (investor_ID, startup_ID, Amount, Date)
            VALUES ($user_id, $startup_id, $amount, NOW())";

    $conn->query($sql);

    // redirect based on role
    if ($_SESSION["role"] == "investitor") {
        header("Location: investor.php?msg=invested");
    } else {
        header("Location: admin.php?msg=invested");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make Investment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card p-4 shadow">

        <h3>Make Investment</h3>

        <form method="POST">

            <!-- ONLY STARTUP CHOICE -->
            <div class="mb-3">
                <label>Select Startup</label>
                <select name="startup_id" class="form-control" required>
                    <?php
                    $res = $conn->query("SELECT * FROM Startups");
                    while($row = $res->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['startup_Name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- AMOUNT -->
            <div class="mb-3">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <button class="btn btn-success">Invest</button>

        </form>

    </div>

</div>

</body>
</html>
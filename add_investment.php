<?php
session_start();
include "config.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $investor_id = $_POST["investor_id"];
    $startup_id = $_POST["startup_id"];
    $amount = $_POST["amount"];

    $sql = "INSERT INTO Investments (investor_ID, startup_ID, Amount, Date)
            VALUES ($investor_id, $startup_id, $amount, NOW())";

    if ($conn->query($sql)) {

        
        if ($_SESSION["role"] == "investitor") {
            header("Location: investor.php?msg=invested");
        } else {
            header("Location: admin.php?msg=invested");
        }
        exit();

    } else {
        $error = "Error: " . $conn->error;
    }
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

        <?php
        if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form method="POST">

            
            <?php if ($_SESSION["role"] == "admin") { ?>
                <div class="mb-3">
                    <label>Select Investor</label>
                    <select name="investor_id" class="form-control" required>

                        <?php
                        $res = $conn->query("SELECT * FROM Users WHERE Role='investitor'");
                        while($row = $res->fetch_assoc()) {
                            echo "<option value='{$row['UserID']}'>
                                    {$row['Name']} {$row['Last_Name']}
                                  </option>";
                        }
                        ?>

                    </select>
                </div>
            <?php } else { ?>
                
                <input type="hidden" name="investor_id" value="<?php echo $_SESSION['user_id']; ?>">
            <?php } ?>

            
            <div class="mb-3">
                <label>Select Startup</label>
                <select name="startup_id" class="form-control" required>

                    <?php
                    $res = $conn->query("SELECT * FROM Startups");
                    while($row = $res->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>
                                {$row['startup_Name']}
                              </option>";
                    }
                    ?>

                </select>
            </div>

            
            <div class="mb-3">
                <label>Amount (€)</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">Invest</button>

        </form>

    </div>

</div>

</body>
</html>
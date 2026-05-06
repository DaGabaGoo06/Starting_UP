<?php
session_start();
include "config.php";

// 🔒 ONLY STARTUP USERS
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "startup") {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Startup Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- HEADER -->
    <div class="card shadow mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">

        <div>
            <h2 class="mb-0">🚀 Welcome, <?php echo $_SESSION["name"]; ?></h2>
            <small class="text-muted">Startup Dashboard</small>
        </div>

        <!-- LOGOUT BUTTON -->
        <a href="logout.php" class="btn btn-danger">
            Logout
        </a>

    </div>
</div>

    <?php
    // GET USER STARTUP
    $sql = "SELECT * FROM Startups WHERE owner_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0):
        $startup = $result->fetch_assoc();
        $startup_id = $startup["id"];
    ?>

    <!-- YOUR STARTUP -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Your Startup</h5>
        </div>

        <div class="card-body">
            <h4><?php echo $startup["startup_Name"]; ?></h4>
            <p><?php echo $startup["Description"]; ?></p>
            <span class="badge bg-success"><?php echo $startup["Industry"]; ?></span>
        </div>
    </div>

    <?php
    // 💰 TOTAL INVESTMENT
    $total_sql = "SELECT SUM(Amount) AS total FROM Investments WHERE startup_ID = $startup_id";
    $total_result = $conn->query($total_sql);
    $total = $total_result->fetch_assoc()["total"] ?? 0;
    ?>

    <!-- TOTAL INVESTMENT -->
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <h4>Total Investment Received</h4>
            <h2 class="text-success">€<?php echo $total; ?></h2>
        </div>
    </div>

    <!-- INVESTORS -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Investors in Your Startup</h5>
        </div>

        <div class="card-body">

            <table class="table table-hover text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Investor Name</th>
                        <th>Amount (€)</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $sql = "SELECT Users.Name, Users.Last_Name, Investments.Amount
                        FROM Investments
                        JOIN Users ON Investments.investor_ID = Users.UserID
                        WHERE Investments.startup_ID = $startup_id";

                $investors = $conn->query($sql);

                if ($investors->num_rows > 0):
                    while($row = $investors->fetch_assoc()):
                ?>

                    <tr>
                        <td><?php echo $row["Name"] . " " . $row["Last_Name"]; ?></td>
                        <td>€<?php echo $row["Amount"]; ?></td>
                    </tr>

                <?php
                    endwhile;
                else:
                ?>

                    <tr>
                        <td colspan="2">No investments yet</td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>

    <?php else: ?>

    <!-- NO STARTUP FOUND -->
    <div class="card shadow text-center">
        <div class="card-body">
            <h4 class="text-danger">No startup found for your account</h4>
            <p>You need to create your startup to start receiving investments.</p>

            <a href="add_startup.php" class="btn btn-success">
                Create Your Startup
            </a>
        </div>
    </div>

    <?php endif; ?>

</div>

</body>
</html>
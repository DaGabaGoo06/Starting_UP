<?php
session_start();
include "config.php";

if ($_SESSION["role"] != "startup") {
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

    
    <div class="card shadow mb-4">
        <div class="card-body text-center">

            <h2>🚀 Welcome, <?php echo $_SESSION["name"]; ?></h2>
            <p class="text-muted">Startup Dashboard</p>

            
            <div class="d-flex justify-content-center gap-2 mt-3">

                <a href="add_startup.php" class="btn btn-success">
                    + Add New Startup
                </a>

                <a href="logout.php" class="btn btn-danger">
                    Logout
                </a>

            </div>

        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Your Startups</h5>
        </div>

        <div class="card-body">

        <?php
        $sql = "SELECT * FROM Startups WHERE owner_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                echo "<div class='border p-3 mb-3 rounded'>";
                echo "<h4>{$row['startup_Name']}</h4>";
                echo "<p>{$row['Description']}</p>";
                echo "<span class='badge bg-success'>{$row['Industry']}</span>";
                echo "</div>";

            }
        } else {
            echo "<p class='text-danger'>No startups found. Create your first one!</p>";
        }
        ?>

        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Investments in Your Startups</h5>
        </div>

        <div class="card-body">

            <table class="table table-hover text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Investor Name</th>
                        <th>Startup</th>
                        <th>Amount (€)</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $sql = "SELECT Users.Name, Users.Last_Name, Startups.startup_Name, Investments.Amount
                        FROM Investments
                        JOIN Users ON Investments.investor_ID = Users.UserID
                        JOIN Startups ON Investments.startup_ID = Startups.id
                        WHERE Startups.owner_id = $user_id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['Name']} {$row['Last_Name']}</td>
                            <td>{$row['startup_Name']}</td>
                            <td>€{$row['Amount']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No investments yet</td></tr>";
                }
                ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>
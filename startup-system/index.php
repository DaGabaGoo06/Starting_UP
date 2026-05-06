




<?php
session_start();

if ($_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

include "config.php";
?>


<?php include "config.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Startup Monitoring System</title>
    

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fix table behavior -->
    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }
    </style>
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- Title -->
    <h1 class="text-center mb-4">Startup Monitoring System</h1>

    <!-- Navigation -->
    <div class="mb-4 text-center">
        <a href="admin.php" class="btn btn-primary">Home</a>
        <a href="add_startup.php" class="btn btn-success">Add Startup</a>
        <a href="add_investor.php" class="btn btn-info">Add Investor</a>
        <a href="add_investment.php" class="btn btn-warning">Add Investment</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- ========================= -->
    <!-- STARTUPS -->
    <!-- ========================= -->

    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Startups List</h4>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover w-100 text-center">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Industry</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $sql = "SELECT * FROM Startups";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["startup_Name"]."</td>";
                        echo "<td>".$row["Industry"]."</td>";
                        echo "<td>".$row["Description"]."</td>";

                        echo "<td>
                                <a href='delete.php?id=".$row["id"]."' 
                                   class='btn btn-danger btn-sm'
                                   onclick='return confirm(\"Are you sure?\")'>
                                   Delete
                                </a>
                              </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No startups found</td></tr>";
                }
                ?>

                </tbody>

            </table>

        </div>
    </div>

    <!-- ========================= -->
    <!-- INVESTORS -->
    <!-- ========================= -->

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Investors List</h4>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover w-100 text-center">

                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $sql = "SELECT * FROM Users WHERE Role='investitor'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>".$row["UserID"]."</td>";
                        echo "<td>".$row["Name"]." ".$row["Last_Name"]."</td>";
                        echo "<td>".$row["Email"]."</td>";

                        echo "<td>
                                <a href='delete_investor.php?id=".$row["UserID"]."' 
                                   class='btn btn-danger btn-sm'
                                   onclick='return confirm(\"Delete this investor?\")'>
                                   Delete
                                </a>
                              </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No investors found</td></tr>";
                }
                ?>

                </tbody>

            </table>

        </div>
    </div>

    <!-- ========================= -->
    <!-- INVESTMENTS -->
    <!-- ========================= -->

    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Investments</h4>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover w-100 text-center">

                <thead class="table-warning">
                    <tr>
                        <th>Investor</th>
                        <th>Startup</th>
                        <th>Amount (€)</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $sql = "SELECT Users.Name, Users.Last_Name, Startups.startup_Name, Investments.Amount, Investments.Date
                        FROM Investments
                        JOIN Users ON Investments.investor_ID = Users.UserID
                        JOIN Startups ON Investments.startup_ID = Startups.id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";

                        echo "<td>".$row["Name"]." ".$row["Last_Name"]."</td>";
                        echo "<td>".$row["startup_Name"]."</td>";
                        echo "<td>".$row["Amount"]."</td>";
                        echo "<td>".$row["Date"]."</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No investments found</td></tr>";
                }
                ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>
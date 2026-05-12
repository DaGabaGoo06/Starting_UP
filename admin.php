<?php
session_start();
include "config.php";


if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="text-center mb-4">Admin Dashboard</h2>

   
    <?php
    if (isset($_GET['msg'])) {
        echo "<div class='alert alert-success text-center'>Action completed successfully</div>";
    }
    ?>

    
    <div class="text-center mb-4">
        <a href="admin_add_startup.php" class="btn btn-success">Add Startup</a>
        <a href="add_investor.php" class="btn btn-primary">Add Investor</a>
        <a href="add_investment.php" class="btn btn-warning">Add Investment</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>



<div class="card shadow mb-4">
    <div class="card-header bg-secondary text-white">Startup Users</div>
    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover text-center">

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM Users WHERE Role='startup'";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['UserID']}</td>
                    <td>{$row['Name']} {$row['Last_Name']}</td>
                    <td>{$row['Email']}</td>
                    <td>{$row['Role']}</td>
                    <td>
                        <a href='delete_user.php?id={$row['UserID']}'
                           class='btn btn-danger btn-sm'
                           onclick='return confirm(\"Delete this user?\")'>
                           Delete
                        </a>
                    </td>
                </tr>";
            }
            ?>

        </table>

    </div>
</div>



    
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">Startups</div>
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover text-center">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Industry</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "SELECT * FROM Startups";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['startup_Name']}</td>
                        <td>{$row['Industry']}</td>
                        <td>{$row['Description']}</td>
                        <td>
                            <a href='delete.php?id={$row['id']}' 
                               class='btn btn-danger btn-sm'
                               onclick='return confirm(\"Delete this startup?\")'>
                               Delete
                            </a>
                        </td>
                    </tr>";
                }
                ?>

            </table>

        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">Investors</div>
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover text-center">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "SELECT * FROM Users WHERE Role='investitor'";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['UserID']}</td>
                        <td>{$row['Name']} {$row['Last_Name']}</td>
                        <td>{$row['Email']}</td>
                        <td>
                            <a href='delete_user.php?id={$row['UserID']}'
                               class='btn btn-danger btn-sm'
                               onclick='return confirm(\"Delete this investor?\")'>
                               Delete
                            </a>
                        </td>
                    </tr>";
                }
                ?>

            </table>

        </div>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header bg-warning">Investments</div>
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover text-center">

                <tr>
                    <th>Investor</th>
                    <th>Startup</th>
                    <th>Amount (€)</th>
                    <th>Date</th>
                </tr>

                <?php
                $sql = "SELECT Users.Name, Users.Last_Name, Startups.startup_Name, Investments.Amount, Investments.Date
                        FROM Investments
                        JOIN Users ON Investments.investor_ID = Users.UserID
                        JOIN Startups ON Investments.startup_ID = Startups.id";

                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['Name']} {$row['Last_Name']}</td>
                        <td>{$row['startup_Name']}</td>
                        <td>€{$row['Amount']}</td>
                        <td>{$row['Date']}</td>
                    </tr>";
                }
                ?>

            </table>

        </div>
    </div>

</div>

</body>
</html>
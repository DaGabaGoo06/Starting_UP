<?php
session_start();
include "config.php";

if ($_SESSION["role"] != "investitor") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Investor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    
    <div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="mb-0">Welcome, <?php echo $_SESSION["name"]; ?></h2>
        <small class="text-muted">Investor Dashboard</small>
    </div>

    
    <a href="logout.php" class="btn btn-danger">
        Logout
    </a>

</div>
    
    <div class="row">

    <?php
    $sql = "SELECT * FROM Startups";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
    ?>

        <div class="col-md-4 mb-4">

            <div class="card shadow">

                <div class="card-body">
                    <h5 class="card-title"><?php echo $row["startup_Name"]; ?></h5>
                    <p class="card-text"><?php echo $row["Description"]; ?></p>

                    <span class="badge bg-primary">
                        <?php echo $row["Industry"]; ?>
                    </span>

                    <br><br>

                    
                    <a href="add_investment.php?startup_id=<?php echo $row["id"]; ?>" 
                       class="btn btn-success btn-sm">
                       Invest
                    </a>

                </div>

            </div>

        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>
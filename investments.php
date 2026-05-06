<?php include "config.php"; ?>

<h2>Investments</h2>

<?php
$sql = "SELECT * FROM Investments";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "Investor ID: " . $row["investor_ID"] . 
         " → Startup ID: " . $row["startup_ID"] . 
         " | Amount: $" . $row["Amount"] . "<br>";
}
?>
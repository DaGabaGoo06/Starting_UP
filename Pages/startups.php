<?php include "../config.php"; ?>

<h2>Startups List</h2>

<?php
$sql = "SELECT * FROM Startups";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo $row["startup_Name"] . " - " . $row["Industry"] . "<br>";
}
?>
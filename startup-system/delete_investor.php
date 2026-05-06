<?php
include "config.php";

// check ID exists
if (!isset($_GET["id"])) {
    header("Location: admin.php");
    exit();
}

$id = $_GET["id"];

// 1. delete related investments first (IMPORTANT)
$conn->query("DELETE FROM Investments WHERE investor_ID = $id");

// 2. delete investor
$conn->query("DELETE FROM Users WHERE UserID = $id");

// 3. redirect back to admin dashboard
header("Location: admin.php?msg=deleted");
exit();
?>



<?php
include "config.php";

$id = $_GET["id"];

// delete child records first
$conn->query("DELETE FROM Investments WHERE startup_ID=$id");

// delete startup
$conn->query("DELETE FROM Startups WHERE id=$id");

// redirect back to admin
header("Location: admin.php?msg=deleted");
exit();
?>
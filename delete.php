<?php
include "config.php";

$id = $_GET["id"];


$conn->query("DELETE FROM Investments WHERE startup_ID=$id");


$conn->query("DELETE FROM Startups WHERE id=$id");


header("Location: admin.php?msg=deleted");
exit();
?>
<?php
include "config.php";


if (!isset($_GET["id"])) {
    header("Location: admin.php");
    exit();
}

$id = intval($_GET["id"]);


$conn->query("DELETE FROM Investments WHERE investor_ID = $id");


$conn->query("
    DELETE FROM Investments 
    WHERE startup_ID IN (
        SELECT id FROM Startups WHERE owner_id = $id
    )
");


$conn->query("DELETE FROM Startups WHERE owner_id = $id");


$conn->query("DELETE FROM Users WHERE UserID = $id");


header("Location: admin.php?msg=deleted");
exit();
?>
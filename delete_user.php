<?php
include "config.php";

// 🔒 check ID exists
if (!isset($_GET["id"])) {
    header("Location: admin.php");
    exit();
}

$id = intval($_GET["id"]);

// ===============================
// 1. DELETE INVESTMENTS made by user (as investor)
// ===============================
$conn->query("DELETE FROM Investments WHERE investor_ID = $id");

// ===============================
// 2. DELETE INVESTMENTS into user's startup(s)
// ===============================
$conn->query("
    DELETE FROM Investments 
    WHERE startup_ID IN (
        SELECT id FROM Startups WHERE owner_id = $id
    )
");

// ===============================
// 3. DELETE STARTUPS owned by user
// ===============================
$conn->query("DELETE FROM Startups WHERE owner_id = $id");

// ===============================
// 4. DELETE USER
// ===============================
$conn->query("DELETE FROM Users WHERE UserID = $id");

// ===============================
// DONE → redirect back
// ===============================
header("Location: admin.php?msg=deleted");
exit();
?>
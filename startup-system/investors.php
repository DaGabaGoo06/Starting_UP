<?php include "config.php"; ?>

<h2>Investors</h2>

<table border="1" class="table table-bordered">

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
    echo "<tr>";

    echo "<td>".$row["UserID"]."</td>";
    echo "<td>".$row["Name"]." ".$row["Last_Name"]."</td>";
    echo "<td>".$row["Email"]."</td>";

    echo "<td>
            <a href='delete_investor.php?id=".$row["UserID"]."' 
               class='btn btn-danger btn-sm'>
               Delete
            </a>
          </td>";

    echo "</tr>";
}
?>

</table>
<?php
require_once("../Model/db.php");
if (isset($_POST['city'])) {
    $city = $_POST['city'];

    // Assuming $connection is your database connection
    $query = "SELECT branch FROM cinema WHERE city = '$city'";
    $result = mysqli_query($connection, $query);

    $options = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row['branch'] . "'>" . htmlspecialchars($row['branch']) . "</option>";
    }

    echo $options;
}
?>

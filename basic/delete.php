<?php
include 'database.php';

if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id']);

    $query = "DELETE FROM barangs WHERE id = ?";
    $params = [$id];
    $sql = sqlsrv_query($conn, $query, $params);

    if ($sql) {
        header("Location:index.php?msg=delete");
    } else {
        $errors = print_r(sqlsrv_errors(), true);
        echo "<script>alert('$errors');</script>";
    }
} else {
    echo "biji";
}
?>
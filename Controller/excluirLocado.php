<?php
include "../Conn/Conn.php";

$id = $_GET['id'];
$sql =
    "DELETE FROM locado WHERE id ='$id'";


try {
    if (mysqli_query($conn, $sql)) {
        $message = 'success-create';
        return header("Location: ../View/locados.php?id=$id&&message=$message");
    } else {
        $message = 'error-create';
        return header("Location: ../View/locados.php?id=$id&&message=$message");
    }
} catch (Exception $e) {
    $message = 'error-create';
    return header("Location: ../View/locados.php?id=$id&&message=$message");
}
mysqli_close($conn);

?>
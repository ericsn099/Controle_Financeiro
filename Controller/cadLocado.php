<?php
require_once "../Conn/Conn.php";

$nome= $_POST['locado'];

$sql = "INSERT INTO locado (locado) 
VALUES ('$nome')";

try {
    if (mysqli_query($conn, $sql)) {
        $message = 'success-create';
        return header("Location: ../View/locados.php?message=$message");
    } else {
        $message = 'error-create';
        return header("Location: ../View/locados.php?message=$message");
    }
} catch (Exception $e) {
    $message = 'error-create';
    return header("Location: ../View/locados.php?message=$message");
}
mysqli_close($conn);

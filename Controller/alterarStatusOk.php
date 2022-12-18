<?php
include "../Conn/Conn.php";

$id = $_GET['id'];
$ok = 1;

$sql = 
"UPDATE funcionario 
SET stts='$ok'
WHERE id ='$id'";

try {
    if (mysqli_query($conn, $sql)) {
        $message = 'success-create';
        return header("Location: ../View/exibirFuncionario.php?message=$message");
    } else {
        $message = 'error-create';
        return header("Location: ../View/exibirFuncionario.php?message=$message");
    }
} catch (Exception $e) {
    $message = 'error-create';
    return header("Location: ../View/exibirFuncionario.php?message=$message");
}
mysqli_close($conn);

?>

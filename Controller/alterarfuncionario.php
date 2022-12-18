<?php
include "../Conn/Conn.php";

$id = $_POST['id'];
$nome =  $_POST['nome'];
$rg = $_POST['rg'];
$cpf = $_POST['cpf'];
$salariobruto = $_POST['salariobruto'];
$cmtipofuncao = $_POST['cmtipofuncao'];
$cmtipolocado = $_POST['cmtipolocado'];
$sql =
    "UPDATE funcionario 
    SET nome='$nome', 
    rg='$rg', 
    cpf='$cpf', 
    salariobruto='$salariobruto', 
    funcao_id='$cmtipofuncao',
    locado_id='$cmtipolocado'
    WHERE id ='$id'";

try {
    if (mysqli_query($conn, $sql)) {
        $message = 'success-create';
        return header("Location: ../View/exibirFuncionario.php?id=$id&&message=$message");
    } else {
        $message = 'error-create';
        return header("Location: ../View/exibirFuncionario.php?id=$id&&message=$message");
    }
} catch (Exception $e) {
    $message = 'error-create';
    return header("Location: ../View/exibirFuncionario.php?id=$id&&message=$message");
}
mysqli_close($conn);

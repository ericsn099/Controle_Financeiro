<?php
require_once "../Conn/Conn.php";

$nome = $_POST['nome'];
$salariobruto = $_POST['salariobruto'];
$cmtipofuncao = $_POST['cmtipofuncao'];
$cmtipolocado = $_POST['cmtipolocado'];
$rg = $_POST['rg'];
$cpf = $_POST['cpf'];

if ($salariobruto != '') {
    $pagamento = $salariobruto / 100 * 40;
} else {
    $salariobruto = 0;
    $pagamento = 0;
}
$sql = "INSERT INTO funcionario(nome, rg, cpf, salariobruto, pagamento,vtransporte,vrefeicao,sabado,producao,descontos,adiantamento,vrefeicao2,vtransporte2,vjanta,sabado2,gratificacao,descontos2,funcao_id,locado_id) 
VALUES ('$nome','$rg','$cpf','$salariobruto','$pagamento','0','0','0','0','0','0','0','0','0','0','0','0','$cmtipofuncao','$cmtipolocado')";

try {
    if (mysqli_query($conn, $sql)) {
        $message = 'success-create';
        return header("Location: ../View/funcionario.php?message=$message");
    } else {
        $message = 'error-create';
        return header("Location: ../View/funcionario.php?message=$message");
    }
} catch (Exception $e) {
    $message = 'error-create';
    return header("Location: ../View/funcionario.php?message=$message");
}
mysqli_close($conn);

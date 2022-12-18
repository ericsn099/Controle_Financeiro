<?php
include "../Conn/Conn.php";
$return = '';
if (isset($_POST["sql"])) {
    $checar = mysqli_real_escape_string($conn, $_POST["sql"]);
    $sql = "SELECT * FROM locado WHERE id > 1 AND locado.locado LIKE '%$checar%'";
}else{
    $sql = "SELECT * FROM locado WHERE id > 1 AND locado.locado LIKE '%%' ORDER BY locado";
}
$dados = mysqli_query($conn, $sql);
if (mysqli_num_rows($dados) > 0) {
    $i = 0;
    while ($linha = mysqli_fetch_array($dados)) {
        $i = $i + 1;
        $return .= '
        <tr>
        <td class="tg-tr"><a href="../View/locados.php?id=' . $linha['id'] . '"><img src="../css/img/pencil.png" alt=""></td>
        <td class="tg-tr"><a href="javascript:func()" onclick="confirmacao('.$linha['id'] .')"><img src="../css/img/redx.png" alt=""></td>
        <td class="tg-tr">' . $i . '</td>
        <td class="fixed-side">' . $linha['locado'] . '</td>
        </tr>
        ';
    }
    echo $return;
} else {
    echo 'SEM RESULTADOS...';
}
?>
<script language="Javascript">
    function confirmacao(id) {
        var resposta = confirm("Deseja remover esse registro?");
        if (resposta == true) {
            window.location.href = "../Controller/excluirLocado.php?id="+id;
        }
    }
</script>
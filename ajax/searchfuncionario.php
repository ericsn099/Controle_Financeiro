<?php
include "../Conn/Conn.php";
$return = '';
if (isset($_POST["sql"])) {
    $checar = mysqli_real_escape_string($conn, $_POST["sql"]);
    $sql = "SELECT funcionario.*, funcao.funcao,locado.locado, 
    SUM((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) AS total1,
    SUM((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2) AS total2,
    SUM(((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) + ((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2)) AS totalmes
    FROM funcionario, funcao, locado 
    WHERE funcionario.nome like '%$checar%'
    AND funcao_id = funcao.id
    AND locado_id = locado.id
    GROUP BY funcionario.id 
    ORDER BY funcionario.nome ASC;";
} else if (isset($_POST["locado"])) {
    $locado = mysqli_real_escape_string($conn, $_POST["locado"]);
    $sql = "SELECT funcionario.*, funcao.funcao,locado.locado, 
    SUM((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) AS total1,
    SUM((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2) AS total2,
    SUM(((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) + ((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2)) AS totalmes
    FROM funcionario, funcao, locado 
    WHERE locado.locado = '$locado'
    AND funcao_id = funcao.id
    AND locado_id = locado.id
    GROUP BY funcionario.id
    ORDER BY funcionario.nome ASC;  ";
} else {
    $sql = "SELECT funcionario.*, funcao.funcao,locado.locado, 
    SUM((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) AS total1,
    SUM((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2) AS total2,
    SUM(((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) + ((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2)) AS totalmes
    FROM funcionario, funcao, locado 
    WHERE funcionario.nome like '%%'
    AND funcao_id = funcao.id
    AND locado_id = locado.id
    GROUP BY funcionario.id
    ORDER BY funcionario.nome ASC; ";
}
$dados = mysqli_query($conn, $sql);
if (mysqli_num_rows($dados) > 0) {
    $i = 0;
    while ($linha = mysqli_fetch_array($dados)) {
        $i = $i + 1;
        if ($linha['stts'] == 0) {
            $tr = "style='background-color: #efff00;'";
            $ok = '';
            $block = '<td class="tg-tr"> <a href="../Controller/alterarStatusOk.php?id=' . $linha['id'] . '"><img src="../css/img/ok.png" alt=""></td>';
        } else {
            $tr = "";
            $block = '';
            $ok = '<td class="tg-tr"><a href="../Controller/alterarStatusBlock.php?id=' . $linha['id'] . '"><img src="../css/img/block.png" alt=""></td>';
        }
        $return .= '
        <tr ' . $tr . '>
        
            ' . $block . '
            ' . $ok . '
            <td class="tg-tr"><a href="../View/funcionario.php?id=' . $linha['id'] . '"><img src="../css/img/pencil.png" alt=""></td>
            <td class="tg-tr"><a href="javascript:func()" onclick="confirmacao(' . $linha['id'] . ')"><img src="../css/img/redx.png" alt=""></td>
            <td class="tg-tr">' . $i . '</td>
            <td class="fixed-side"><a href="folha.php?id=' . $linha['id'] . '">' . $linha['nome'] . '</td>
            <td class="tg-tr">' . $linha['funcao'] . '</td>
            <td class="tg-tr">' . $linha['locado'] . '</td>
            <td class="tg-tr">' . number_format($linha['pagamento'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['vtransporte'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['vrefeicao'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['sabado'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['producao'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['descontos'], 2, ',', '.') . '</td>
            <td class="tg-tr" style="background-color: #f5f5f5;">' . number_format($linha['total1'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['adiantamento'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['vrefeicao2'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['vtransporte2'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['vjanta'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['sabado2'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['gratificacao'], 2, ',', '.') . '</td>
            <td class="tg-tr">' . number_format($linha['descontos2'], 2, ',', '.') . '</td>
            <td class="tg-tr" style="background-color: #f5f5f5;">' . number_format($linha['total2'], 2, ',', '.') . '</td>
            <td class="tg-tr" style="background-color: #f5f5f5;">' . number_format($linha['totalmes'], 2, ',', '.') . '</td>
        </tr>';
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
            window.location.href = "../Controller/excluirFuncionario.php?id=" + id;
        }
    }
</script>
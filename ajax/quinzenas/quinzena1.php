<link rel="stylesheet" href="../css/tablefuncionario.css" />
<link rel="stylesheet" href="../css/relatorio.css" />
<?php
include "../../Conn/Conn.php";
include "../../Class/Extenso.php";
$return = '';
if (isset($_POST["idq"])) {
    $id = mysqli_real_escape_string($conn, $_POST["idq"]);
    $sql = "SELECT funcionario.*, funcao.funcao,locado.locado 
    FROM funcionario, funcao, locado 
    WHERE locado.locado = '$id'
    AND funcao_id = funcao.id
    AND locado_id = locado.id
    AND funcionario.stts = 1
    ORDER BY funcionario.nome
    ASC;";
} else {
    $sql = "SELECT funcionario.*, funcao.funcao,locado.locado 
    FROM funcionario, funcao, locado 
    WHERE funcao_id = funcao.id
    AND locado_id = locado.id
    AND funcionario.stts = 1
    ORDER BY funcionario.nome
    ASC; ";
}
$dados = mysqli_query($conn, $sql);
if (mysqli_num_rows($dados) > 0) {
    while ($linha = mysqli_fetch_array($dados)) {
        $totalpagamento = ($linha['vtransporte'] + $linha['vrefeicao'] + $linha['sabado'] + $linha['producao']);
        $extenso = Extenso::converte($totalpagamento, true, false);
        $return .= '
        <div class="tb">
            <table>
                <tr>
                    <td class="td-cabecalho">
                        <div class="form-img">
                            <div class="img-area">
                                <img src="../css/img/logoHTC.png" alt="user">
                            </div>
                        </div>
                        <div class="form-img" id="info">
                            <div class="img-area" id="info-inside">
                                <label for="" class="label-info">HTC Transportes e Locação</label>
                                <label for="" class="label-info">Rua Ayres de Almeida, 549 - Raiz</label>
                                <label for="" class="label-info">CNPJ: 12.869.347/0001-54</label>
                                <label for="" class="label-info">Telefones: 3877-1799 / 3877-4799</label>
                                <label for="" class="label-info">E-mail: htctransportes10@hotmail.com</label>
                            </div>
                        </div>
                        <div class="form-img">
                            <div class="img-area">
                                <img src="../css/img/caminhao.webp" alt="user">
                            </div>
                        </div>
                        <div class="form-img" id="recibo">
                            <div class="img-area">
                                <label for="" class="label-info2">RECIBO</label>
                                <label for="" class="label-info3">R$ ' . number_format($totalpagamento, 2, ',', '.')  . '</label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>RECEBEMOS DE: HUMBERTO DA COSTA GOMES</td>
                </tr>
                <tr>
                    <td>ENDEREÇO: RUA AYRES DE ALMEIDA. 549 RAIZ</td>
                </tr>
                <tr>
                    <td>A IMPORTÂNCIA DE: ' . $extenso . '
                    </td>
                </tr>
                <tr>
                    <td>REFERENTE À: R$ ' . number_format($linha["vrefeicao"], 2, ',', '.') . ' - REFEIÇÃO | R$ ' . number_format($linha["vtransporte"], 2, ',', '.') . ' - TRANSPORTE | R$ ' . number_format($linha["sabado"], 2, ',', '.') . ' - SÁBADO | R$ ' . number_format($linha["producao"], 2, ',', '.') . ' - PRODUÇÃO</td>
                </tr>
                <tr>
                    <td style="display: flex; align-items: center; flex-direction: column;"> ' . $linha["nome"] . ' / PIS: ' . $linha["rg"] . ' / CPF: ' . $linha["cpf"] . '
                    </td>
                </tr>
                <tr>
                    <td class="td-1" style="display: flex;">RECEBIMENTO ATRAVÉS DE CHEQUE</td>
                </tr>
            </table>
            <table>

                <tr>
                    <td class="tb-p1">BANCO: <br><br><br><br><br><br></td>
                    <td class="tb-p1">AGÊNCIA: <br><br><br><br><br><br></td>
                    <td class="tb-p1">
                    CONTA CORRENTE: <br><br><br>
                    CONTA POUPANÇA: <br><br><br>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="tb-p2">DATA</td>
                    <td class="tb-p3">ASSINATURA</td>
                </tr>
                <tr>
                    <td class="tb-p4"> </td>
                    <td class="tb-p4"> </td>
                </tr>
            </table>
        </div>
        <div class="espaco"> </div>
        ';
    }
    echo $return;

} else {
    echo 'SEM RESULTADOS...';
}
?>
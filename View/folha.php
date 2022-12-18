<?php
session_start() or die('A sessão não pode ser iniciada');
require_once "../session/sessionAdm.php";
require_once "../Conn/Conn.php";
include "../Class/Extenso.php";

$id = $_GET['id'];
$sqlAlterar = "SELECT funcionario.*, locado.locado, funcao.funcao, SUM(vtransporte + vrefeicao + sabado + producao) AS quinzena1, SUM(vtransporte2 + vrefeicao2 + sabado2 + gratificacao) AS quinzena2
FROM funcionario, locado, funcao
WHERE funcionario.id = $id
AND locado.id = locado_id
AND funcao.id = funcao_id;";

$dados = mysqli_query($conn, $sqlAlterar);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/folha.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <link rel="stylesheet" href="../css/relatorio.css" />
    <title>RECIBO</title>
</head>
<?php
$dados1 = mysqli_query($conn, $sqlAlterar);
while ($linha = mysqli_fetch_assoc($dados1)) { ?>

    <body>
        <div class="container">
            <div class="container-area">
                <div class="container-form">
                    <form class="form" method="POST" action="../Controller/alterarFolha.php">
                        <label class="label-input">
                            <?php
                            echo "<input type='hidden' name='id' id='id' value='" . $linha['id'] . "'>";
                            ?>
                        </label>
                        <div class="cabecalho">
                            <label class="label-input">
                                NOME: <?php echo $linha['nome'] ?>
                            </label>
                            <label class="label-input">
                                SALÁRIO BRUTO: R$ <?php echo number_format($linha['salariobruto'], 2, ',', '.'); ?>
                            </label>
                            <label class="label-input">
                                FUNÇÃO: <?php echo $linha['funcao'] ?>
                            </label>
                            <label class="label-input">
                                LOCADO: <?php echo $linha['locado'] ?>
                            </label>
                            <label class="label-input">
                                <select name="quinzena" id="quinzena" class="ui-select-style">
                                    <option value="0">SELECIONE O PERÍODO PARA GERAR RECIBO</option>
                                    <option value="1">1º QUINZENA</option>
                                    <option value="2">2º QUINZENA</option>
                                </select>
                            </label>
                        </div>
                        <div class="div-form-label">
                            <div class="colum-1">
                                <label class="label-input" style="font-weight: bold; font-size: 22px;">
                                    1º QUINZENA
                                </label>
                                <label class="label-input">
                                    VALE TRANSPORTE: <input type="text" name="vtransporte" id="" value="<?php echo number_format($linha['vtransporte'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    REFEIÇÃO: <input type="text" name="vrefeicao" id="" value="<?php echo number_format($linha['vrefeicao'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    SÁBADO: <input type="text" name="sabado" id="" value="<?php echo number_format($linha['sabado'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    PRODUÇÃO: <input type="text" name="producao" id="" value="<?php echo number_format($linha['producao'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    DESCONTOS: <input type="text" name="descontos" id="" value="<?php echo number_format($linha['descontos'], 2, ',', '.'); ?>">
                                </label>
                            </div>
                            <div class="colum-2">
                                <label class="label-input" style="font-weight: bold; font-size: 22px;">
                                    2º QUINZENA
                                </label>
                                <label class="label-input">
                                    ADIANTAMENTO: <input type="text" name="adiantamento" id="" value="<?php echo number_format($linha['adiantamento'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    REFEIÇÃO: <input type="text" name="vrefeicao2" id="" value="<?php echo number_format($linha['vrefeicao2'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    VALE TRANSPORTE: <input type="text" name="vtransporte2" id="" value="<?php echo number_format($linha['vtransporte2'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    VALOR DA JANTA: <input type="text" name="vjanta" id="" value="<?php echo number_format($linha['vjanta'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    EXTRA SÁBADO: <input type="text" name="sabado2" id="" value="<?php echo number_format($linha['sabado2'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    GRATIFICAÇÃO: <input type="text" name="gratificacao" id="" value="<?php echo number_format($linha['gratificacao'], 2, ',', '.'); ?>">
                                </label>
                                <label class="label-input">
                                    DESCONTOS: <input type="text" name="descontos2" id="" value="<?php echo number_format($linha['descontos2'], 2, ',', '.'); ?>">
                                </label>
                            </div>
                        </div>
                        <div class="container-button">
                            <button class="bt-btf" id="cadastrar">CADASTRAR</button>
                            <a id="gerar" class="bt-btf" onclick="window.print()">GERAR RECIBO</a>
                            <a id="voltar" class="bt-btf" onclick="window.location.href = '../View/exibirFuncionario.php'">VOLTAR</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="div-tb">

        </div>
    </body>
<?php
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</html>

<?php
if (isset($_GET['message'])) echo (printMessage($_GET['message']));
function printMessage($message)
{
    if ($message == 'success-create')
        return "<div class='modal'>
                    <div class='modal-area'>
                        <div class='modal-info'>
                            <div class='texto-agente'>
                            SALVO COM SUCESSO
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    let abrirModal = () => document.querySelector('.modal').style.display = 'flex';
                    let fecharModal = () => document.querySelector('.modal').style.display = 'none';
                    setTimeout(() => {
                    abrirModal();
                    clearTimeout();
                    }, 0)

                    setTimeout(() => {
                    fecharModal();
                    window.location.replace('../View/exibirFuncionario.php');
                    }, 1000)
                </script>
                ";
    if ($message == 'error-create')
        return "<div class='modal'>
                    <div class='modal-area' style='background-color: #9d3535'>
                        <div class='modal-info'>
                            <div class='texto-agente'>
                                ERRO AO SALVAR
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    let abrirModal = () => document.querySelector('.modal').style.display = 'flex';
                    let fecharModal = () => document.querySelector('.modal').style.display = 'none';
                    setTimeout(() => {
                    abrirModal();
                    clearTimeout();
                    }, 0)

                    setTimeout(() => {
                    fecharModal();
                    }, 2000)
                </script>
                ";
}
?>
<script>
    function load_data4(id) {
        $.ajax({
            url: "../ajax/quinzenaindividual1.php",
            method: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('.div-tb').html(data);
            }
        });
    }

    function load_data5(id) {
        $.ajax({
            url: "../ajax/quinzenaindividual2.php",
            method: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('.div-tb').html(data);
            }
        });
    }
    $('#quinzena').click(function() {
        var quinzena = $('#quinzena').val();
        if (quinzena == 1) {
            $(document).ready(function() {
                search = $('#id').val();
                load_data4(search);
            });
        } else if (quinzena == 2) {
            $(document).ready(function() {
                search = $('#id').val();
                load_data5(search);
            });
        }
    });
</script>
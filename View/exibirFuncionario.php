<?php
session_start() or die('A sessão não pode ser iniciada');
include "../session/sessionAdm.php";
require_once "../Conn/Conn.php";

$sqlTodos = "SELECT locado.locado 
FROM locado 
WHERE id > 1
ORDER BY locado.locado ASC
;";

$sql = "SELECT 
SUM(pagamento) as pagamento,
SUM(vtransporte) as vtransporte,
SUM(vrefeicao) as vrefeicao,
SUM(sabado) as sabado,
SUM(producao) as producao,
SUM(descontos) as descontos,
SUM(vtransporte) as vtransporte,
SUM(adiantamento) as adiantamento,
SUM(vrefeicao2) as vrefeicao2,
SUM(vtransporte2) as vtransporte2,
SUM(vjanta) as vjanta,
SUM(sabado2) as sabado2,
SUM(gratificacao) as gratificacao,
SUM(descontos2) as descontos2,
SUM((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) AS total1,
SUM((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2) AS total2,
SUM(((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) + ((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2)) AS totalmes
FROM funcionario";

$dadosTodos = mysqli_query($conn, $sqlTodos);
$dadosTotal = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tablefuncionario.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <link rel="stylesheet" href="../css/relatorio.css" />
    <title>EXIBIR FUNCIONARIOS</title>
</head>

<body>

    <div class="container">
        <div class="container-area">
            <div class="container-area2">
                <div class="container-pesquisa">
                    <div class="container-pesquisa-in">
                        <input type="text" name="checar" id="checar" placeholder="DIGITE O NOME DO FUNCIONÁRIO">
                        <select name="locado" id="locado" class="ui-select-style">
                            <option value="">SELECIONE UM LOCADO</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($dadosTodos)) {
                                $locado = $linha['locado'];
                                echo "<option value='$locado'>$locado</option>";
                            }
                            ?>
                        </select>
                        <select name="quinzena" id="quinzena" class="ui-select-style">
                            <option value="">SELECIONE O PERÍODO</option>
                            <option value="1">1º QUINZENA</option>
                            <option value="2">2º QUINZENA</option>
                        </select>
                    </div>
                    <div class="container-sair">
                        <button id="sair" onclick="window.location.href = '../Controller/sair.php'">SAIR</button>
                    </div>
                </div>
                <div class="input-radio">

                </div>
                <div class="container-dados">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Nº</th>
                                <th class="fixed-side" id="fixed">FUNCIONÁRIO </th>
                                <th>FUNÇÃO</th>
                                <th>LOCADO</th>
                                <th>PAGAMENTO</th>
                                <th>VALE TRANSPORTE</th>
                                <th>REFEIÇÃO</th>
                                <th>EXTRA SÁBADO</th>
                                <th>GANHO POR PRODUÇÃO</th>
                                <th>DESCONTOS</th>
                                <th>TOTAL À PAGAR</th>
                                <th>ADIANTAMENTO</th>
                                <th>REFEIÇÃO</th>
                                <th>VALE TRANSPORTE</th>
                                <th>VALOR DA JANTA</th>
                                <th>EXTRA SÁBADO</th>
                                <th>GRATIFICAÇÃO</th>
                                <th>DESCONTOS</th>
                                <th>TOTAL À PAGAR</th>
                                <th>TOTAL DO MÊS</th>
                            </tr>
                        </thead>
                        <tbody id="result"></tbody>
                        <tbody>
                            <tr>
                                <th class="fixed-side" id="fixed" colspan="7">TOTAL</th>
                                <?php
                                while ($total = mysqli_fetch_assoc($dadosTotal)) {
                                    echo "<th> " . number_format($total['pagamento'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['vtransporte'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['vrefeicao'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['sabado'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['producao'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['descontos'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['total1'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['adiantamento'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['vrefeicao2'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['vtransporte2'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['vjanta'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['sabado2'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['gratificacao'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['descontos2'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['total2'], 2, ',', '.') . " </th>";
                                    echo "<th> " . number_format($total['totalmes'], 2, ',', '.') . " </th>";
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="container-button">
                    <button class="bt-btf" onclick="window.location.href = 'funcionario.php'">CADASTRAR FUNCIONÁRIO</button>
                    <button class="bt-btf" id="recibos" onclick="window.print()">IMPRIMIR RECIBOS</button>
                    <button class="bt-btf" onclick="window.location.href = 'exibirLocados.php'">LOCADOS</button>
                    <button class="bt-btf" onclick="window.location.href = 'relatorioGastos.php'">RELATÓRIO DE GASTOS</button>
                </div>
            </div>
        </div>
    </div>
    <div class="div-tb" id="div-tb">

    </div>
</body>

</html>
<?php if (isset($_GET['message'])) echo (printMessage($_GET['message']));
function printMessage($message)
{
    if ($message == 'success-create')
        return "<div class='modal'>
                    <div class='modal-area'>
                        <div class='modal-info'>
                            <div class='texto-agente'>
                            SUCESSO
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
                                ERRO AO EXCLUIR
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        load_data();
        load_data2();
        load_data3();
        locado = $('#locado').val();
        quinzena = $('#quinzena').val();

        function load_data(sql) {
            $.ajax({
                url: "../ajax/searchfuncionario.php",
                method: "POST",
                data: {
                    sql: sql
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#checar').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });

        function load_data2(locado) {
            $.ajax({
                url: "../ajax/searchfuncionario.php",
                method: "POST",
                data: {
                    locado: locado
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        function load_data3(locado) {
            $.ajax({
                url: "../ajax/quinzenas/quinzena1.php",
                method: "POST",
                data: {
                    locado: locado
                },
                success: function(data) {
                    $('#div-tb').html(data);
                }
            });
        }

        function load_dataQuinzena1(idq) {
            $.ajax({
                url: "../ajax/quinzenas/quinzena1.php",
                method: "POST",
                data: {
                    idq: idq
                },
                success: function(data) {
                    $('.div-tb').html(data);
                }
            });
        }

        function load_dataQuinzena2(id) {
            $.ajax({
                url: "../ajax/quinzenas/quinzena2.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('.div-tb').html(data);
                }
            });
        }
        $('#locado').click(function() {
            locado = $('#locado').val();
            if (locado != '' && quinzena == '') {
                load_data2(locado);
                load_data3(locado);
            } else {
                load_data2();
                load_data3();
            }
        });


        $('#quinzena').click(function() {
            var quinzena = $('#quinzena').val();
            if (locado != '' && quinzena != '') {
                if (quinzena == 1) {
                    load_dataQuinzena1(locado);
                } else if (quinzena == 2) {
                    load_dataQuinzena2(locado);
                }
            } else if (locado == '' && quinzena == '' || quinzena == '1') {
                load_dataQuinzena1();
            } else if (locado == '' && quinzena == '2') {
                load_dataQuinzena2();
            }
        });
    });
</script>
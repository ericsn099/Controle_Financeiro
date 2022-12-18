<?php
session_start() or die('A sessão não pode ser iniciada');
include "../session/sessionAdm.php";
require_once "../Conn/Conn.php";

$sqlTodos = "SELECT locado.locado 
FROM locado 
WHERE id > 1
ORDER BY locado.locado ASC
;";

$sql = "SELECT funcionario.nome,
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
FROM funcionario
GROUP BY funcionario.id
ORDER BY funcionario.nome
ASC
";

$sql2 = "SELECT
SUM((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) AS total10,
SUM((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2) AS total20,
SUM(((pagamento + vtransporte + vrefeicao + sabado + producao) - descontos) + ((adiantamento + vtransporte2 + vrefeicao2 + sabado2 + gratificacao + vjanta) - descontos2)) AS total1mes
FROM funcionario
";
$dadosTodos = mysqli_query($conn, $sqlTodos);
$dadosTotal = mysqli_query($conn, $sql);
$dadosTotal2 = mysqli_query($conn, $sql2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/modal.css" />
    <link rel="stylesheet" href="../css/relatorioGastos.css" />
    <title>RELATÓRIO</title>
</head>

<body>

    <div class="container">
        <div class="container-area">
            <div class="container-cabecalho">
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
                    </td>
                </tr>
            </div>
            <div class="container-dados">
                <table>
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>FUNCIONÁRIO </th>
                            <th>1º QUINZENA</th>
                            <th>2º QUINZENA</th>
                            <th>TOTAL DO MÊS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($linha = mysqli_fetch_assoc($dadosTotal)) {
                            $i = $i + 1;
                        ?>
                            <tr>
                                <td id="n"><?php echo $i ?></td>
                                <td id="nome"><?php echo $linha['nome']; ?></td>
                                <td><?php echo $linha['total1']; ?></td>
                                <td><?php echo $linha['total2']; ?></td>
                                <td><?php echo $linha['totalmes'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <th colspan="2">TOTAL</th>
                            <?php
                            while ($total = mysqli_fetch_assoc($dadosTotal2)) {
                                echo "<th> " . number_format($total['total10'], 2, ',', '.') . " </th>";
                                echo "<th> " . number_format($total['total20'], 2, ',', '.') . " </th>";
                                echo "<th> " . number_format($total['total1mes'], 2, ',', '.') . " </th>";
                            }
                            ?>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="container-button">
                <button class="bt-btf" onclick="window.print()">IMPRIMIR RELATÓRIO</button>
                <button class="bt-btf" onclick="window.location.href = 'exibirFuncionario.php'">VOLTAR</button>
            </div>
        </div>
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
    $('#recibos').click(function() {
        var search = $(this).val();
        window.alert("EM MANUTENÇÃO")
    });
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
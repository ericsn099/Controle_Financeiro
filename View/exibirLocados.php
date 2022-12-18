<?php
session_start() or die('A sessão não pode ser iniciada');
require_once "../session/sessionAdm.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/locado.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <title>CADASTRAR FUNCIONÁRIO</title>
</head>

<body>
    <div class="container">
        <div class="container-area">
            <div class="container-area2">
                <div class="container-pesquisa">
                    <div class="container-pesquisa-in">
                        <input type="text" name="checar" id="checar" placeholder="DIGITE O NOME DO LOCADO">
                    </div>
                </div>
                <div class="container-dados">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 10%;"></th>
                                <th style="width: 10%;"></th>
                                <th style="width: 10%;">Nº</th>
                                <th class="fixed-side" id="fixed" style="width: 70%;">LOCADO</th>
                            </tr>
                        </thead>
                        <tbody id="result">

                        </tbody>
                    </table>
                </div>
                <div class="container-button">
                    <button class="bt-btf" onclick="window.location.href = 'locados.php'">CADASTRAR LOCADOS</button>
                    <button class="bt-btf" onclick="window.location.href = '../View/exibirFuncionario.php'">VOLTAR</button>
                    
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</html>
<?php if (isset($_GET['message'])) echo (printMessage($_GET['message']));
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
        $(document).ready(function() {
        load_data();

        function load_data(sql) {
            $.ajax({
                url: "../ajax/exibirlocado.php",
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
    });
</script>
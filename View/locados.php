<?php
session_start() or die('A sessão não pode ser iniciada');
require_once "../session/sessionAdm.php";
require_once "../Conn/Conn.php";
include "../Class/Extenso.php";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/locado.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <link rel="stylesheet" href="../css/relatorio.css" />
    <title>RECIBO</title>
</head>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlAlterar = "SELECT locado.*
    FROM locado
    WHERE locado.id = $id;";
    $dados = mysqli_query($conn, $sqlAlterar);
    $dados1 = mysqli_query($conn, $sqlAlterar);
    while ($linha = mysqli_fetch_assoc($dados1)) { ?>

        <body>
            <div class="container">
                <div class="container-area">
                    <div class="container-form">
                        <form class="form" method="POST" action="../Controller/alterarLocado.php">
                            <label class="label-input">
                                <?php
                                echo "<input type='hidden' name='id' id='id' value='" . $linha['id'] . "'>";
                                ?>
                            </label>
                            <div class="div-form-label">
                                <label class="label-input">
                                    LOCADO: <input type="text" name="locado" id="" value="<?php echo $linha['locado']; ?>">
                                </label>
                            </div>
                            <div class="container-button">
                                <button class="bt-btf" id="cadastrar">SALVAR</button>
                                <a id="voltar" class="bt-btf" onclick="window.location.href = '../View/exibirLocados.php'">VOLTAR</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </body>
    <?php
    }
} else if (!isset($_GET['id'])) {
    ?>

    <body>
        <div class="container">
            <div class="container-area">
                <div class="container-form">
                    <form class="form" method="POST" action="../Controller/cadLocado.php">
                        <label class="label-input">
                            <?php
                            echo "<input type='hidden' name='id' id='id' value=''>";
                            ?>
                        </label>
                        <div class="div-form-label">
                            <label class="label-input">
                                LOCADO: <input type="text" name="locado" id="locado">
                            </label>
                        </div>
                        <div class="container-button">
                            <button class="bt-btf" id="cadastrar">SALVAR</button>
                            <a id="voltar" class="bt-btf" onclick="window.location.href = '../View/exibirLocados.php'">VOLTAR</a>
                        </div>
                    </form>
                </div>
            </div>
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
                    window.location.replace('../View/exibirLocados.php');
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
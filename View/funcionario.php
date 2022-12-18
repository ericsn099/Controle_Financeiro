<?php
session_start() or die('A sessão não pode ser iniciada');
require_once "../session/sessionAdm.php";
require_once "../Conn/Conn.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/css.css" />
    <link rel="stylesheet" href="../css/modal.css" />
    <title>CADASTRAR FUNCIONÁRIO</title>
</head>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlAlterar = "SELECT funcionario.*, locado.locado, funcao.funcao
    FROM funcionario, funcao, locado
    WHERE funcionario.id = $id
    AND locado_id = locado.id
    AND funcao_id = funcao.id
    ;";
    $dados = mysqli_query($conn, $sqlAlterar);
    while ($linha = mysqli_fetch_assoc($dados)) { ?>

        <body>
            <div class="container">
                <div class="container-area">
                    <div class="container-form">
                        <form class="form" method="POST" action="../Controller/alterarfuncionario.php">
                            <label class="label-input">
                                <?php
                                echo "<input type='hidden' name='id' id='id' value='" . $linha['id'] . "'>";
                                ?>
                            </label>
                            <label class="label-input">
                                <input type="text" name="nome" id="" value="<?php echo $linha['nome']; ?>" placeholder="NOME" required>
                            </label>
                            <label class="label-input">
                                <input type="number" name="rg" id="" value="<?php echo $linha['rg']; ?>" placeholder="PIS" onkeydown="return FilterInput(event)" onpaste="handlePaste(event)" required>
                            </label>
                            <label class="label-input">
                                <input type="number" name="cpf" id="" value="<?php echo $linha['cpf']; ?>" placeholder="CPF" onkeydown="return FilterInput(event)" onpaste="handlePaste(event)" required>
                            </label>
                            <label class="label-input">
                                <input type="number" name="salariobruto" value="<?php echo $linha['salariobruto']; ?>" id="" placeholder="SALÁRIO BRUTO" onkeydown="return FilterInput(event)" onpaste="handlePaste(event)">
                            </label>
                            <label class="label-input">
                                <select class="ui-select-style" id="sl_tipofuncao" name='cmtipofuncao' required>
                                    <option>SELECIONE A FUNÇÃO</option>
                                    <?php
                                    $sqlChecklist = "SELECT * FROM funcao ORDER BY funcao ASC";
                                    $dados2 = mysqli_query($conn, $sqlChecklist);
                                    if (mysqli_num_rows($dados2) > 0) {
                                        while ($linha2 = mysqli_fetch_array($dados2)) { ?>
                                            <option value="<?php echo $linha2["id"] ?>" <?php if ($linha['funcao_id'] == $linha2['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $linha2["funcao"] ?> </option>
                                    <?php }
                                        echo $return;
                                    }
                                    ?>
                                </select>
                            </label>
                            <label class="label-input">
                                <select class="ui-select-style" id="sl_tipolocado" name='cmtipolocado'>
                                    <option value="1">SELECIONE O LOCADO</option>
                                    <?php
                                    $sqlChecklist2 = "SELECT * FROM locado WHERE id > 1 ORDER BY locado ASC";
                                    $dados3 = mysqli_query($conn, $sqlChecklist2);
                                    if (mysqli_num_rows($dados3) > 0) {
                                        while ($linha3 = mysqli_fetch_array($dados3)) { ?>
                                            <option value="<?php echo $linha3["id"] ?>" <?php if ($linha['locado_id'] == $linha3['id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $linha3["locado"] ?> </option>
                                    <?php }
                                        echo $return;
                                    }
                                    ?>
                                </select>
                            </label>

                            <div class="container-button">
                                <button class="bt-btf" id="cadastrar">CADASTRAR</button>
                                <a class="bt-btf" id="cadastrar" onclick="window.location.href = 'exibirFuncionario.php'">VOLTAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
    <?php
    }
} else {
    ?>

    <body>
        <div class="container">
            <div class="container-area">
                <div class="container-form">
                    <form class="form" method="POST" action="../Controller/cadfuncionario.php">
                        <label class="label-input">
                            <input type="text" name="nome" id="" placeholder="NOME" required>
                        </label>
                        <label class="label-input">
                            <input type="number" name="rg" id="" placeholder="PIS" onkeydown="return FilterInput(event)" onpaste="handlePaste(event)" required>
                        </label>
                        <label class="label-input">
                            <input type="number" name="cpf" id="" placeholder="CPF" onkeydown="return FilterInput(event)" onpaste="handlePaste(event)" required>
                        </label>
                        <label class="label-input">
                            <input type="number" name="salariobruto" id="" placeholder="SALÁRIO BRUTO" onkeydown="return FilterInput(event)" onpaste="handlePaste(event)">
                        </label>
                        <label class="label-input">
                            <select class="ui-select-style" id="sl_tipofuncao2" name='cmtipofuncao' required>
                                <option>SELECIONE A FUNÇÃO</option>
                                <?php
                                $sqlChecklist = "SELECT * FROM funcao ORDER BY funcao ASC";
                                $dados2 = mysqli_query($conn, $sqlChecklist);
                                if (mysqli_num_rows($dados2) > 0) {
                                    while ($linha2 = mysqli_fetch_array($dados2)) { ?>
                                        <option value="<?php echo $linha2["id"] ?>"><?php echo $linha2["funcao"] ?> </option>
                                <?php }
                                    echo $return;
                                }
                                ?>
                            </select>
                        </label>
                        <label class="label-input">
                            <select class="ui-select-style" id="sl_tipolocado2" name='cmtipolocado' required>
                                <option value="1">SELECIONE O LOCADO</option>
                                <?php
                                $sqlChecklist2 = "SELECT * FROM locado WHERE id > 1 ORDER BY locado ASC";
                                $dados3 = mysqli_query($conn, $sqlChecklist2);
                                if (mysqli_num_rows($dados3) > 0) {
                                    while ($linha3 = mysqli_fetch_array($dados3)) { ?>
                                        <option value="<?php echo $linha3["id"] ?>"><?php echo $linha3["locado"] ?> </option>
                                <?php }
                                    echo $return;
                                }
                                ?>
                            </select>
                        </label>

                        <div class="container-button">
                            <button class="bt-btf" id="cadastrar">CADASTRAR</button>
                            <a class="bt-btf" id="cadastrar" onclick="window.location.href = 'exibirFuncionario.php'">VOLTAR</a>
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
    function FilterInput(event) {
        var keyCode = ('which' in event) ? event.which : event.keyCode;

        isNotWanted = (keyCode == 69 || keyCode == 107 || keyCode == 109 || keyCode == 187 || keyCode == 189 || keyCode == 38 || keyCode == 40);
        return !isNotWanted;
    };

    function handlePaste(e) {
        var clipboardData, pastedData;

        // Get pasted data via clipboard API
        clipboardData = e.clipboardData || window.clipboardData;
        pastedData = clipboardData.getData('Text').toUpperCase();

        if (pastedData.indexOf('E') > -1) {
            //alert('found an E');
            e.stopPropagation();
            e.preventDefault();
        }
    };
</script>
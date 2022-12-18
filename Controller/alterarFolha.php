<?php
include "../Conn/Conn.php";

$id = $_POST['id'];
$vtransporte =  Extenso::removerFormatacaoNumero($_POST['vtransporte']);
$vrefeicao = Extenso::removerFormatacaoNumero($_POST['vrefeicao']);
$sabado = Extenso::removerFormatacaoNumero($_POST['sabado']);
$producao = Extenso::removerFormatacaoNumero($_POST['producao']);
$descontos = Extenso::removerFormatacaoNumero($_POST['descontos']);
$gratificacao = Extenso::removerFormatacaoNumero($_POST['gratificacao']);
$vjanta = Extenso::removerFormatacaoNumero($_POST['vjanta']);
$vtransporte2 = Extenso::removerFormatacaoNumero($_POST['vtransporte2']);
$vrefeicao2 = Extenso::removerFormatacaoNumero($_POST['vrefeicao2']);
$sabado2 = Extenso::removerFormatacaoNumero($_POST['sabado2']);
$adiantamento = Extenso::removerFormatacaoNumero($_POST['adiantamento']);
$descontos2 = Extenso::removerFormatacaoNumero($_POST['descontos2']);
$sql = 
"UPDATE funcionario 
SET vtransporte='$vtransporte', 
vrefeicao='$vrefeicao', 
sabado='$sabado', 
producao='$producao', 
descontos='$descontos',
gratificacao='$gratificacao',
vjanta='$vjanta',
vtransporte2='$vtransporte2',
vrefeicao2='$vrefeicao2',
sabado2='$sabado2',
adiantamento='$adiantamento',
descontos2='$descontos2'
WHERE id ='$id'";

try {
    if (mysqli_query($conn, $sql)) {
        $message = 'success-create';
        return header("Location: ../View/folha.php?id=$id&&message=$message");
    } else {
        $message = 'error-create';
        return header("Location: ../View/folha.php?id=$id&&message=$message");
    }
} catch (Exception $e) {
    $message = 'error-create';
    return header("Location: ../View/folha.php?id=$id&&message=$message");
}
mysqli_close($conn);

class Extenso
{
    public static function removerFormatacaoNumero( $strNumero )
    {

        $strNumero = trim( str_replace( "R$", '', $strNumero ) );

        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }

        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );

        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;

        return $resultado;

    }
}
?>

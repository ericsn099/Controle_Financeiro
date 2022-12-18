<?php
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

    public static function converte( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {
        $singular = null;
        $plural = null;

        if ( $bolExibirMoeda )
        {
            $singular = array("CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUATRILHÃO");
            $plural = array("CENTAVOS", "REAIS", "MIL", "MILHÔES", "BILHÔES", "TRILHÔES","QUADRILHÔES");
        }
        else
        {
            $singular = array("", "", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUATRILHÃO");
            $plural = array("", "", "MIL", "MILHÔES", "BILHÔES", "TRILHÔES","QUADRILHÔES");
        }

        $c = array("", "CEM", "DUZENTOS", "TREZENTOS", "QUATROCENTOS","QUINHENTOS", "SEISCENTOS", "SETECENTOS", "OITOCENTOS", "NOVECENTOS");
        $d = array("", "DEZ", "VINTE", "TRINTA", "QUARENTA", "CINQUENTA","SESSENTA", "SETENTA", "OITENTA", "NOVENTA");
        $d10 = array("DEZ", "ONZE", "DOZE", "TREZE", "QUATORZE", "QUINZE","DEZESSEIS", "DEZESSETE", "DEZOITO", "DEZENOVE");
        $u = array("", "UM", "DOIS", "TRÊS", "QUATRO", "CINCO", "SEIS","SETE", "OITO", "NOVE");

        if ( $bolPalavraFeminina )
        {
            if ($valor == 1)
                $u = array("", "UMA", "DUAS", "TRÊS", "QUATRO", "CINCO", "SEIS","SETE", "OITO", "NOVE");
            else
                $u = array("", "UM", "duas", "três", "QUATRO", "CINCO", "SEIS","SETE", "OITO", "NOVE");

            $c = array("", "CEM", "DUZENTOS", "TREZENTOS", "QUATROCENTOS","QUINHENTOS", "SEISCENTOS", "SETECENTOS", "OITOCENTOS", "NOVECENTOS");
        }

        $z = 0;

        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );

        for ( $i = 0; $i < count( $inteiro ); $i++ )
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ )
                $inteiro[$i] = "0" . $inteiro[$i];

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "CENTO" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " E " : "") . $rd . (($rd && $ru) ? " E " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;

            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " DE " : "") . $plural[$t];

            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " E ") : " ") . $r;
        }

        $rt = mb_substr( $rt, 1 );

        return($rt ? trim( $rt ) : "ZERO REAIS");

    }
}

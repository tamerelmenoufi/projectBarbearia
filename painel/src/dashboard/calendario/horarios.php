<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $dia = json_decode($_SESSION['PeriodoLoja']->dias_horas_atendimento);
    var_dump($_SESSION['PeriodoLoja']->dias_horas_atendimento);
    echo "<hr>";
    echo $hj = date("D");
    echo "<hr>";
    echo $dia->$hj;

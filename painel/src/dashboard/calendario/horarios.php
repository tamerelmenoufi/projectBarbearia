<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $dia = json_decode($_SESSION['PeriodoLoja']->dias_horas_atendimento);
    echo $dia->date("D");
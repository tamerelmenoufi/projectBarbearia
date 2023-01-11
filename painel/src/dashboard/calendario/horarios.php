<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $dia = json_decode($_SESSION['PeriodoLoja']->dias_horas_atendimento);
    $hj = $abrevSem[date("D")];
    list($hi, $hf) = explode("-",$dia->$hj);
    $inter_ini = strtotime(date("Y-m-d {$hi}:00"));
    $inter_fim = strtotime(date("Y-m-d {$hf}:00"));

    echo "<p>{$inter_ini} até {$inter_fim}</p>";


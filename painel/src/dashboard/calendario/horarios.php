<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $c = mysqli_fetch_object(mysqli_query($con, "select * from colaboradores where codigo = '{$_POST['colaborador']}'"));


    $dia = json_decode($_SESSION['PeriodoLoja']->dias_horas_atendimento);
    $hj = $abrevSem[date("D")];
    list($hi, $hf) = explode("-",$dia->$hj);
    $inter_ini = strtotime(date("Y-m-d {$hi}:00"));
    $inter_fim = strtotime(date("Y-m-d {$hf}:00"));

    echo "<p>Colab.: {$_POST['colaborador']} - Serv.: {$_POST['servico']}</p>";

    for($i = $inter_ini; $i <= $inter_fim; $i = (($i + 60)*$c->tempo)){
        echo "<p>".date("d/m/Y H:i",$i)."</p>";
    }

    $inter_ini = strtotime(date("Y-m-d 10:00:00"));
    $inter_fim = strtotime(date("Y-m-d 10:01:00"));
    echo "<p>{$inter_ini} até {$inter_fim}</p>";
    echo ($inter_fim - $inter_ini);
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>

<style>
    .agendamento{
        margin-left:10px;
        padding:3px;
        border-radius:5px;
        background-color:rgb(125,11,234, 0.7);
        color:#fff;
        font-size:9px;
    }
</style>

<div class="p-1" style="font-size:12px;">
    <h6>Agenda do dia</h6>
    <ul class="list-group">
    <?php
    for($i=0;$i<24;$i++){
        $j = [0,15,30,45];
        foreach($j as $ind => $h){
            $hora = str_pad($i , 2 , '0' , STR_PAD_LEFT).":".str_pad($h , 2 , '0' , STR_PAD_LEFT);
    ?>
    <li class="list-group-item">
        <i class="fa-solid fa-calendar-day"></i> <?=$hora?>
        <span class="agendamento">José Ribamar<br> <i>Eduardo Fernandes</i> </span>
    </li>
    <?php
        }
    }
    ?>
</div>
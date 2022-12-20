<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>

<style>

</style>

<div class="p-1">
    <h6>Agenda do dia</h6>
    <ul class="list-group">
    <?php
    for($i=0;$i<24;$i++){
        $j = [0,15,30,45];
        foreach($j as $ind => $h){
    ?>
    <li class="list-group-item">
        <?="{$i}:{$h}"?>
    </li>
    <?php
        }
    }
    ?>
</div>
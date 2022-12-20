<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<div class="card p-2">
    <h6>Agenda do dia</h6>
    <ul class="list-group">
    <?php
    for($i=0;$i<24;$i++){
    ?>
    <li class="list-group-item">An item</li>
    <?php
    }
    ?>
</div>
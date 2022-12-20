<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>

<style>

.element {
  scrollbar-width: thin;
  scrollbar-color: black transparent;
}

.element::-webkit-scrollbar {
  width: 3px;
  height: 3px; /* A altura só é vista quando a rolagem é horizontal */
}

.element::-webkit-scrollbar-track {
  background: transparent;
  padding: 2px;
}

.element::-webkit-scrollbar-thumb {
  background-color: #000;
}

</style>

<div class="p-1 element" style="position:relative; height:350px; overflow:auto; width:100%; clear:both;">
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
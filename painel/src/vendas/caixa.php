<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div style="width:100%; position:absolute; overflow:auto;">
    <?php
        for($i=0;$i<10;$i++){
    ?>
    <div class="col"> Coluna <?=$i?></div>
    <?php
        }
    ?>
</div>
<h5>Dados do caixa</h5>

<script>
    $(function(){
        Carregando('none');


    })
</script>
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<h5>Dados do caixa</h5>
<div style="width:100%; position:absolute; overflow:auto;">
    <div class="row">
    <?php
        for($i=0;$i<10;$i++){
    ?>
    <div class="col"> Coluna <?=$i?></div>
    <?php
        }
    ?>
    </div>
</div>


<script>
    $(function(){
        Carregando('none');


    })
</script>
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>
    .Categoria-principal{
        display:flex;
        flex-direction:row;
        justify-content:left;
        height:100px;
        left:0;
        right:0;
        position:absolute;
        overflow-x:auto;
        white-space:nowrap;
    }
    .elementos{
        width:auto;
        height:60px;
        padding:20px;
        border:1px red solid;
        position:relative;
        white-space:nowrap;
        float:left;
        margin:10px;
    }
</style>
<h5>Dados do caixa</h5>
<div class="Categoria-principal">
    <?php
        for($i=0;$i<30;$i++){
    ?>
    <div class="elementos"> Coluna <?=$i?></div>
    <?php
        }
    ?>
</div>


<script>
    $(function(){
        Carregando('none');


    })
</script>
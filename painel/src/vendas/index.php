<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div class="p-3" style="position:fixed; left:0px; top:55px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div lista class="col-md-12"></div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');
        $.ajax({
            url:"src/vendas/caixa.php",
            success:function(dados){
                $("div[lista]").html(dados);
            }
        });
    })
</script>
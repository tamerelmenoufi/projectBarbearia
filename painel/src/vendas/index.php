<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div class="p-3">
    <div class="row" style="position:relative; border:solid 1px red">
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
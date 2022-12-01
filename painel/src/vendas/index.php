<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div class="p-3" style="position:fixed; left:20px; top:80px; right:20px; bottom:10px; border:solid 1px red">
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
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div class="list-group">
<?php

    $query = "select * from colaboradores where situacao = '1' order by nome asc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

    // for($i=0;$i<10;$i++){
?>
    <a href="#" class="list-group-item list-group-item-action opc_profissional" codigo="<?=$d->codigo?>"><?=$d->nome?></a>
<?php
    }
?>
</div>
<script>
    $(function(){
        Carregando('none');
        $(".opc_profissional").click(function(){
            codigo = $(this).attr("codigo");
            nome = $(this).html();
            $(".dados_profissionais").attr("codigo", codigo);
            $(".dados_profissionais").html(nome);

            let myOffCanvas = document.getElementById('offcanvasDireita');
            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            openedCanvas.hide();

        });
    })
</script>
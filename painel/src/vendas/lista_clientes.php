<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div class="list-group">
<?php

    $query = "select * from clientes order by nome asc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

    // for($i=0;$i<10;$i++){
?>
    <a href="#" class="list-group-item list-group-item-action opc_cliente" codigo="<?=$d->codigo?>"><?=$d->nome?></a>
<?php
    }
?>
</div>
<script>
    $(function(){
        Carregando('none');
        $(".opc_cliente").click(function(){

            codigo = $(this).attr("codigo");
            nome = $(this).html();
            $(".dados_clientes").attr("codigo", codigo);
            $(".dados_clientes").html(nome);

            let myOffCanvas = document.getElementById('offcanvasDireita');
            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            openedCanvas.hide();

            $.ajax({
                url:"",
                type:"POST",
                data:{
                    codCliente:codigo,
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            });

        });
    })
</script>
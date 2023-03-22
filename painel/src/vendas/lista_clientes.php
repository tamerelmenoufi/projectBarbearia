<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>
<style>

</style>

<div class="d-flex flex-row-reverse mb-3">
    <button id="novoCliente" class="btn btn-primary">
        <i class="fa fa-user"></i> Novo Cliente
    </button>
</div>


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


        $("#novoCliente").click(function(){

            let myOffCanvas = document.getElementById('offcanvasDireita');
            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            openedCanvas.hide();

            $.ajax({
                url:"src/clientes/index.php",
                type:"POST",
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            });

        });

        $(".opc_cliente").click(function(){

            codigo = $(this).attr("codigo");
            nome = $(this).html();
            $(".dados_clientes").attr("codigo", codigo);
            $(".dados_clientes").html(nome);

            let myOffCanvas = document.getElementById('offcanvasDireita');
            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            openedCanvas.hide();

            $.ajax({
                url:"src/vendas/caixa.php",
                type:"POST",
                data:{
                    codCliente:codigo,
                    nomeCliente:nome,
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            });

        });
    })
</script>
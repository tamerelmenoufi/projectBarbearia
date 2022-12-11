<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    if($_POST['acao'] == 'excluir'){
        mysqli_query($con, "delete from vendas_produtos where codigo = '{$_POST['codigo']}'");
    }

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
    <a href="#" class="list-group-item list-group-item-action opc_colaborador" codigo="<?=$d->codigo?>"><?=$d->nome?></a>
<?php
    }
?>
</div>
<script>
    $(function(){
        Carregando('none');
        $(".opc_colaborador").click(function(){
            codigo = $(this).attr("codigo");
            nome = $(this).html();

            $.ajax({
                type:"POST",
                data:{
                    codigo:"<?=$_POST['codigo']?>",
                    produto:"<?=$_POST['produto']?>",
                    colaborador:codigo,
                    acao:'colaborador'
                },
                url:"src/vendas/compras.php",
                success:function(dados){
                    $(".produtos_lista").html(dados);
                }
            });

            // $(".dados_profissionais").attr("codigo", codigo);
            // $(".dados_profissionais").html(nome);

            let myOffCanvas = document.getElementById('offcanvasDireita');
            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            openedCanvas.hide();

        });
    })
</script>
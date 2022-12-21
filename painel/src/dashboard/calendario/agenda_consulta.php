<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $query = "select
                    a.*,
                    b.nome as cliente_nome,
                    c.nome as colaborador_nome,
                    d.produto as servico_nome,
                    e.codigo as cod_venda
                from agenda a
                    left join clientes b on a.cliente = b.codigo
                    left join colaboradores c on a.colaborador = c.codigo
                    left join produtos d on a.servico = d.codigo
                    left join vendas e on a.codigo = e.agenda
                where a.data_agenda = '{$_SESSION['agenda_dia']} {$_POST['hora']}'";
    $result = mysqli_query($con, $query);

?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
    .dados p.identificacao{
        color:#a1a1a1;
    }
    .dados p.identificacao span{
        font-size:9px
    }

    .dados p.identificacao_ativo{
        color:#000;
    }
    .dados p.identificacao_ativo span{
        font-size:9px
    }

</style>
<h4 class="Titulo<?=$md5?>"><i class="fa-solid fa-calendar-day"></i> <?=dataBr("{$_SESSION['agenda_dia']} {$_POST['hora']}")?></h4>
<?php
while($d = mysqli_fetch_object($result)){

    echo $qs = "select * from produtos where codigo in(".implode(",",json_decode($d->servico)).")";
    $rs = mysqli_query($con, $qs);
    $servicos = [];
    while($ds = mysqli_fetch_object($rs)){
        $servicos[] = $ds->produto;
    }
    $servicos = implode(", ", $servicos);

?>
<div class="card m-3 p-3 <?=(($_POST['codigo'] == $d->codigo)?'text-bg-info':false)?>">
    <div class="row">
        <div class="col dados">
            <h6><i class="fa-solid fa-scissors"></i> Serviços</h6>
            <p style="font-size:10px; padding:0; margin:0; margin-left:20px; margin-bottom:10px;"><?=$servicos?></p>
            <h6><i class="fa-solid fa-user-clock"></i> <?=$d->cliente_nome?></h6>
            <!-- <p class="identificacao<?=(($_POST['codigo'] == $d->codigo)?'_ativo':false)?>"><i class="fa-solid fa-user-clock"></i> <?=$d->cliente_nome?></p> -->
            <p style="font-size:10px; padding:0; margin:0; margin-left:20px; margin-bottom:10px;">Atendimento por: <?=$d->colaborador_nome?></p>
            <h6><i class="fa-solid fa-circle-info"></i> Observações</h6>
            <p style="font-size:10px; padding:0; margin:0; margin-left:20px; margin-bottom:10px;"><?=$d->observacao?></p>
            <button
                    class="btn btn-primary"
                    iniciar_atendimento="<?=$d->codigo?>"
                    codCliente="<?=$d->cliente?>"
                    nomeCliente="<?=$d->cliente_nome?>"
            ><i class="fa-regular fa-circle-check"></i> Iniciar atendimento</button>
        </div>
    </div>
</div>
<?php
}
?>

<script>
    $(function(){
        $("button[iniciar_atendimento]").click(function(){
            agenda = $(this).attr("iniciar_atendimento");
            codCliente = $(this).attr("codCliente");
            nomeCliente = $(this).attr("nomeCliente");
            Carregando();
            $.ajax({
                url:"src/vendas/caixa.php",
                type:"POST",
                data:{
                    agenda,
                    codCliente,
                    nomeCliente
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            });
            let myOffCanvas = document.getElementById('offcanvasDireita');
            let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
            openedCanvas.hide();
        });
    })
</script>
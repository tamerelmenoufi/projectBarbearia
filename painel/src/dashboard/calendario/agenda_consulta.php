<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    vl(['ProjectPainel']);

    $query = "select
                    a.*,
                    b.nome as cliente_nome,
                    c.nome as colaborador_nome,
                    d.produto as servico_nome,
                    e.codigo as cod_venda,
                    e.agenda as cod_agenda,
                    (select (select count(*) from vendas_produtos where venda = v.codigo) from vendas v where v.cliente = b.codigo and v.situacao = 'n' and v.deletado != '1') as venda_status
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

    $vcod_agenda = explode(",",$d->cod_agenda);

    $qs = "select * from produtos where codigo in(".implode(",",json_decode($d->servico)).")";
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
            <?php
            if($_SESSION['agenda_dia'] == date("Y-m-d")){
            if(in_array($d->codigo, $vcod_agenda)){
            ?>
            <button
                    class="btn btn-success"
                    iniciar_atendimento=""
                    codCliente="<?=$d->cliente?>"
                    nomeCliente="<?=$d->cliente_nome?>"
            ><i class="fa-regular fa-circle-check"></i> Esta Agenda está na comanda</button>
            <?php
            }else if($d->venda_status > 0){
            ?>
            <button
                    class="btn btn-warning"
                    iniciar_atendimento="<?=$d->codigo?>"
                    codCliente="<?=$d->cliente?>"
                    nomeCliente="<?=$d->cliente_nome?>"
            ><i class="fa-regular fa-circle-check"></i> Incluir agenda na comanda atual</button>
            <?php
            }else{
            ?>
            <button
                    class="btn btn-primary"
                    iniciar_atendimento="<?=$d->codigo?>"
                    codCliente="<?=$d->cliente?>"
                    nomeCliente="<?=$d->cliente_nome?>"
            ><i class="fa-regular fa-circle-check"></i> Abrir comanda com esta agenda</button>
            <?php
            }}else{
            ?>
            <button
                    class="btn btn-danger"
                    cancelar_atendimento="<?=$d->codigo?>"
            ><i class="fa-regular fa-circle-check"></i> Cancelar a agenda</button>
            <?php
            }
            ?>
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

        $("button[cancelar_atendimento]").click(function(){
            codigo = $(this).attr("cancelar_atendimento");
            $.confirm({
                content:"Deseja realmente cancelar a agenda?",
                title:"Cancelar Agenda",
                buttons:{
                    'Sim':{
                        text:'Sim',
                        btnClass:'btn btn-danger',
                        action:function(){
                            $.ajax({
                                url:"src/dashboard/calendario/agenda_dia.php",
                                type:"POST",
                                data:{
                                    codigo,
                                    acao:'cancelar_agenda'
                                },
                                success:function(dados){
                                    $("div[agendaDia]").html(dados);
                                }
                            });
                        },
                    'Não':{
                        text:'Não',
                        btnClass:'btn btn-success',
                        action:function(){

                        }
                    }
                    }
                }
            });
        });
    })
</script>
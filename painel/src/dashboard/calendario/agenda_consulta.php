<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);

    $query = "select
                    a.*,
                    b.nome as cliente_nome,
                    c.nome as colaborador_nome,
                    d.produto as servico_nome
                from agenda a
                    left join clientes b on a.cliente = b.codigo
                    left join colaboradores c on a.colaborador = c.codigo
                    left join produtos d on a.servico = d.codigo
                where a.data_agenda = '{$_SESSION['agenda_dia']}'";
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
</style>
<h4 class="Titulo<?=$md5?>"><i class="fa-solid fa-calendar-day"></i> <?=dataBr($d->data_agenda)?></h4>
<?php
while($d = mysqli_fetch_object($result)){
?>
<div class="card mh-3 p-3 <?=(($_POST['codigo'] == $d->codigo)?'text-bg-info':false)?>">
    <div class="row">
        <div class="col dados">
            <h6><i class="fa-solid fa-scissors"></i> <?=$d->servico_nome?></h6>
            <p class="identificacao"><i class="fa-solid fa-user-clock"></i> <?=$d->cliente_nome?><br><span><i class="fa-solid fa-user"></i> Atendimento por: <?=$d->colaborador_nome?></span></p>
            <p><i class="fa-solid fa-circle-info"></i> <?=$d->observacao?></p>
        </div>
    </div>
</div>
<?php
}
?>
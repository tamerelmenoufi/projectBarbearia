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
                    left join colaboradores c on a.cloaborador = c.codigo
                    left join produtos d on a.servico = d.codigo
                where a.codigo = '{$_POST['codigo']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
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
<h4 class="Titulo<?=$md5?>"><?=dataBr($d->data_agenda)?></h4>

<div class="card mh-3 p-3">
    <div class="row">
        <div class="col dados">
            <h6><?=$d->servico_nome?></h6>
            <p class="identificacao"><?=$d->cliente_nome?> <span><?=$d->colaborador_nome?></span></p>
            <p><?=$d->observacao?></p>
        </div>
    </div>
</div>
<?php
include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

VerificarVendaApp();

function aasort(&$array, $key)
{
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
}

$query = "select * from categorias where codigo = '{$_GET['categoria']}' AND deletado != '1'";
$result = mysqli_query($con, $query);
$d = mysqli_fetch_object($result);

$m_q = "select * from categoria_medidas where codigo in({$d->medidas}) AND deletado != '1' "
    . "ORDER BY ordem";
$m_r = mysqli_query($con, $m_q);

while ($m = mysqli_fetch_array($m_r)) {
    if($m->medida == 'UNIDADE'){
        $M[$m['codigo']] = [
            "ordem" => $m['ordem'],
            "descricao" => $m['medida']
        ];
    }
}
?>

<style>


    .topo<?=$md5?> {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 55px;
        padding: 20px;
        font-weight: bold;
        background-color:#f5ebdc;
        z-index: 1;
    }

    .IconePedidos {
        position: fixed;
        top: 10px;
        right: 25px;
        font-size: 30px;
        color: #333;
        font-weight: bold;
        z-index: 10;
        display: <?=(($_SESSION['AppCarrinho'])?'block':'none')?>;
    }

    .MensagemAddProduto {
        position: fixed;
        right: 80px;
        top: 15px;
        background-color: #333;
        color: #fff;
        text-align: center;
        font-weight: bold;
        border-radius: 5px;
        padding: 5px;
        width: auto;
        z-index: 3;
        display: none;
    }

    .MensagemAddProduto span {
        position: absolute;
        right: -8px;
        font-size: 30px;
        top: -3px;
        color: #333;
    }


</style>

<!-- Informativo de pedidos ativos -->

<span class="IconePedidos"><i
            class="fa-solid fa-bell-concierge animate__animated animate__tada animate__repeat-3"
    ></i></span>

<div class="MensagemAddProduto animate__animated animate__shakeX">
    Produto Adicionado!
    <span><i class="fa-solid fa-caret-right"></i></span>
</div>

<!-- Informativo de pedidos ativos -->


<div class="topo<?= $md5 ?>">
    <center><?= $d->categoria ?></center>
</div>


<div class="col-md-12 ListarCombos"></div>

<script>

$(function(){
    $.ajax({
        url:"componentes/ms_combos.php",
        success:function(dados){
            $(".ListarCombos").html(dados);
        }
    });


    $(".IconePedidos").click(function () {
        $.ajax({
            url: "componentes/ms_popup_100.php",
            type: "POST",
            data: {
                local: "src/produtos/pedido.php",
            },
            success: function (dados) {
                PageClose();
                $(".ms_corpo").append(dados);
            }
        });
    });

})

</script>
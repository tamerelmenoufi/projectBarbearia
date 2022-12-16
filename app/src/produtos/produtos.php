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
    .foto<?=$md5?> {
        position: absolute;
        left:50%;
        top:50%;
        margin-left:-75px;
        margin-top:-75px;
        background-size: 100%;
        background-position: center;
        background-repeat:no-repeat;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        width:150px;
        height:150px;
    }
    .icone{
        background-size: 50%;
        background-position: center;
        background-repeat:no-repeat;
    }

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

    .card{
        background-color:#eee !important;
    }

    .produto_descricao{
        text-align:left;
        height:auto;
        font-style: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

    }


/* MS PRODUTOS */

    .ms_produtos{
        position:relative;
        width:100%;
        border-radius:20px;
        background-color:#f2e5d4;
        height:150px;
        background-position:left top;
        background-repeat:no-repeat;
        background-size:auto 80%;
        margin-bottom:30px;
        margin-top:20px;
        padding-bottom:80px;
    }
    .ms_produtos p{
        padding-left:5px;
        padding-right:5px;
        background-color:#f2e5d4;
        border-radius:10px;
        position:absolute;
        top:-20px;
        right:10px;
        font-weight:bold;
        font-size:20px;
        color:#9C9C9C;
        /* text-transform: uppercase;
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF; */
    }

    .ms_produtos span{
        padding:5px;
        /* background-color:#eee; */
        border-radius:6px;
        position:absolute;
        /* opacity:0.6; */
        bottom:60px;
        right:5px;
        font-weight:bold;
        font-size:20px;
        color:#d62300;
        text-shadow:
               -1px -1px 0px #FFF,
               -1px 1px 0px #FFF,
                1px -1px 0px #FFF,
                1px 0px 0px #FFF;
    }

    .ms_produtos span sup{
        font-weight:normal;
        font-size:10px;
    }
    .ms_produtos span sub{
        font-weight:bold;
        font-size:10px;
    }

    .ms_produtos text{
        position:absolute;
        left:10px;
        bottom:5px;
        font-weight:normal;
        font-size:10px;
        text-align:left;
        height:auto;
        font-style: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

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


<div class="col-md-12">
    <?php
    $query = "select * from produtos where categoria = '{$d->codigo}' AND situacao = '1' AND deletado != '1'";
    $result = mysqli_query($con, $query);
    $i=0;
    while ($p = mysqli_fetch_object($result)) {

        // $detalhes = json_decode($p->detalhes, true);
        // $detalhes_2 = [];

        if(is_file("../../../painel/produtos/icon/{$p->icon}")){
            $url = "{$caminho_sis}/painel/produtos/icon/{$p->icon}";
        }else{
            $url = "./img/sem_produto.svg";
            $icone = 'icone';
        }

        ?>


<!-- PRODUTOS TESTE -->
    <?php
        // foreach ($detalhes as $key => $val) :
        //     $val['ordem'] = $M[$key]['ordem'];
        //     $detalhes_2[$key] = $val;
        // endforeach;

        // aasort($detalhes_2, "ordem");

        // foreach ($detalhes_2 as $key2 => $val) {
        //     if ($val["quantidade"] > 0) {

                 list($valor,$decimal) = explode(".", $p->valor);
        if($i%3 == 0){
?>
    <div promocao_frete style="width:100%; text-align:center; margin-bottom:30px;">
        <img src="img/promocao_frete_gratis.gif" alt="Promoção Frete Grátis" style="width:100%; border-radius:10px;" />
    </div>
<?php

        }
    ?>
    <div
        acao_medida
        class="ms_produtos"
        style="background-image:url(<?=$url?>)"
        produto="<?= $p->codigo ?>"
        titulo='<?= "{$d->categoria} - {$p->produto}" ?>'
        categoria='<?= $p->categoria ?>'
        valor_produto='<?= $p->valor ?>'

    >
        <p><?=$p->produto?></p>


                    <span
                        acao_medida
                        produto="<?= $p->codigo ?>"
                        titulo='<?= "{$d->categoria} - {$p->produto}" ?>'
                        categoria='<?= $p->categoria ?>'
                        valor_produto='<?= $p->valor ?>'
                    > <sub>R$</sub> <?= $valor ?><sup>,<?= str_pad($decimal , 2 , '0' , STR_PAD_RIGHT) ?></sup></span>

        <text><?= $p->descricao ?></text>
    </div>

    <?php

            //     }
            // }
    $i++;
    }
    ?>
</div>

<script>

    $("div[acao_medida]").click(function () {
        opc = $(this).attr("opc");
        produto = $(this).attr("produto");
        title = $(this).attr("titulo");
        categoria = $(this).attr("categoria");
        valor = $(this).attr("valor_produto");

        Carregando();
        $.ajax({
            url: "componentes/ms_popup_100.php",
            type: "POST",
            data: {
                local: "src/produtos/produto.php",
                categoria,
                produto,
                valor
            },
            success: function (dados) {
                $(".ms_corpo").append(dados);
            }
        });

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

</script>
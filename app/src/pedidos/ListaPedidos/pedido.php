<?php
    include("../conf.php");
?>

<style>
    .PedidoTopoTitulo{
        position:fixed;
        left:0px;
        top:0px;
        width:100%;
        height:60px;
        background:#f5ebdc;
        padding-left:70px;
        padding-top:15px;
        z-index:1;
    }
    .PedidoBottomFixo{
        position:fixed;
        bottom:0;
        left:0;
        width:100%;
        background:#f5ebdc;
    }
    .PedidoBottomItens{
        padding:10px;
        text-align:center;
    }
    .PedidoBottomItens button{
        width:calc(100% - 25px);
    }


    .mais{
        position:absolute;
        bottom:0;
        width:50px;
        left:110px;
        font-size:20px;
    }
    .quantidade{
        position:absolute;
        bottom:0;
        width:50px;
        left:60px;
        border:0;
        text-align:center;
        background:transparent !important;
    }
    .menos{
        position:absolute;
        bottom:0;
        width:50px;
        left:10px;
        font-size:20px;
    }

    .rotulo_valor{
        position:absolute;
        right:0px;
        bottom:0px;
        font-size:20px;
        font-weight:bold;
    }


    .icone{
        font-size:70px;
    }

</style>
    <div class="PedidoTopoTitulo">
    <h4>Pedido <?=$_POST['pedido']?></h4>
</div>
<div class="col" style="margin-bottom:60px; margin-top:20px;">
    <div class="col-12">
        <?php
            $query = "select * from vendas_produtos where venda = '{$_POST['pedido']}' and deletado != '1'";
            $result = mysqli_query($con, $query);
            $valor_total = 0;
            $n = mysqli_num_rows($result);
            while($d = mysqli_fetch_object($result)){

                $pedido = json_decode($d->produto_json);
                $sabores = false;
                //print_r($pedido)
                $ListaPedido = [];
                for($i=0; $i < count($pedido->produtos); $i++){
                    $ListaPedido[] = $pedido->produtos[$i]->descricao;
                }
                if($ListaPedido) $sabores = implode(', ', $ListaPedido);
        ?>
        <div class="card bg-light mb-3" style="padding-bottom:40px;">
            <div class="card-body">

                <h5 class="card-title" style="paddig:0; margin:0; font-size:14px; font-weight:bold;">
                    <?=$d->produto_nome?>
                </h5>
                <!-- <p class="card-text" style="padding:0; margin:0;">
                    <small class="text-muted"><?=$sabores?></small>
                </p> -->
                <p class="card-text" style="padding:0; margin:0; text-align:right">
                    R$ <?= number_format($d->valor_unitario, 2, ',', '.') ?>
                </p>
                <p class="card-text" style="padding:0; margin:0; color:red; font-size:10px;">
                    <?= $d->produto_descricao?>
                </p>


            </div>
        </div>
        <?php
            $valor_total = ($valor_total + $d->valor_total);
            }
        ?>
    </div>
</div>
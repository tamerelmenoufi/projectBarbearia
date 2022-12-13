<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel','codVenda','ClienteAtivo']);

    $query = "select * from clientes_enderecos where cliente = '{$_SESSION['ClienteAtivo']}' and validacao = '1'";
    $result = mysqli_query($con, $query);
?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }

    .verde{
        color:green;
    }

    .titulo{
        cursor:pointer;
    }
</style>
<h4 class="Titulo<?=$md5?>">Lista de Endereços</h4>


<ul class="list-group">
<?php
    while($d = mysqli_fetch_object($result)){

        if(
            !$d->cep or
            !$d->rua or
            !$d->numero or
            !$d->bairro
        ){
            $blq = true;
        }else{
            $blq = false;
        }


?>
    <li class="list-group-item list-group-item-action titulo" cod="<?=$d->codigo?>" style="display: flex; justify-content: space-between;">
        <div>
            <i class="fa-solid fa-location-dot verde"></i> <?=$d->titulo?>
        </div>
        <div>
            <i class="fa-solid fa-motorcycle"></i> R$ 23,88
        </div>
    </li>
<?php
    }
?>
</ul>
<script>
    $(function(){

        Carregando('none');

        $(".titulo").click(function(){
            local_entrega = $(this).attr("cod");
            $.ajax({
                url:"src/vendas/compras.php",
                type:"POST",
                data:{
                    local_entrega,
                },
                success:function(dados){
                    $(".produtos_lista").html(dados);
                    let myOffCanvas = document.getElementById('offcanvasDireita');
                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    openedCanvas.hide();
                }
            });

        });

    })
</script>
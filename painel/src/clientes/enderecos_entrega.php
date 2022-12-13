<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);


    $query = "select * from clientes_enderecos where cliente = '{$_POST['cliente']}'";
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
        cursor:pointer;
    }
    .vermelho{
        color:red;
        cursor:pointer;
    }
    .bloqueio{
        color:#ccc;
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
    <li class="list-group-item opc" style="display: flex; justify-content: space-between;">
        <div class="<?=(($blq)?false:'titulo')?>" cod="<?=$d->codigo?>">
            <i class="<?=(($blq)?'bloqueio ':false)?>fa-solid fa-location-<?=(($d->validacao)?'dot verde':'pin-lock vermelho')?>"></i> <?=$d->titulo?>
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
            cod = $(this).attr("cod");
            $.ajax({
                url:"src/clientes/editar_endereco.php",
                type:"POST",
                data:{
                    cod,
                    cliente:'<?=$_POST['cliente']?>',
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });

        });

    })
</script>
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    $query = "select
                        a.*,
                        (select icon from produtos where categoria = a.codigo and situacao = '1' and deletado != '1' and icon != '' order by rand() limit 1) as icon_produto
                        from categorias a where a.deletado != '1' and a.situacao = '1' /*and a.categoria != 'COMBOS'*/ order by a.ordem";
    $result = mysqli_query($con, $query);
?>
<style>

.ms_categoria_scroll_palco {
    overflow-x: auto;
}
.ms_categoria_scroll {
   display: flex;
   flex-direction: row;
   justify-content: left;
   align-items: left;
   width: 100%;
   padding:0px;
   overflow:scroll;
}
.ms_categoria_scroll_card {
   min-width: 80px;
   text-align: center;
   border:0;
   background:transparent;
   margin:5px;
}
.ms_categoria_scroll_card div{
    position:relative;
    width:80px;
    height:80px;
    border-radius:50%;
    float:none;
    text-align:center;
    background-color:#f2e5d4;
    background-size:100%;
    background-position:center;
    background-repeat:no-repeat;
}
.ms_categoria_scroll_card p{
    position:relative;
    width:80px;
    height:auto;
    color:#fff;
    font-style: normal;
    font-size: 12px;
    line-height: 14px;
    text-align:center;
    margin-top:5px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

}
.ms_categoria_scroll::-webkit-scrollbar {
    display: none;
}

</style>


<div class="ms_categoria_scroll_palco">
  <div class="ms_categoria_scroll">
     <?php
     $cor = [
                '#eae49fbd',
                '#2677386b',
                '#13687594',
                '#dc35358a'
            ];
    $i=0;
    while ($d = mysqli_fetch_object($result) ) {

        if(is_file("../../painel/categorias/icon/{$d->icon}")){
            //$icone = "../painel/categorias/icon/{$d->icon}";
            $icone = "{$caminho_sis}/painel/".(($d->codigo == 8)?'combos':'produtos')."/icon/{$d->icon_produto}";
        }else{
            $icone = "{$caminho_sis}/painel/".(($d->codigo == 8)?'combos':'produtos')."/icon/{$d->icon_produto}";
        }

    ?>
    <div
        <?php
        if($d->codigo == 8){
        ?>
        local="src/produtos/combos.php?categoria=<?=$d->codigo?>"
        <?php
        }else{
        ?>
        local="src/produtos/produtos.php?categoria=<?=$d->codigo?>"
        <?php
        }
        ?>
        janela="ms_popup_100"
        class="ms_categoria_scroll_card"
    >
        <div style="background-image:url(<?=$icone?>); <?=(($d->codigo == 8)?'background-color:#aa3a15':false)?>">
            <!-- <img  src="<?=$icone?>" style="margin-top:5px; width: 70px; height: auto; " /> -->
        </div>
        <p class="font-flam"><?=$d->categoria?></p>
    </div>
  <?php
    $i++;
    if($i == count($cor)) $i=0;
    }
  ?>
  </div>
</div>

<script>
    $(function(){
        Carregando('none');
        $(".ms_categoria_scroll_card").off('click').on('click',function(){

            AppPedido = window.localStorage.getItem('AppPedido');
            AppCliente = window.localStorage.getItem('AppCliente');

            if(!AppCliente || AppCliente === null || AppCliente === undefined){

                Carregando();
                $.ajax({
                    url:"componentes/ms_popup_100.php",
                    type:"POST",
                    data:{
                        local:"src/cliente/cadastro.php",
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });

            }else{

                local = $(this).attr('local');
                janela = $(this).attr('janela');
                Carregando();
                $.ajax({
                    url:"componentes/"+janela+".php",
                    type:"POST",
                    data:{
                        local,
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });

            }

        });
    })
</script>
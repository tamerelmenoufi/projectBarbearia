<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
        vl(['ProjectPainel']);
?>

<div style="background:#eee!important" >
<div id="paginaHomeTopo"></div>
<div id="paginaHomeLateral"></div>
<div id="paginaHomeLateralDireita"></div>
<div id="paginaHome"></div>

</div>

<style>
body {

    background: #eee;
}



</style>

<script>

    function Abrir(u, l){
        Carregando();
        $.ajax({
            url:u,
            success:function(dados){
                $(`#${l}`).html(dados);
                Carregando('none');
            }
        });
    }

    $(function(){
        pags = [
            ['src/componentes/menu_topo/menu.php','paginaHomeTopo'],
            ['src/componentes/menu_lateral/menu.php','paginaHomeLateral'],
            ['src/componentes/menu_lateral_direita/menu.php','paginaHomeLateralDireita'],
            ['src/dashboard/index.php','paginaHome'],
            ];

        for(i=0;i<pags.length;i++){
            url = pags[i][0];
            local = pags[i][1];
            Abrir(url, local);
        }

    })
</script>
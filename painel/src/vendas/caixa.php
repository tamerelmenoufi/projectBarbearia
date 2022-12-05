<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?>
<style>

</style>
<div class="p-3" style="position:fixed; left:0px; top:65px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-clock" style="margin-right:10px;"></i>Profissional</span>
                <div class="form-control dados_profissionais" codigo="" ></div>
                <button
                        class="btn btn-outline-secondary listar_profissionais"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                        type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-check" style="margin-right:10px;"></i>Cliente</span>
                <div class="form-control dados_clientes" codigo=""></div>
                <button
                        class="btn btn-outline-secondary listar_clientes"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                        type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
    </div>
    <div class="row categorias_list"></div>
</div>
<div class="p-3" style="position:fixed; left:0px; top:235px; right:0px; bottom:0px; overflow:auto;">
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-produtos" data-bs-toggle="tab" data-bs-target="#painel-vendas" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="home-compras" data-bs-toggle="tab" data-bs-target="#painel-vendas" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active produtos_lista" id="painel-vendas" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        Carregando('none');

        $.ajax({
            url:"src/vendas/categorias.php",
            success:function(dados){
                $(".categorias_list").html(dados);
            }
        });

        $.ajax({
            url:"src/vendas/produtos.php",
            success:function(dados){
                $(".produtos_lista").html(dados);
            }
        });

        $(".listar_profissionais").click(function(){
            Carregando();
            $.ajax({
                url:"src/vendas/lista_profissionais.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })

        $(".listar_clientes").click(function(){
            Carregando();
            $.ajax({
                url:"src/vendas/lista_clientes.php",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        })

    })
</script>
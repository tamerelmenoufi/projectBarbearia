<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <img src="img/logo-topo.png" style="height:100px;" alt="">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <h5>Project - Barbearia</h5>

    <div class="row mb-1">
      <div class="col">
        <a url="src/dashboard/index.php" class="text-decoration-none" data-bs-dismiss="offcanvas" aria-label="Close">
          <i class="fa-solid fa-clipboard-list"></i> Dashboard
        </a>
      </div>
    </div>


    <div class="row mb-1">
      <div class="col">
        <a url="src/vendas/index.php" class="text-decoration-none" data-bs-dismiss="offcanvas" aria-label="Close">
          <i class="fa-solid fa-clipboard-list"></i> Vendas
        </a>
      </div>
    </div>


    <div class="row mb-1">
      <div class="col">
        <a url="src/colaboradores/index.php" class="text-decoration-none" data-bs-dismiss="offcanvas" aria-label="Close">
          <i class="fa-solid fa-clipboard-list"></i> Usuários/Colaboradores
        </a>
      </div>
    </div>

    <div class="row mb-1">
      <div class="col">
        <a url="src/clientes/index.php" class="text-decoration-none" data-bs-dismiss="offcanvas" aria-label="Close">
          <i class="fa-solid fa-clipboard-list"></i> Clientes
        </a>
      </div>
    </div>

    <div class="row mb-1">
      <div class="col">
        <a url="src/produtos_categorias/index.php" class="text-decoration-none" data-bs-dismiss="offcanvas" aria-label="Close">
          <i class="fa-solid fa-clipboard-list"></i> Produtos / Serviços
        </a>
      </div>
    </div>


  </div>
</div>

<script>
  $(function(){
    $("a[url]").click(function(){
      Carregando();
      url = $(this).attr("url");
      $.ajax({
        url,
        success:function(dados){
          $("#paginaHome").html(dados);
        }
      });
    });
  })
</script>
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
    vl(['ProjectPainel']);
?>
<style>
  .MenuLogin{
    min-width:250px;
    margin:0 10px 0 10px;
  }
</style>


<nav class="navbar navbar-expand bg-light">
  <div class="container-fluid">
    <div data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
     
    

      <i class="fa-solid fa-bars"></i>
    </div>

    <div  class="d-none d-sm-block">
    <img src="img/logomenup.png" style="height:40px; margin-right:20px;" >
</div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarScroll">

        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">

          </li>
        </ul>

        <ul class="navbar-nav">
        <a class="nav-link dropdown-toggle d-none d-sm-block" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?=$_SESSION['ProjectPainel']->nome?> <i class="fa-solid fa-user"></i>
                </a>

 <a class="nav-link dropdown-toggle d-block d-sm-none" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fa-solid fa-user"></i>
                </a>
                
            <li class="nav-item dropdown">
                
                <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="navbarScrollingDropdown">
                    <li class="MenuLogin">
                      <ul class="list-group  list-group-flush">
                        <!-- <li class="list-group-item" aria-disabled="true">
                          <i class="fa-solid fa-user"></i> Dados Pessoais
                        </li>
                        <a class="list-group-item" href='#'>
                          <i class="fa-solid fa-key"></i> Senha de Acesso
                        </a>
                        <li class="list-group-item">
                          <i class="fa-solid fa-calendar-check"></i> Atividades
                        </li> -->
                        <a class="list-group-item" href='?s=1'>
                          <i class="fa-solid fa-right-from-bracket"></i> Sair
                        </a>
                      </ul>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
  </div>
</nav>



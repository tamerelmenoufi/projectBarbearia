  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logobarb.png" alt="">
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Principal</a></li>
          <li><a class="nav-link scrollto" href="index.php#servicos">Serviços</a></li>
          <li><a class="nav-link scrollto" href="index.php#produtos">Produtos</a></li>
          <li><a class="nav-link scrollto" href="index.php#osmanos">Os Manos</a></li>
          <li><a class="nav-link scrollto" href="index.php#team">Time</a></li>
          <li><a class="nav-link scrollto" href="index.php#experiencias-home">Experiências</a></li>
          <li><a class="nav-link scrollto" href="index.php#eventos">Eventos</a></li>
          <li><a
                class="nav-link scrollto agendaMenu"
                href="#"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight"
              >Agenda</a></li>
          <li><a class="nav-link scrollto" href="index.php#contact">Contatos</a></li>
        </ul>

        <i class="bi bi-list mobile-nav-toggle d-none"></i>

      </nav>
      <!-- <a class="btn-getstarted scrollto" href="index.php#about"><i class="fa-regular fa-hand-pointer"></i> Iniciar</a> -->

    </div>
  </header><!-- End Header -->

  <script>

    $(function(){

      $(".agendaMenu").click(function(){
          $.ajax({
                url:"calendario/home.php",
                type:"POST",
                success:function(dados){
                  $(".LateralDireita").html(dados);
                },
                error:function(){
                  alert('erro')
                }
            });
        });

    })
  </script>
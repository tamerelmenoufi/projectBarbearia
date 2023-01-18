<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?><div
    class="offcanvas offcanvas-end"
    data-bs-backdrop="static"
    tabindex="-1"
    id="offcanvasDireita"
    aria-labelledby="offcanvasDireitaLabel"
    style="--bs-offcanvas-width:500px;"
  >
  <div class="offcanvas-header">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body LateralDireita"></div>
</div>


<script>


 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    $("#offcanvasDireita").css("--bs-offcanvas-width","100%")
  }
 else {
    $("#offcanvasDireita").css("--bs-offcanvas-width","600px")
  }


</script>

<!-- <div class="d-flex flex-row justify-content-between" style="background-color:#583b1e; height:70px; position:fixed; left:0; top:0; width:100%; z-index:9;">
  <div></div>
  <div class="m-3" style="width:100px; height:100px; padding:5px; background-color:#6a4a2b; border-solid 2px #fff; border-radius:100%; z-index:10; position:relative;">
    <img id="profile-img" style="width:90px;" class="profile-img-card" src="img/icone.png" />
  </div>
  <div></div>
</div> -->


<nav class="navbar bg-body-tertiary fixed-top" style="background-color:#583b1e; height:70px; left:0; top:0; width:100%; z-index:9;">
  <div class="container-fluid d-flex flex-row justify-content-between">
    <img id="profile-img" style="width:90px;" class="profile-img-card" src="img/icone.png" />
    <div class="text-white">
        <span>Serviços</span>
        <span>Produtos</span>
        <span>Equipe</span>
    </div>
  </div>
</nav>






<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel" style="margin-top:70px;">
  <!-- <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div> -->
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
    <img src="img/banner_site.jpg" class="w-100 d-none d-md-block" >
    <img src="img/banner_mobile.jpg" class="w-100 d-block d-sm-none" >
      <!-- <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div> -->
    </div>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>



<div class="m-3 p-3">
    <div class="row">
        <div class="col">



            <!-- <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Accordion Item #1
                </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Accordion Item #2
                </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                    Accordion Item #3
                </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">



                </div>
                </div>
            </div>
            </div> -->



            <div class="row">
                <?php

                $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' order by a.tipo desc";
                $result = mysqli_query($con, $query);
                $titulo = false;
                while($d = mysqli_fetch_object($result)){
                if($titulo != $d->categoria){
                ?>
                <div class="row">
                  <div class="col">
                  <h3 class="text-white"><?=$d->categoria_nome?></h3>
                  </div>
                </div>
                <?php
                $titulo = $d->categoria;
                }
                // for($i=0;$i<20;$i++){
                ?>
                    <!-- <div class="col-md-3 mb-3">
                      <div class="card h-100" style="background-color:#e9ecef">
                        <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" class="card-img-top w-80" alt="...">
                        <div class="card-body">

                        </div>
                        <div class="card-footer bg-dark text-white">
                            <h5 class="card-title"><?=$d->produto?></h5>
                            <p class="card-text"><?=$d->descricao?></p>
                            <small>
                              <?php
                                if($d->tipo == 's'){
                              ?>
                                <a
                                    href="#"
                                    class="btn btn-warning agenda"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasDireita"
                                    aria-controls="offcanvasDireita"
                                >R$ <?=number_format($d->valor, 2,',','.')?> Agendar</a>
                              <?php
                                }else{
                              ?>
                                <a
                                    href="#"
                                    class="btn btn-warning agenda"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasDireita"
                                    aria-controls="offcanvasDireita"
                                >R$ <?=number_format($d->valor, 2,',','.')?> Comprar</a>
                              <?php
                                }
                              ?>
                            </small>
                        </div>
                      </div>
                    </div> -->


                    <div class="col-md-4">
                      <div class="card mb-3" style="--bs-card-img-overlay-padding:0;">
                        <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" class="card-img" alt="...">
                        <div class="card-img-overlay w-100">
                          <div class="d-flex align-items-end h-100">
                            <div class="w-100" style="background-color:rgb(0,0,0,0.7);">
                              <h3 class="card-title text-center text-white w-100"><?=$d->produto?></h3>
                              <p class="card-text p-3 text-center text-white w-100">R$ <?=number_format($d->valor, 2,',','.')?></p>
                              <!-- <p class="card-text"><small>Last updated 3 mins ago</small></p> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                <?php
                }
                ?>
            </div>


            <div class="row">
              <div class="col">
              <h3 class="text-white">Os Manos</h3>
              </div>
            </div>
            <div class="row">
              <?php
              $query = "select * from colaboradores where codigo > 1 order by rand()";
              $result = mysqli_query($con, $query);
              while($d = mysqli_fetch_object($result)){
              // for($i = 0;$i < 6; $i++){
              ?>
              <div class="col-md-4">
                <div class="card text-bg-dark mb-3">
                  <img src="<?=$localPainel?>src/volume/colaboradores/<?=$d->foto?>" class="card-img" alt="...">
                  <div class="card-img-overlay">
                    <div class="d-flex align-items-end h-100">
                      <div class="w-100 p-3" style="background-color:rgb(0,0,0,0.7); border-radius:5px;">
                        <h3 class="card-title"><?=$d->nome?></h3>
                        <p class="card-text"><?=$d->especialidade?></p>
                        <!-- <p class="card-text"><small>Last updated 3 mins ago</small></p> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="col-md-4">
                <div class="card mb-3">
                  <div class="row g-0">
                    <div class="col-md-4">
                      <img src="https://media.istockphoto.com/id/1281247301/pt/vetorial/the-barber-avatar-icon-barbershop-and-hairdresser-haircutter-symbol-flat-icon-illustration.jpg?s=1024x1024&w=is&k=20&c=yWhDjdlYMHLLlKmVhlA6wlHvOjIbNG0Q5KUsDdffFmY=" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
              <?php
              }
              ?>
            </div>
        </div>
    </div>
</div>

<footer class="text-muted py-5" style="background-color:#2f2e2e; color:#fff!important;">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#" style="color:#fff!important; font-size:25px;">
        <i class="fa-solid fa-circle-up"></i>
      </a>
    </p>
    <h3>Os Manos Barbearia</h3>
    <p class="mb-1">Av. Djalma Batista, 370 - Chapada</p>
    <p class="float-end mb-0 text-white" style="font-size:25px;">
      <span style="margin-right:20px; font-size:12px;">A barbearia que faltava para você! Siga nossas redes sociais</span>
      <a href="https://wa.me/5592981423046" target="_blank" style="color:#fff!important;"><i class="fa-brands fa-whatsapp"></i></a>
      <a href="https://www.facebook.com/profile.php?id=100089104170088" target="_blank" style="color:#fff!important;"><i class="fa-brands fa-facebook"></i></a>
      <a href="https://www.instagram.com/osmanosbarbearia_/" target="_blank" style="color:#fff!important;"><i class="fa-brands fa-instagram"></i></a>
    </p>
  </div>
</footer>

<!-- <div class="card" style="width: 18rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">Go somewhere</a>
  </div>
</div> -->



<script>
    $(function(){
        Carregando('none');

        $(".agenda").click(function(){
          $.ajax({
                url:"calendario/agenda_cadastro.php",
                type:"POST",
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });

    })
</script>
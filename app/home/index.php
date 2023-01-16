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

<div class="d-flex flex-row justify-content-between" style="background-color:#2f2e2e; height:70px; position:fixed; left:0; top:0; width:100%; z-index:9;">
  <div></div>
  <div class="m-3" style="width:100px; height:100px; padding:5px; background-color:#2f2e2e; border-solid 2px #fff; border-radius:100%; z-index:10; position:relative;">
    <img id="profile-img" style="width:90px;" class="profile-img-card" src="img/icone.png" />
  </div>
  <div></div>
</div>



<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel" style="margin-top:70px;">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="https://angelbarber.com.br/wp-content/uploads/2022/11/4481117-copiar-Large-1536x863.jpg" class="d-block w-100"  style="height:500px;">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/barber-shop-banner-design-template-52465bab1b3737e87cf03a6c289c2d93_screen.jpg?ts=1648232423" class="d-block w-100"  style="height:500px;">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://www.barbabrava.com.br/wp-content/uploads/2020/10/como-escolher-barbearia-800x300.png" class="d-block w-100" style="height:500px;">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
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

                $query = "select * from produtos where situacao = '1' order by tipo desc";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){

                // for($i=0;$i<20;$i++){
                ?>
                    <div class="col-md-3 mb-3 bg-body-secondary">
                      <div class="card h-100">
                        <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" class="card-img-top" alt="...">
                        <!-- <div class="card-body">
                            <h5 class="card-title"><?=$d->produto?></h5>
                            <p class="card-text"><?=$d->descricao?></p>

                        </div> -->
                        <div class="card-footer bg-dark text-white">
                            <h5 class="card-title"><?=$d->produto?></h5>
                            <p class="card-text"><?=$d->descricao?></p>
                            <small>
                                <a
                                    href="#"
                                    class="btn btn-warning"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasDireita"
                                    aria-controls="offcanvasDireita"
                                >R$ <?=number_format($d->valor, 2,',','.')?> Agendar</a>
                            </small>
                        </div>
                      </div>
                    </div>
                <?php
                }
                ?>
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
      <a href="#">Back to top</a>
    </p>
    <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
    <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="/docs/5.3/getting-started/introduction/">getting started guide</a>.</p>
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

    })
</script>
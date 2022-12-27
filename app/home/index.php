

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
    </div>
    <div class="dropdown mt-3">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Dropdown button
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
  </div>
</div>




<div class="d-flex flex-row justify-content-between" style="background-color:#eee; height:70px; position:fixed; left:0; top:0; width:100%; z-index:9;">
  <div></div>
  <div class="m-3" style="width:100px; height:100px; padding:5px; background-color:#eee; border-solid 2px #fff; border-radius:100%; z-index:10; position:relative;">
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
            <div class="accordion" id="accordionPanelsStayOpenExample">
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

                    <div class="row">
                        <?php
                        for($i=0;$i<20;$i++){
                        ?>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <img src="https://img.irroba.com.br/filters:fill(fff):quality(95)/kreative/catalog/banner-barbearia/banner-barbearia-mod-2041/banner-barbearia-2042/banner-barbearia-2043/banner-barbearia-2043/banner-barbearia-mod-2045/banner-barbearia-mod-2046/banner-barbearia-mod-2045-foto-120190927145845.JPG" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">
                                        <?php
                                        for($j=$i;$j<3;$j++){
                                        ?>
                                        Some quick example text to build on the card title and make up the bulk of the card's content.
                                        <?php
                                        }
                                        ?>
                                    </p>

                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">L
                                        <a
                                            href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasExample"
                                            aria-controls="offcanvasExample"
                                        >Go somewhere</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


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
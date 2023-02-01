<?php
if($_GET['cod']){
  $query = "select * from banners where codigo = '{$_GET['cod']}'";
}else{
  $query = "select * from banners where situacao = '1' limit 2";
}
  $result = mysqli_query($con, $query);
?>
<!-- ======= Hero Section ======= -->
  <section id="hero" class="hero carousel  carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <?php
    $active = true;
    while($d = mysqli_fetch_object($result)){
    ?>
    <div class="carousel-item <?=(($active)?'active':false)?>">
            <img src="<?=$localPainel?>src/volume/banners/<?=$d->imagem?>" alt="" class="d-block w-100">
    </div><!-- End Carousel Item -->
    <?php
    $active = false;
    }
    ?>
    <!-- <div class="carousel-item">
      <div class="container">
        <div class="row justify-content-center gy-6">

          <div class="col-lg-5 col-md-8">
            <img src="assets/img/hero-carousel/hero-carousel-2.svg" alt="" class="img-fluid img">
          </div>

          <div class="col-lg-9 text-center">
            <h2>At vero eos et accusamus</h2>
            <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut.</p>
            <a href="#featured-services" class="btn-get-started scrollto ">Get Started</a>
          </div>

        </div>
      </div>
    </div>

    <div class="carousel-item">
      <div class="container">
        <div class="row justify-content-center gy-6">

          <div class="col-lg-5 col-md-8">
            <img src="assets/img/hero-carousel/hero-carousel-3.svg" alt="" class="img-fluid img">
          </div>

          <div class="col-lg-9 text-center">
            <h2>Temporibus autem quibusdam</h2>
            <p>Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt omnis iste natus error sit voluptatem accusantium.</p>
            <a href="#featured-services" class="btn-get-started scrollto ">Get Started</a>
          </div>

        </div>
      </div>
    </div> -->

    <a class="carousel-control-prev" href="#hero" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
    </a>

    <a class="carousel-control-next" href="#hero" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
    </a>

    <ol class="carousel-indicators" style="margin-bottom:2rem !important;"></ol>

  </section><!-- End Hero Section -->
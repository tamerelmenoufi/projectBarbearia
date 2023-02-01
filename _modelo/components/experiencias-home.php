    <!-- ======= Portfolio Section ======= -->
    <section id="experiencias-home" class="portfolio" data-aos="fade-up">

      <div class="container">

        <div class="section-header">
          <h2>Experiências</h2>
          <p>Conheça os nossos trabalhos!</p>
        </div>

      </div>

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="200">

        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

          <ul class="portfolio-flters">
            <li data-filter="*" class="filter-active">Todos</li>
            <!-- <li data-filter=".filter-app">App</li>
            <li data-filter=".filter-product">Product</li>
            <li data-filter=".filter-branding">Branding</li>
            <li data-filter=".filter-books">Books</li> -->
            <?php
            $query = "select * from portifolio_categorias where situacao = '1' order by titulo";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <li data-filter=".filter-app<?=$d->codigo?>"><?=$d->titulo?></li>
            <?php
            }
            ?>
          </ul><!-- End Portfolio Filters -->

          <div class="row g-0 portfolio-container">

            <?php
            $query = "select a.* from portifolio a left join portifolio_categorias b on a.categoria = b.codigo where a.situacao = '1' and b.situacao = '1' order by b.titulo, a.titulo";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){
            ?>
            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-app<?=$d->categoria?>">
              <img src="<?=$localPainel?>src/volume/portifolio/<?=$d->imagem?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?=$d->titulo?></h4>
                <a href="<?=$localPainel?>src/volume/portifolio/<?=$d->imagem?>" title="<?=$d->titulo?>" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                
              </div>
            </div><!-- End Portfolio Item -->
            <?php
            }
            ?>

            <!-- <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-app">
              <img src="assets/img/portfolio/app-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 1</h4>
                <a href="assets/img/portfolio/app-1.jpg" title="App 1" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-product">
              <img src="assets/img/portfolio/product-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Product 1</h4>
                <a href="assets/img/portfolio/product-1.jpg" title="Product 1" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-branding">
              <img src="assets/img/portfolio/branding-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Branding 1</h4>
                <a href="assets/img/portfolio/branding-1.jpg" title="Branding 1" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-books">
              <img src="assets/img/portfolio/books-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Books 1</h4>
                <a href="assets/img/portfolio/books-1.jpg" title="Branding 1" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-app">
              <img src="assets/img/portfolio/app-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 2</h4>
                <a href="assets/img/portfolio/app-2.jpg" title="App 2" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-product">
              <img src="assets/img/portfolio/product-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Product 2</h4>
                <a href="assets/img/portfolio/product-2.jpg" title="Product 2" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-branding">
              <img src="assets/img/portfolio/branding-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Branding 2</h4>
                <a href="assets/img/portfolio/branding-2.jpg" title="Branding 2" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-books">
              <img src="assets/img/portfolio/books-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Books 2</h4>
                <a href="assets/img/portfolio/books-2.jpg" title="Branding 2" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-app">
              <img src="assets/img/portfolio/app-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 3</h4>
                <a href="assets/img/portfolio/app-3.jpg" title="App 3" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-product">
              <img src="assets/img/portfolio/product-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Product 3</h4>
                <a href="assets/img/portfolio/product-3.jpg" title="Product 3" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-branding">
              <img src="assets/img/portfolio/branding-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Branding 3</h4>
                <a href="assets/img/portfolio/branding-3.jpg" title="Branding 2" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item filter-books">
              <img src="assets/img/portfolio/books-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Books 3</h4>
                <a href="assets/img/portfolio/books-3.jpg" title="Branding 3" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div> -->

          </div><!-- End Portfolio Container -->

        </div>


       
    </section><!-- End Portfolio Section -->

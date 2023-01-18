<!-- ======= Featured Services Section ======= -->
<section id="featured-services" class="featured-services">
      <div class="container">

        <div class="row gy-4">
        <?php
              $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' order by a.tipo desc";
              $result = mysqli_query($con, $query);
              $titulo = false;
              while($d = mysqli_fetch_object($result)){
            ?>
          <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-activity icon"></i></div>
              <h4><a href="" class="stretched-link">Lorem Ipsum</a></h4>
              <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
            </div>
          </div><!-- End Service Item -->
          <?php
            }
            ?>

        </div>

      </div>
    </section><!-- End Featured Services Section -->
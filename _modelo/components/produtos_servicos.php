<!-- ======= Featured Services Section ======= -->
<section id="servicos" class="featured-services">
      <div class="container">

        <div class="row gy-4">
        <?php
              $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' order by a.tipo desc";
              $result = mysqli_query($con, $query);
              $titulo = false;
              while($d = mysqli_fetch_object($result)){
                if($titulo != $d->categoria){
        ?>
                  <div class="section-header">
                    <h2><?=$d->categoria_nome?></h2>
                  </div>
        <?php
                  $titulo = $d->categoria;
              }
        ?>
          <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
            <div class="service-item position-relative w-100">
              <div class="icon d-flex justify-content-between">
                <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" style="height:80px;" class="img-fluid" alt="">
                <span style="color:#a1a1a1; font-weight:bold;">R$ <?=number_format($d->valor,2,',','.')?></span>
              </div>
              <h4><a href="" class="stretched-link"><?=$d->produto?></a></h4>
              <p></p>
            </div>
          </div><!-- End Service Item -->
          <?php
            }
            ?>

        </div>

      </div>
    </section><!-- End Featured Services Section -->
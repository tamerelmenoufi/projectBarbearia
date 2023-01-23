<!-- ======= Servicos ======= -->
<section id="servicos" class="featured-services">
      <div class="container">
        <div class="section-header">
          <h2>Serviços</h2>
        </div>
        <div class="row gy-4">
        <?php
              $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' and a.tipo = 's' order by a.tipo desc";
              $result = mysqli_query($con, $query);
              while($d = mysqli_fetch_object($result)){
        ?>
          <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
            <div class="service-item position-relative w-100"

              style="
                  background-image: url(<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>);
                  background-size:contain;
                  background-repeat:no-repeat;
                  background-position:center center;
                 "
            >
              <div class="icon d-flex justify-content-end">
                <!-- <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" style="height:80px;" class="img-fluid" alt=""> -->
                <span style="color:#a1a1a1; font-weight:bold;">R$ <?=number_format($d->valor,2,',','.')?></span>
              </div>
              <h4><a href="#servicos" class="stretched-link agenda_servico" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><?=$d->produto?></a></h4>
              <p></p>
            </div>
          </div><!-- End Service Item -->
          <?php
            }
            ?>

        </div>

      </div>
    </section><!-- End Featured Services Section -->



<!-- ======= Produtos ======= -->
<section id="produtos" class="featured-services">
      <div class="container">
        <div class="section-header">
          <h2>Produtos</h2>
        </div>
        <div class="row gy-4">
        <?php
              $query = "select a.*, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' and a.tipo='p' order by a.tipo desc";
              $result = mysqli_query($con, $query);
              while($d = mysqli_fetch_object($result)){
        ?>
          <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
            <div class="service-item position-relative w-100">
              <div class="icon d-flex justify-content-between">
                <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" style="height:80px;" class="img-fluid" alt="">
                <span style="color:#a1a1a1; font-weight:bold;">R$ <?=number_format($d->valor,2,',','.')?></span>
              </div>
              <h4><a href="#produtos" class="stretched-link"><?=$d->produto?></a></h4>
              <p></p>
            </div>
          </div><!-- End Service Item -->
          <?php
            }
            ?>

        </div>

      </div>
    </section><!-- End Featured Services Section -->



    <script>

      $(function(){
        $(".agenda_servico").click(function(){
          $.ajax({
                url:"calendario/agenda_cadastro.php",
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
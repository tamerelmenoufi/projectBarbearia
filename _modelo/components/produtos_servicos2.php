



    <!-- ======= Services Section ======= -->
    <section id="team" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Time</h2>
        </div>

        <div class="row gy-5">


        <?php
              $query = "select * from colaboradores where codigo > 1 order by rand()";
              $result = mysqli_query($con, $query);
              while($d = mysqli_fetch_object($result)){
              // for($i = 0;$i < 6; $i++){
        ?>

          <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="service-item">
              <div class="img">
                <img src="<?=$localPainel?>src/volume/colaboradores/<?=$d->foto?>" class="img-fluid" alt="" style="width:100%;">
              </div>
              <div class="details position-relative">
                <div class="icon">
                  <i class="bi bi-activity"></i>
                </div>
                <a
                    href="#XXXX" class="stretched-link colaborador"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight"
                    colaborador="<?=$d->codigo?>"
                >
                  <h3><?=$d->nome?></h3>
                </a>
                <p><?=$d->especialidade?></p>
              </div>
            </div>
          </div><!-- End Service Item -->
          <?php
            }
          ?>

        </div>

      </div>
    </section><!-- End Services Section -->


    <script>

$(function(){
    $(".colaborador").click(function(){
      colaborador = $(this).attr("colaborador");
      $.ajax({
            url:"colaboradores/ver_colaborador.php",
            type:"POST",
            data:{
              colaborador
            },
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




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
                <a  href="#XXX"
                    class="stretched-link ver_produto"
                    cod="<?=$d->codigo?>"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight"
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
  $(".ver_produto").click(function(){
    cod = $(this).attr("cod");
    $.ajax({
          url:"produtos/ver_produto.php",
          type:"POST",
          data:{
            cod
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
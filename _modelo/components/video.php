    <!-- ======= On Focus Section ======= -->
    <section id="onfocus" class="onfocus" style="margin-top:80px;">
      <div class="container-fluid p-0" data-aos="fade-up">

        <div class="row g-0">
          <div class="col-lg-6 video-play position-relative">
            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
          </div>
          <div class="col-lg-6">
            <div class="content d-flex flex-column justify-content-center h-100">
              <h3>Os Manos Barbearia</h3>
              <p class="fst-italic">
                A barbearia que faltava para você!.
              </p>
              <ul>
                <li><i class="bi bi-check-circle"></i> Funcionamos de segunda a sábado, de 9h às 20h.</li>
                <li><i class="bi bi-check-circle"></i> Aqui tem Barba Feita + Cerveja Gelada.</li>
                <li><i class="bi bi-check-circle"></i> Agende sua visita pelo nosso aplicativo, no dia e horário de sua preferência.</li>
              </ul>
              <!-- <a href="#" class="read-more align-self-start"
                          data-bs-toggle="offcanvas"
                          data-bs-target="#offcanvasRight"
                          aria-controls="offcanvasDireita"
              ><span>Read More</span><i class="bi bi-arrow-right"></i></a> -->

              <a href="#" class="read-more align-self-start agenda" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span>Agendar aqui</span><i class="bi bi-arrow-right"></i></a>


            </div>
          </div>
        </div>

      </div>
    </section><!-- End On Focus Section -->

    <script>
    $(function(){
        // Carregando('none');

        $(".agenda").click(function(){
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
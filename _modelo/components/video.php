    <!-- ======= On Focus Section ======= -->
    <section id="onfocus" class="onfocus" style="margin-top:80px;">
      <div class="container-fluid p-0" data-aos="fade-up">

        <div class="row g-0">
          <div class="col-lg-6 video-play position-relative">
            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
          </div>
          <div class="col-lg-6">
            <div class="content d-flex flex-column justify-content-center h-100">
              <h3>Voluptatem dignissimos provident quasi corporis</h3>
              <p class="fst-italic">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                magna aliqua.
              </p>
              <ul>
                <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
              </ul>
              <!-- <a href="#" class="read-more align-self-start"
                          data-bs-toggle="offcanvas"
                          data-bs-target="#offcanvasRight"
                          aria-controls="offcanvasDireita"
              ><span>Read More</span><i class="bi bi-arrow-right"></i></a> -->

              <a href="#" class="read-more align-self-start agenda" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span>Read More</span><i class="bi bi-arrow-right"></i></a>


            </div>
          </div>
        </div>

      </div>
    </section><!-- End On Focus Section -->

    <script>
    $(function(){
        Carregando('none');

        $(".agenda").click(function(){
          $.ajax({
                url:"calendario/agenda_cadastro.php",
                type:"POST",
                success:function(dados){
                  alert('passou')
                    $(".LateralDireita").html(dados);
                }
            });
        });

    })
</script>
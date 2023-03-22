    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Time</h2>
          <p>
Nossa equipe é formada por profissionais comprometidos com excelência nas realizações de suas atividades e focados nas necessidades de nossos clientes.</p>
        </div>

        <div class="row gy-5">


        <?php
              $query = "select * from colaboradores where codigo > 1 and time = '1' order by rand()";
              $result = mysqli_query($con, $query);
              while($d = mysqli_fetch_object($result)){
              // for($i = 0;$i < 6; $i++){
        ?>
          <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="<?=$localPainel?>src/volume/colaboradores/<?=$d->foto?>" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <div class="social">
                  <?php
                    $midias_sociais = [
                      'facebook' => 'https://www.facebook.com/',
                      'twitter' => 'https://twitter.com/',
                      'instagram' => 'https://www.instagram.com/',
                      'youtube' => 'https://www.youtube.com/',
                      'linkedin' => 'https://www.linkedin.com/',
                      'whatsapp' => 'https://api.whatsapp.com/send?phone='
                    ];

                    foreach($midias_sociais as $ind => $url){
                      if($midias->$ind){
                  ?>
                  <a href="<?=$url.$midias->$ind?>" target="_black"><i class="bi bi-<?=$ind?>"></i></a>
                  <?php
                      }
                    }
                  ?>
                  <!-- <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a> -->
                </div>
                <h4><?=$d->nome?></h4>
                <span><?=$d->especialidade?></span>
              </div>
            </div>
          </div>
          <?php
            }

            /*
          ?>

          <!-- End Team Member -->

          <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                <h4>Sarah Jhonson</h4>
                <span>Programadora Senior</span>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="600">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                <h4>William Anderson</h4>
                <span>Designer de Web</span>
              </div>
            </div>
          </div><!-- End Team Member -->
            <?php
            //*/
            ?>
        </div>

      </div>
    </section><!-- End Team Section -->
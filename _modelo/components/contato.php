<?php

    $query = "select * from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $c = json_decode($d->contato);

?><!-- ======= Contact Section ======= -->
    <style>
      .contact .php-email-form textarea {
        padding: 10px 12px;
        height: 115px!important;
      }
    </style>

    <section id="contact" class="contact">
      <div class="container">

        <div class="section-header">
          <h2>Contatos</h2>

        </div>

      </div>

      <div class="exibir_mapa">
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe> -->
      </div><!-- End Google Maps -->

      <div class="container">

        <div class="row gy-5 gx-lg-5">

          <div class="col-lg-4">

            <div class="info">
              <h3>Entre em contato</h3>




              <div class="info-item d-flex">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h4>E-mail:</h4>
                  <p><?=$c->email?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-phone flex-shrink-0"></i>
                <div>
                  <h4>Telefone:</h4>
                  <p><?=$c->telefone?></p>
                </div>
              </div><!-- End Info Item -->

            </div>

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nome Completo" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required>
                </div>
              </div>

              <div class="form-group mt-3">
                <textarea class="form-control" name="message" placeholder="Sua mensagem" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Sua mensagem foi enviada. Obrigado!</div>
              </div>
              <div class="text-center"><button type="submit">Enviar </button></div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>
    </section><!-- End Contact Section -->


    <script>
      $(function(){
        $.ajax({
          url:"plugins/visualizar_mapa.php",
          success:function(dados){
            $(".exibir_mapa").html(dados);
          }
        });
      })
    </script>
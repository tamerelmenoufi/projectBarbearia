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

      <div class="">
        <iframe src="<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.9342913523174!2d-60.027689584222976!3d-3.1120879350110138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x926c051e5797af1f%3A0x15df2fe63677b86b!2sOs%20Manos%20Barbearia!5e0!3m2!1spt-BR!2sbr!4v1674148746058!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>" frameborder="0" allowfullscreen></iframe> 
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
<?php

  $query = "select * from paginas_topicos where situacao = '1'";
  $result = mysqli_query($con, $query);
  $d = mysqli_fetch_object($result);

  $topicos = json_decode($d->topicos);

?>

<!-- ======= About Section ======= -->
<section id="conheca" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?=$d->titulo?></h2>
          <p><?=$d->descricao?></p>
        </div>

        <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-5">
            <div class="about-img">
              <img src="<?=$localPainel?>src/volume/paginas_topicos/<?=$d->imagem?>" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-lg-7">
            <h3 class="pt-0 pt-lg-5"><?=$d->subtitulo?></h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <?php
              foreach($topicos->titulo as $i => $tipico){
              ?>
              <li><a class="nav-link <?=(($i == 0)?'active':false)?>" data-bs-toggle="pill" href="#tab<?=($i+1)?>"><?=$tipico?></a></li>
              <?php
              }
              ?>
            </ul><!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">


            <?php
            foreach($topicos->descricao as $i => $descricao){
            ?>
            <div class="tab-pane fade show <?=(($i == 0)?'active':false)?>" id="tab<?=($i+1)?>">
              <p class="fst-italic"><?=$descricao?></p>
            </div>
            <?php
            }
            ?>


              <!-- <div class="tab-pane fade show active" id="tab1">




              <p class="fst-italic">A PROJECT é uma empresa pautada no desenvolvimento de soluções, execução de projetos e treinamento.</p>
              <p class="fst-italic">Entendemos que o mercado cada vez mais globalizado se encontra em constante evolução, necessitando cada vez mais de produtos e serviços, no tempo e no local exato, ao menor custo possível.</p>
              <p class="fst-italic">Contamos com uma equipe sólida e experiente que persegue o sucesso de forma conjunta, e que entende que a completude e somatório dos esforços entre as partes é fundamental.</p>
              <p class="fst-italic">A atuação da PROJECT se dá tanto no privado, quanto no meio público. No segmento privado, a capacidade técnica de nosso quadro nos credencia a entregarmos resultados brilhantes, sempre com presteza no atendimento e responsabilidade ímpar na execução. No público, atuamos com uma equipe campeã, que capta e participa de processos licitatórios em todas as esferas do setor, abarcando todas as suas modalidades e tipos, entregando sempre a sociedade um serviço final de ótima qualidade.</p>
              <p class="fst-italic">Para tanto, afim de atingir os objetivos que nos propomos nossa atuação se dá sempre de forma ética e íntegra, respeitando as normas e leis vigentes.</p> -->



                <!-- <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Repudiandae rerum velit modi et officia quasi facilis</h4>
                </div>
                <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi dolorum non eveniet magni quaerat nemo et.</p>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Incidunt non veritatis illum ea ut nisi</h4>
                </div>
                <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at. Dolorem quo tempora. Quia et perferendis.</p>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Omnis ab quia nemo dignissimos rem eum quos..</h4>
                </div>
                <p>Eius alias aut cupiditate. Dolor voluptates animi ut blanditiis quos nam. Magnam officia aut ut alias quo explicabo ullam esse. Sunt magnam et dolorem eaque magnam odit enim quaerat. Vero error error voluptatem eum.</p> -->

              <!-- </div> -->
              <!-- End Tab 1 Content -->

              <!-- <div class="tab-pane fade show" id="tab2">

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Missão</h4>
                </div>
                <p>Se destacar no segmento privado e público, atuando no processo como agente facilitador e provedor de meios técnicos para atividade finalística requerida.</p>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Visão</h4>
                </div>
                <p>Apresentar aos clientes soluções técnicas viáveis, se posicionando sempre de maneira transparente e íntegra, sendo para o mercado nacional um referencial de probidade e aptidão no desenvolvimento da sua atividade.</p>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Valores</h4>
                </div>
                <i class="fa-solid fa-check-double" style="font-size:10px; margin-left:25px;"></i> Cooperação<br>
                <i class="fa-solid fa-check-double" style="font-size:10px; margin-left:25px;"></i> Aprimoramento<br>
                <i class="fa-solid fa-check-double" style="font-size:10px; margin-left:25px;"></i> Integridade<br>
                <i class="fa-solid fa-check-double" style="font-size:10px; margin-left:25px;"></i> Qualidade</p>

              </div> -->
              <!-- End Tab 2 Content -->

              <!-- <div class="tab-pane fade show" id="tab3">

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Melhoria Contínua</h4>
                </div>
                <p>Realizamos regularmente investimentos na capacitação e na busca por processos ágeis, viáveis e seguros para a organização e seus colaboradores, de modo que, os seus serviços sejam realizados com a maior eficiência possível.</p>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Responsabilidade</h4>
                </div>
                <p>Atuar com zelo em detrimento das normas legais ambientais, jurídicas e de segurança do trabalho, sendo uma forte referência nos preceitos ora estabelecidos, fortalecendo e ratificando cotidianamente o compliance.</p>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Compromisso Social</h4>
                </div>
                <p>Racionalizar o uso dos recursos naturais e inserir a comunidade nos projetos, ao ponto que, o meio e o fim sejam um elo indissociável de bem feitoria ao meio ambiente e crescimento humano em aspectos diversos.</p>

              </div> -->
              <!-- End Tab 3 Content -->


            </div>

          </div>

        </div>

      </div>
    </section><!-- End About Section -->
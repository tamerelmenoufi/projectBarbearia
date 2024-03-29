<!-- ======= Produtos ======= -->
<section id="produtos" class="featured-services">
      <div class="container">
        <div class="section-header">
          <h2>Produtos</h2>
        </div>
        <div class="row gy-4">
        <?php
              $query = "select a.*, (estoque - vendas) as saldo, b.categoria as categoria_nome from produtos a left join produtos_categorias b on a.categoria = b.codigo where a.situacao = '1' and a.tipo='p' order by a.tipo desc";
              $result = mysqli_query($con, $query);
              while($d = mysqli_fetch_object($result)){
        ?>
          <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
            <div class="service-item position-relative w-100">
              <div class="icon d-flex justify-content-between">
                <img src="<?=$localPainel?>src/volume/produtos/<?=$d->imagem?>" style="height:80px; opacity:<?=(($d->saldo > 0)?'1':'0.3')?>;" class="img-fluid" alt="">
                <span style="color:<?=(($d->saldo)?'#a1a1a1':'red')?>; font-weight:bold;"><?=(($d->saldo > 0)?'R$ '.number_format($d->valor,2,',','.'):'Indisponível')?></span>
              </div>
              <h4><a
                    href="#XXX"
                    class="stretched-link <?=(($d->saldo > 0)?'ver_produto':false)?>"
                    cod="<?=$d->codigo?>"
                    data-bs-toggle="offcanvas"
                    data-bs-target="<?=(($d->saldo > 0)?'#offcanvasRight':false)?>"
                    aria-controls="offcanvasRight"
                    ><?=$d->produto?></a></h4>
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
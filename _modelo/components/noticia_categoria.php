    <!-- ======= Recent Blog Posts Section ======= -->
    <section id="recent-blog-posts" class="recent-blog-posts">

    <style>


a:hover {
    color: var(--color-links-hover);
    text-decoration: none;
}
.btn-outline-info:hover {
    color: #fffefe;
    background-color:#bd9169!important;
    border-color:#bd9169!important;
}


.btn-check:active+.btn-outline-info:focus, .btn-check:checked+.btn-outline-info:focus, .btn-outline-info.active:focus, .btn-outline-info.dropdown-toggle.show:focus, .btn-outline-info:active:focus {
    box-shadow: 0 0 0 0.25rem rgb(166 135 107);}

.btn-outline-info {
    color: #fffefe;
    background-color: #a6876b!important;
    border-color: #a6876b!important;
}
</style>

    <!-- ======= Breadcrumbs ======= -->
    <div style="font-weight:450;#a6876b!important;color:#fff" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2 style="">Todos os Eventos</h2>

        </div>

      </div>
    </div><!-- End Breadcrumbs -->
 <div class="container aos-init aos-animate">
        <div class="row">

          <?php
          $query = "select * from noticias where situacao = '1'";
          $result = mysqli_query($con, $query);
          while($d = mysqli_fetch_object($result)){
          ?>

          <div style="margin-top:15px" class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="post-box">
              <div class="post-img"><img src="<?=$localPainel?>src/volume/noticias/<?=$d->imagem?>" class="img-fluid" alt=""></div>
              <!-- <div class="meta">
                <span class="post-date">Tue, December 12</span>
                <span class="post-author"> / Julia Parker</span>
              </div> -->
              <h3 class="post-title" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?=$d->titulo?></h3>
              <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"><?=strip_tags(str_replace('<',' <',str_replace('>','> ',$d->materia)))?></p>
              <a href="noticia.php?cod=<?=$d->codigo?>" class="readmore stretched-link"><span>Leia Mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <?php
          }
          ?>

          <!-- <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="post-box">
              <div class="post-img"><img src="assets/img/blog/blog-2.jpg" class="img-fluid" alt=""></div>
              <div class="meta">
                <span class="post-date">Fri, September 05</span>
                <span class="post-author"> / Mario Douglas</span>
              </div>
              <h3 class="post-title">Et repellendus molestiae qui est sed omnis voluptates magnam</h3>
              <p>Voluptatem nesciunt omnis libero autem tempora enim ut ipsam id. Odit quia ab eum assumenda. Quisquam omnis aliquid necessitatibus tempora consectetur doloribus...</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="600">
            <div class="post-box">
              <div class="post-img"><img src="assets/img/blog/blog-3.jpg" class="img-fluid" alt=""></div>
              <div class="meta">
                <span class="post-date">Tue, July 27</span>
                <span class="post-author"> / Lisa Hunter</span>
              </div>
              <h3 class="post-title">Quia assumenda est et veritatis aut quae</h3>
              <p>Quia nam eaque omnis explicabo similique eum quaerat similique laboriosam. Quis omnis repellat sed quae consectetur magnam veritatis dicta nihil...</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div> -->

        </div>


        <!-- <center style="margin-top:15px">
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active" aria-current="page">
      <a class="page-link" href="#">2</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Proximo</a>
    </li>
  </ul>
</nav>
        </center> -->


        <div class="col-lg-12" style="padding:10px">

    <button style="margin-top:10px"  type="button"  class="float-end  botaoazul">
                 <a style="color:#fff" href="javascript:history.back()">Voltar</a></button>
 </div>
</div>

      </div>

    </section><!-- End Recent Blog Posts Section -->
<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_GET['s']){
        $_SESSION = [];
        header("location:./");
        exit();
    }

    if($_SESSION['ProjectPainel']){
        $url = "src/home/index.php";
    }else{
        $url = "src/login/index.php";
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/icone.png">
    <title>Barbearia Os Manos</title>
    <?php
    include("lib/header.php");
    ?>
  </head>

  <style>
body {

    background: url(img/fundo-bar.jpg);
    no-repeat center fixed: ;
    background-size: auto auto;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}

.btn-primary {
    --bs-btn-color: #fff;
    --bs-btn-bg: #4a3019;
    --bs-btn-border-color: #4a3019;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #4a3019;
    --bs-btn-hover-border-color: #4a3019;
    --bs-btn-focus-shadow-rgb: 49,132,253;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #4a3019;
    --bs-btn-active-border-color: #4a3019;
    --bs-btn-active-shadow: inset 0 3px 5pxrgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #4a3019;
    --bs-btn-disabled-border-color: #4a3019;
}

</style>

  <body>

    <div class="Carregando">
        <div><i class="fa-solid fa-circle-notch fa-pulse"></i></div>
    </div>

    <div class="CorpoApp"></div>

    <?php
    include("lib/footer.php");
    ?>

    <script>
        $(function(){
            Carregando();
            $.ajax({
                url:"<?=$url?>",
                success:function(dados){
                    $(".CorpoApp").html(dados);
                }
            });
        })


        //Jconfirm
        jconfirm.defaults = {
            typeAnimated: true,
            type: "blue",
            smoothContent: true,
        }

    </script>

  </body>
</html>
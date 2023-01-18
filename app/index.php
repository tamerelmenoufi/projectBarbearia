<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/icone.png">
    <title>Os Manos Barbearia</title>
    <?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/header.php");
    ?>
    <style>
        .CorpoApp{

        }
    </style>
  </head>


<style>
body {

background: url(img/fundo-bar-pc.jpg) no-repeat center fixed;
background-size: auto auto;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
}

    </style>

  <body>

    <div class="Carregando">
        <div><i class="fa-solid fa-circle-notch fa-pulse"></i></div>
    </div>

    <div class="CorpoApp"></div>

    <?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/footer.php");
    ?>

    <script>
        $(function(){
            Carregando();
            $.ajax({
                url:"home/index.php",
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
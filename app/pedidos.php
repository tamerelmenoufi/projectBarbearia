<?php
    include("./src/pedidos/conf.php");

    if($Uconf->codigo){
        $url = 'home/index.php';
    }else{
        $url = 'login/login.php';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ff0000"/>
    <title>APP</title>
    <?php include("../lib/header.php"); ?>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/app.css">


</head>
<body>
<div class="Carregando">
    <span>
        <i class="fa-solid fa-spinner"></i>
    </span>
</div>

<div class="ms_corpo"></div>

<?php include("../lib/footer.php"); ?>



<script src="<?= "js/app.js?" . date("YmdHis"); ?>"></script>
<script src="<?= "js/wow.js"; ?>"></script>

<script>
    $(function () {
        $.ajax({
            url: "src/pedidos/<?=$url?>",
            success: function (dados) {
                $(".ms_corpo").html(dados);
            }
        });
    })


    //Configurações globais

    //Jconfirm
    jconfirm.defaults = {
        theme: "modern",
        type: "blue",
        typeAnimated: true,
        smoothContent: true,
        draggable: false,
        animation: 'bottom',
        closeAnimation: 'top',
        animateFromElement: false,
        animationBounce: 1.5
    }

</script>
<form></form>
</body>
</html>
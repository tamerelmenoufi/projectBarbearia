<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['servico']) $_SESSION['servico'] = $_POST['servico'];
    // $_SESSION['cliente']  = false;
    if($_SESSION['cliente']){
        $url = "calendario/agenda_cadastro.php";
    }else{
        $url = "calendario/login.php";
    }

?>

<script>
    $(function(){

        $.ajax({
            url:"<?=$url?>",
            success:function(dados){
                $(".LateralDireita").html(dados);
            }
        });

    })
</script>
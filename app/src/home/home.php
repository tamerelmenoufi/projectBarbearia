<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_GET['cliente']) $_SESSION['AppCliente'] = $_GET['cliente'];
    if($_GET['pedido']) $_SESSION['AppPedido'] = $_GET['pedido'];
    if($_GET['venda']) $_SESSION['AppVenda'] = $_GET['venda'];

?>
<style>

</style>

<object home componente="ms_principal" ></object>

<script>

    //window.localStorage.setItem('ms_cli_codigo','2');

    $(function(){
        AppComponentes('home');
    })
</script>
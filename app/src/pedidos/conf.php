<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/bk/lib/includes.php");
    if($_SESSION['PedidosUsuario']) $Uconf = $_SESSION['PedidosUsuario'];
    else $Uconf = [];
    exit();
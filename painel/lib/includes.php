<?php
    session_start();

    include("/appinc/cBarb.php");
    $md5 = md5(date("YmdHis"));

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/";

    $localPainel = "https://app.osmanosbarbearia.com.br/";
    $localSite = "https://osmanosbarbearia.com.br/";

    include("/appinc/connect.php");
    $con = AppConnect($cBarb['banco']['DATABASE']);

    // include("/appinc/connect.php");
    include("fn.php");

    include("vendor/rede/classes.php");
    include("vendor/bee/classes.php");


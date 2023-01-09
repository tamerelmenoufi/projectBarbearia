<?php
    session_start();

    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

    include("/appinc/cBarb.php");
    $md5 = md5(date("YmdHis"));

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/app/projectBarbearia/painel/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/app/projectBarbearia/site/";

    include("/appinc/connect.php");
    $con = AppConnect($cBarb['banco']['DATABASE']);

    // include("/appinc/connect.php");
    include("fn.php");

    include("vendor/rede/classes.php");
    include("vendor/bee/classes.php");


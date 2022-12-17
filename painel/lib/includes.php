<?php
    session_start();

    include("/appinc/cBarb.php");
    $md5 = md5(date("YmdHis"));

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/app/projectBarbearia/painel/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/app/projectBarbearia/site/";

    include("/appinc/connect.php");
    $con = AppConnect('barbearia');

    // include("/appinc/connect.php");
    include("fn.php");

    include("vendor/rede/classes.php");
    include("vendor/bee/classes.php");


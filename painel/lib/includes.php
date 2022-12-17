<?php
    session_start();

    // include("connect_local.php");
    $md5 = md5(date("YmdHis"));

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/app/projectBarbearia/painel/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/app/projectBarbearia/site/";

    include("/appinc/connect.php");
    $con = AppConnect('barbearia');

    // include("/appinc/connect.php");
    include("fn.php");

    include("/rede/classes.php");
    include("/bee/classes.php");


<?php
    if($_GET['validar']){
        include("../../../lib/vendor/captcha/validar.php");
    }else{
        include("../../../lib/vendor/captcha/captcha.php");
    }